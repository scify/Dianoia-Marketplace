<template>
    <div class="container-fluid p-0">
        <div class="row justify-content-start mb-2">
            <div class="col-md-8 col-sm-12">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div v-for="language in contentLanguages" class="col-md-3 col-sm-12">
                            <button @click="setContentLanguage(language)"
                                    class="w-100 btn btn-secondary"
                                    v-bind:class="{ selected: language.id === selectedContentLanguage.id }">
                                {{ language.name }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="search"><i class="fa fa-search"></i>
                    <input
                        @keyup.stop="search($event.target.value)"
                        type="text" class="form-control"
                        :placeholder="searchPlaceholder">
                    <div v-if="searchLoading" class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="row justify-content-start mb-3" id="types-checkboxes">
            <div class="col-md-8">
                <div class="form-check form-check-inline"
                     v-for="(resourceType, index) in resourceTypes"
                     :key="index">
                    <input class="form-check-input" type="checkbox" :id="'checkbox_' + index"
                           v-model="resourceType.checked"
                           v-on:change="getResources">
                    <label class="form-check-label" :for="'checkbox_' + index">
                        {{ resourceType.name }}
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="note">
                    {{ trans('messages.patient_cards_note') }}
                </p>
            </div>
        </div>
        <div class="row mt-5" v-if="loadingResources">
            <div class="col justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5" v-if="filteredResources.length">
            <div class="col-lg-4 col-md-4 col-sm-12 mb-3" v-for="(resource, index) in filteredResources" :key="index">
                <exercise
                    :user="user ? user : {}"
                    :user-id-to-get-content="userIdToGetContent"
                    :resource="resource"
                    :is-admin="isAdmin"
                    :approve-resources="approveResources">
                </exercise>

            </div>
        </div>
        <div class="row mt-5" v-if="!filteredResources.length && !loadingResources">
            <h5>{{ trans('messages.no_resource_packages_available') }}</h5>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    mounted() {
        this.getContentLanguages();
    },
    props: {
        user: {
            type: Object,
            default: function () {
                return {}
            }
        },
        resourceTypes: {
            type: Array,
            default: function () {
                return []
            }
        },
        userIdToGetContent: Number,
        resourcesStatuses: {
            type: Array,
            default: function () {
                return []
            }
        },
        isAdmin: String,
        resourceType: String,
        approveResources: Number,
        resourcesRoute: String
    },
    data: function () {
        return {
            // resourcesRoute: '',
            contentLanguages: [],
            selectedContentLanguage: {},
            loadingResources: false,
            filteredResources: [],
            maxRating: 5,
            searchPlaceholder: window.translate('messages.search_resources_package'),
            searchLoading: false
        }
    },
    methods: {
        ...mapActions([
            'get',
            'handleError'
        ]),
        setContentLanguage(language) {
            this.selectedContentLanguage = language;
            this.getResources();
        },
        getContentLanguages() {
            this.get({
                url: route('content_languages.get'),
                urlRelative: false
            }).then(response => {
                this.contentLanguages = response.data;
                this.selectedContentLanguage = this.contentLanguages[0];
                this.getResources();
            });
        },
        getResources() {
            this.loadingResources = true;
            this.resources = [];
            this.filteredResources = [];

            let url = this.resourcesRoute + '?lang_id=' + this.selectedContentLanguage.id;
            if (this.userIdToGetContent) {
                url += ('&user_id_to_get_content=' + this.userIdToGetContent);
            }
            if (this.resourceTypes.length) {
                url += '&type_ids=' + _.map(_.filter(this.resourceTypes, r => r.checked), 'id').join();
            }
            url += '&status_ids=' + _.map(this.resourcesStatuses).join();
            url += '&is_admin=' + this.isAdmin;
            console.log('get url')
            console.log(url);
            this.get({
                url: url,
                urlRelative: false
            }).then(response => {
                this.resources = response.data;
                this.filteredResources = this.resources;
                let names = _.map(this.filteredResources, 'id')
                console.log(names);
                this.loadingResources = false;
            });
        },
        search(searchTerm) {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.searchLoading = true;
                this.filteredResources = _.filter(this.resources, function (p) {
                    return p.name.toLowerCase().includes(searchTerm.toLowerCase());
                });
                this.searchLoading = false;
            }, 500);
        },
    }
}


</script>

<style scoped lang="scss">
@import "resources/sass/common/variables";

.btn.selected {
    background-color:  var(--color-blue);;
}

</style>
