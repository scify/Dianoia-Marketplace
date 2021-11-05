<template>
        <div class="row mt-5" v-if="filteredResources.length">
            <div v-for="(resource, index) in filteredResources" :key="index">
                <exercise
                    :user="user ? user : {}"
                    :user-id-to-get-content="userIdToGetContent"
                    :resource="resource"
                    :is-admin="isAdmin"
                    :approve-resources="approveResources"
                    :languages="contentLanguages"
                    :types="contentTypes"
                    :difficulties="contentDifficulties"
                    :users="users">
                </exercise>
            </div>
        </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    mounted() {
        this.getContentLanguages();
        this.getContentTypes();
        this.getContentDifficulties();
        this.getUsers();
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
            contentTypes: [],
            contentDifficulties: [],
            users: [],
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
        getContentTypes(){
            console.log('types');
            this.get({
                url: route('content_types.get'),
                urlRelative: false
            }).then(response => {
                this.contentTypes = response.data;
                let types = _.map(this.contentTypes, 'name')
                console.log(types);
            });
        },
        getContentDifficulties(){
            console.log('difficulties');
            this.get({
                url: route('content_difficulties.get'),
                urlRelative: false
            }).then(response => {
                this.contentDifficulties = response.data;
                let difficulties = _.map(this.contentDifficulties, 'name')
                console.log(difficulties);
            });
        },
        getUsers(){
            console.log('users');
            this.get({
                url: route('users.get'),
                urlRelative: false
            }).then(response => {
                this.users = response.data;
                let user_names = _.map(this.users, 'name')
                console.log(user_names);
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
