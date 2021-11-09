<template>
    <div v-if="resource.id">
        <div class="exercise-template shadow content mb-5 mt-5">
            <div class="exercise-box" v-bind:class="[isCarerExercise() ? 'carer-template' :'patient-template']">
                <div class="exercise-title-row p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="title"> {{resource.name}} </p>
                        <p>{{resource.description}}</p>
                    </div>
                    <a :href="'/storage/'+resource.pdf_path" class="btn btn--secondary" target="_blank">Δες την άσκηση</a>
                </div>
                <hr>

                <div class="exercise-rating p-4 d-flex justify-content-between align-items-center">
                    <div class="rating mb-1">
                        <i v-for="index in maxRating" class="fa-star"
                           v-bind:class="{ fas: resourceHasRating(index), far: !resourceHasRating(index) }"></i>
                    </div>
                    <p v-if="loggedInUserIsDifferentFromContentUser()" class="rate-text">
                      Give Rating <a class="rate-link" @click="showRateModal">
                        Rating
                    </a>
                    </p>
                    <i v-for="user in this.users">
                        <div class="created-by" v-if="user.id===resource.creator_user_id">Δημιουργήθηκε από {{user.name}}</div>
                    </i>


                    <i v-for="difficulty in this.difficulties">
<!--                        <div class="level">{{resource.difficulty_id}}</div>-->
<!--                        <div class="level">{{difficulty.name}}</div>-->
                        <div class="level" v-if="difficulty.id===resource.difficulty_id">{{difficulty.name}}</div>
                    </i>
                    <i v-for="language in this.languages">
                        <div class="language" v-if="language.id===resource.lang_id">{{language.name}}</div>
                    </i>
                    <i v-for="type in this.types">
                        <div class="category" v-if="type.id===resource.type_id">{{type.name}}</div>
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
                <h5 class="modal-title pl-2">Rate Package
                    <b>{{ this.resource.name }}</b>
                </h5>
            </template>
            <template v-slot:body>
                <div class="container pt-3 pb-5">
                    <div class="row mb-4">
                        <div class="col">
                            <h6 v-if="userLoggedIn()">{{ getRateTitleForUser() }}</h6>
                            <h6 v-else>You need to sign in in order to rate this package.</h6>
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
                            <a :href="getLoginRoute()" class="btn btn-primary">{{
                                    trans('messages.sign_in_register')
                                }}</a>
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
    created() {
        this.computeTotalRating();
    },
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
        isAdmin: String,
        approveExercises: Number,
    },
    data: function () {
        return {
            userRating: 0,
            totalRating: 0,
            maxRating: 5,
            rejectionMessage: "this exercise violates the platform rules of conduct",
            resourceChildrenModalOpen: false,
            rateModalOpen: false,
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
            console.log('check to see if carer exercise');
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
            return route('resources.edit', this.resource.id);
        },
        getRejectExerciseRoute(){
          return route('resources.reject', this.resource.id);
        },
        getCloneExerciseRoute() {
            return route('resources.clone', this.resource.id);
        },
        getDeleteExerciseRoute() {
            return route('resources.destroy', this.resource.id);
        },
        resourceHasRating(rateIndex) {
            return this.totalRating >= rateIndex;
        },
        resourceHasRatingFromUser(rateIndex) {
            return this.userRating >= rateIndex;
        },
        showChildrenResourcesModal() {
            this.resourceChildrenModalOpen = true;
        },
        computeTotalRating() {
            const ratings = _.map(this.resource.ratings, 'rating');
            const sum = ratings.reduce((a, b) => a + b, 0);
            this.totalRating = Math.round(sum / ratings.length) || 0;
        },
        showRateModal() {
            console.log('show rate modal for resource '+this.resource.id);
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
            console.log(this.userRating)
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

        showExerciseRejectionModal() {
            this.exerciseRejectionModalOpen = true;

        },
        getApproveExerciseRoute(){
            return route('resources.approve', this.resource.id);
        },

        approveExercise(){
            this.post({
                url: this.getApproveExerciseRoute(),
                urlRelative: false
             }).then(response => {
                console.log(response);
            });
            window.location.reload()
        },


        showDeleteModal() {
            console.log('delete')
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
                this.computeTotalRating();
            });
        },
        loggedInUserIsDifferentFromContentUser() {
            console.log('creator:'+this.user.id);
            console.log('current:'+this.resource.creator.id);
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
        isAdminPageForExerciseApproval(){
            console.log(this.approveExercises )
            return this.approveExercises === 1;
        },


    }
}
</script>

<style lang="scss">
@import "resources/sass/resources";
</style>
