<template>
    <div v-if="resource.id">
        <div class="exercise-template shadow content mb-5 mt-5">
            <div class="exercise-box" v-bind:class="[isCarerExercise() ? 'carer-template' :'patient-template']">
                <div class="exercise-title-row d-flex justify-content-between align-items-center">
                    <div style="padding-left:15px;padding-top:15px;">
                        <p class="title"> {{resource.name}} </p>
                        <p style="max-width:800px">{{resource.description}}</p>
                    </div>
                    <div style="padding-right:15px">
                        <button   v-if="isProfilePage() || loggedInUserIsAdmin()" type="submit" class="btn btn--edit" @click="showDeleteModal()"><i class="fa fa-trash" style="font-size:25px;color:var(--color-blue)"></i></button>
                        <button   v-if="isProfilePage() || loggedInUserIsAdmin()" type="submit" class="btn btn--edit" @click="showEditModal"><i class="far fa-edit"></i></button>
                        <button   v-if="loggedInUserIsAdmin()  && isPublished()" type="submit" class="btn btn--edit" @click="showExerciseRejectionModal"><i class="fas fa-glasses"  style="font-size:30px;color:var(--color-green)"></i></button>
                        <button   v-else-if="loggedInUserIsAdmin() && !isPublished()" type="submit" class="btn btn--edit" @click="approveExercise"><i class="fas fa-glasses"  style="font-size:30px;color:var(--color-grey)"></i></button>
                        <a :href="'/storage/'+resource.pdf_path" class="btn btn--secondary"   target="_blank">{{   trans('messages.see-exercise') }}</a>
                    </div>
                </div>
                <hr>

                <div class="exercise-rating p-4 d-flex justify-content-between align-items-center">
                    <div class="rating">
                        <span v-for="index in maxRating" class="fa-star" v-bind:class="{ fas: resourceHasRating(index), far: !resourceHasRating(index) }"></span>
                        <p  v-if="loggedInUserIsDifferentFromContentUser()" @click="showRateModal">{{   trans('messages.give-rating') }}</p>
                    </div>

                    <i v-for="user in this.users">
                        <div class="created-by" v-if="user.id===resource.creator_user_id">{{   trans('messages.created-by') }}{{user.name}}</div>
                    </i>


                    <i v-for="difficulty in this.difficulties">
                        <div class="level" v-if="difficulty.id===resource.difficulty_id">{{trans('messages.'+difficulty.name)}}</div>
                    </i>
                    <i v-for="language in this.languages">
                        <div class="language" v-if="language.id===resource.lang_id">{{trans('messages.'+language.name)}}</div>
                    </i>
                    <i v-for="type in this.types">
                        <div class="category" v-if="type.id===resource.type_id">{{trans('messages.'+type.name)}}</div>
                    </i>


                </div>
<!--                <img :src="'/storage/app/public/'+resource.img_path" class="card-img-top"-->
<!--                     :alt="resource.name">-->
            </div>
        </div>
        <modal
            @canceled="rateModalOpen = false"
            id="rate-modal"
            class="modal"
            :open="rateModalOpen"
            :allow-close="true">
            <template v-slot:header>
                <h5 class="modal-title pl-2">{{   trans('messages.give-rating') }}
                    <b>{{ resource.name }}</b>
                </h5>
            </template>
            <template v-slot:body>
                <div class="container pt-3 pb-5">
                    <div class="row mb-4">
                        <div class="col">
                            <h6 v-if="userLoggedIn()">{{ getRateTitleForUser() }}</h6>
                            <h6 v-else>{{trans('messages.please_sign_in')}}</h6>
                        </div>
                    </div>
                    <div class="row" v-if="userLoggedIn()">
                        <div v-for="index in maxRating"
                             class="col-2"
                             v-bind:class="{'offset-1': index === 1}">
                            <button
                                @click="rateExercise(index)"
                                class="rate-btn btn btn btn-outline-light w-100 p-0">
                                <i class="fa-star"
                                   v-bind:class="{ fas: resourceHasRatingFromUser(index), far: !resourceHasRatingFromUser(index) }"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col text-center">
                            <a :href="getLoginRoute()" class="btn btn-primary">
                                {{trans('messages.sign-in')}}
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </modal>
        <modal
             @canceled="editModalOpen = false"
             id="editModal"
             class="modal"
            :open="editModalOpen"
            :allow-close="true">
            <template v-slot:body>
                <p class="text-center">{{trans('messages.exercise-edit-tutorial')}}</p>
            </template>
            <template v-slot:footer>
                <div>
                    <p class="mb-5">{{trans('messages.continue_confirm')}}</p>
                </div>
                <div>
                    <button type="button" class="btn btn--secondary me-5" @click="closeEditModal">{{trans('messages.cancel')}}</button>
                    <button v-on:click="getEditExerciseRoute()" type="button" class="btn btn--primary">{{trans('messages.yes')}}</button>
                </div>
            </template>

        </modal>
        <modal
            @canceled="deleteModalOpen = false"
            id="delete-package-modal"
            class="modal"
            :open="deleteModalOpen"
            :allow-close="true">
            <template v-slot:header>
                <h5 class="modal-title pl-2">{{ trans('messages.delete_exercise') }}
                    <b>{{ resource.name }}</b>
                </h5>
            </template>
            <template v-slot:body>
                <div class="container pt-3 pb-5">
                    <div class="row">
                        <div class="col text-center">
                            <div>
                                <h4>{{trans('messages.warning_deletion')}}</h4>
                            </div>
                            <a :href="getDeleteExerciseRoute()" class="btn btn-danger">
                                {{trans('messages.delete')}}
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </modal>
        <modal
            @canceled="exerciseRejectionModalOpen = false"
            id="exercise-rejection-modal"
            class="modal"
            :open="exerciseRejectionModalOpen"
            :allow-close="true">

            <template v-slot:header>
                <h5 class="modal-title pl-2">  {{trans('messages.exercise-rejection')}}
                    <b>{{ resource.name }}</b>
                </h5>
            </template>
            <template v-slot:body>
                <div class="container pt-3 pb-5">
                    <div class="row">
                        <span>{{trans('messages.see-rejection')}}</span>
                        <p style="white-space: pre-line;">{{  }}</p>
                        <br>
                        <div id="rejectForm">
                            <textarea rows="4" cols="50" v-model="rejectionMessage"></textarea>
                            <p>{{trans('messages.warning_rejection')}}</p>
                            <button @click="rejectExercise" class="btn btn-danger">
                                {{trans('messages.exercise-rejection')}}
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import {mapActions} from "vuex";
export default {

    props: {
        resource: {
            type: Object,
            default: function () {
                return {}
            }
        },
        user: {
            type: Object,
            default: function () {
                return {}
            }
        },
        languages: Array,
        types:Array,
        difficulties:Array,
        users:Array,
        resourcesRoute: String,
        userIdToGetContent: Number,
        isAdmin: String
    },
    data: function () {
        return {
            userRating: 0,
            maxRating: 5,
            rejectionMessage: "this exercise violates the platform rules of conduct",
            resourceChildrenModalOpen: false,
            rateModalOpen: false,
            editModalOpen: false,
            deleteModalOpen: false,
            exerciseRejectionModalOpen: false,
            rateTitleKey: 'rate_exercise_modal_body_text_no_rating'
        }
    },
    methods: {
        ...mapActions([
            'get',
            'post',
            'handleError'
        ]),

        isCarerExercise(){

            for(let x in this.types){
                let type = this.types[x];

                if (this.resource.type_id === type.id){
                    return type.name === 'Carer';
                }
            }
        },
        getFormValues () {
            this.output = this.$refs.message.value
        },
        getDownloadExerciseRoute() {
            return route('resources.download', this.resource.id);
        },
        getEditExerciseRoute() {

            // return route('resources.edit', this.resource.id);
            window.location.href = route('resources.edit', this.resource.id);
        },
        getRejectExerciseRoute(){
          return route('resources.reject', this.resource.id);
        },
        getHideExerciseRoute(){
            return route('resources.hide', this.resource.id);
        },
        getCloneExerciseRoute() {
            return route('resources.clone', this.resource.id);
        },
        getDeleteExerciseRoute() {
            return route('resources.delete_exercise', this.resource.id);
        },
        resourceHasRating(rateIndex) {
            return rateIndex <= this.resource.avg_rating
        },
        resourceHasRatingFromUser(rateIndex) {
            return this.userRating >= rateIndex;
        },
        showChildrenResourcesModal() {
            this.resourceChildrenModalOpen = true;
        },
        updateAverageResourceRating() {
            const ratings = _.map(this.resource.ratings, 'rating');
            const sum = ratings.reduce((a, b) => a + b, 0);
            let avg_rating = Math.round(sum / ratings.length) || 0;
            this.post({
                url: this.getUpdateExerciseRatingRoute(),
                data: {
                    id: this.resource.id,
                    avg_rating: avg_rating
                },
                urlRelative: false
            }).then(_ => {
                console.log('Stored avg rating = '+avg_rating.toString() + 'for resource = '+this.resource.id.toString())
            });
        },
        showRateModal() {

            this.rateModalOpen = true;
            if (this.userRating)
                return;
            if (this.userLoggedIn()) {
                this.get({
                    url: route('resources.user-rating.get')
                        + '?resources_id=' + this.resource.id + '&user_id=' + this.user.id,
                    urlRelative: false
                }).then(response => {

                    this.userRating = response.data.rating;
                });
            }
        },
        getUpdateExerciseRatingRoute(){
            return route('resources.update_resource_rating.post', this.resource.id);
        },
        showEditModal() {
            this.editModalOpen = true;
        },

        closeEditModal() {
            this.editModalOpen = false;
        },
        rejectExercise(){
            this.post({
                url: this.getRejectExerciseRoute(),
                data:{
                    id: this.resource.id,
                    rejection_message: this.rejectionMessage
                },
                urlRelative: false
            }).then(_ => {
                window.location.reload()
            });
        },
        approveExercise(){
            this.post({
                url: this.getApproveExerciseRoute(),
                data:{
                    id: this.resource.id,
                },
                urlRelative: false
            }).then(_ => {});
            window.location.reload()
        },
        showExerciseRejectionModal() {
            this.exerciseRejectionModalOpen = true;

        },
        getApproveExerciseRoute(){
            return route('resources.approve', this.resource.id);
        },

        showDeleteModal() {

            this.deleteModalOpen = true;
        },
        getRateTitleForUser() {
            if (this.userRating)
                this.rateTitleKey = 'rate__modal_body_text_update_rating';
            return window.translate('messages.' + this.rateTitleKey);
        },
        rateExercise(rateIndex) {
            this.post({
                url: route('resources.user-rating.post'),
                data: {
                    user_id: this.user.id,
                    resources_id: this.resource.id,
                    rating: rateIndex
                },
                urlRelative: false
            }).then(response => {
                this.userRating = response.data.rating;
                let found = false;
                for (let i = 0; i < this.resource.ratings.length; i++) {
                    if (this.resource.ratings[i].voter_user_id === this.user.id) {
                        this.resource.ratings[i].rating = response.data.rating;
                    }
                }
                if (!found)
                    this.resource.ratings.push(response.data);
                this.updateAverageResourceRating();

            });
        },
        loggedInUserIsDifferentFromContentUser() {
            return this.resource.creator.id !== this.user.id;
        },
        loggedInUserIsAdmin() {
            return this.isAdmin === '1';
        },
        userLoggedIn() {
            return this.user && this.user.id;
        },
        getLoginRoute() {
            return route('login');
        },
        isProfilePage(){
            return this.userIdToGetContent > 0;
        },
        isPublished(){
            return this.resource.status_id !== 3;
        }

    }
}
</script>

<style lang="scss">
@import "resources/sass/resources";
</style>
