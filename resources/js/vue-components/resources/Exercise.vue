<template>
    <div v-if="resource.id">

        <div class="exercise-template shadow content mb-5 mt-5">
            <div class="exercise-box" id="patient-template">
                <div class="exercise-title-row p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="title"> {{resource.name}} </p>
                        <p>{{resource.description}}</p>
                    </div>
                    <a href="#" class="btn btn--secondary" target="_blank">Δες την άσκηση</a>
                </div>
                <hr>
                <div class="exercise-rating p-4 d-flex justify-content-between align-items-center">
                    <div class="rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <p>Δώσε την δική σου βαθμολογία</p>
                    </div>
                    <div class="created-by">Δημιουργήθηκε από {{resource.creator_user_id}}</div>
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

<!--        <div class="card w-100" >-->
<!--            <div class="dropdown-container">-->
<!--                <div class="dropdown">-->
<!--                    <button class="btn btn-outline-secondary dropdown-toggle actions-btn" type="button"-->
<!--                            :id="'dropdownMenuButton_' + resource.id" data-bs-toggle="dropdown"-->
<!--                            aria-expanded="false">-->
<!--                        <i class="fas fa-ellipsis-v"></i>-->
<!--                    </button>-->
<!--                    <ul class="dropdown-menu" :aria-labelledby="'dropdownMenuButton_' + resource.id">-->


<!--                        <li v-if="!isAdminPageForExerciseApproval()">-->
<!--                            <a  class="dropdown-item" :href="getDownloadExerciseRoute()"><i-->
<!--                                class="fas fa-file-download me-2"></i>Download</a>-->
<!--                        </li>-->
<!--                        <li v-if="!isAdminPageForExerciseApproval()">-->
<!--                            <a class="dropdown-item"-->
<!--                               :href="getCloneExerciseRoute()"><i-->
<!--                                class="fas fa-clone me-2"></i>Clone</a>-->
<!--                        </li>-->

<!--                        <li v-if="(!loggedInUserIsDifferentFromContentUser() || loggedInUserIsAdmin()) && !isAdminPageForExerciseApproval()">-->
<!--                            <a  class="dropdown-item" :href="getEditExerciseRoute()"><i-->
<!--                                class="fas fa-edit me-2"></i>Edit</a>-->
<!--                            <a class="dropdown-item" @click="showDeleteModal"><i-->
<!--                                class="fas fa-trash-alt me-2"></i>Delete</a>-->
<!--                        </li>-->
<!--                        <li v-if="loggedInUserIsAdmin()">-->
<!--                            <a class="dropdown-item" @click="approveExercise"><i-->
<!--                                class="fas fa-check-circle me-2"></i>Approve</a>-->
<!--                            <a class="dropdown-item" @click="showExerciseRejectionModal"><i-->
<!--                                class="fas fa-angry me-2"></i>Reject</a>-->
<!--                        </li>-->
<!--                        <li v-else>-->
<!--                            <a class="dropdown-item" @click="showRateModal"><i class="fas fa-star-half-alt me-2"></i>Rate</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--            <img :src="'/storage/'+resource.img_path" class="card-img-top"-->
<!--                 :alt="resource.name">-->
<!--            <div class="card-body">-->
<!--                <p class="card-title"  style="margin-bottom: 0;">-->
<!--                    {{ resource.name }}-->
<!--                </p>-->
<!--                <p class="card-subtitle mb-2 text-muted">-->
<!--                    {{ trans('messages.made_by') }} {{ resource.creator.name }}-->
<!--                </p>-->
<!--                <button-->
<!--                    @click="showChildrenResourcesModal"-->
<!--                    class="btn btn-outline-primary my-2 w-100">-->
<!--                    {{ trans('messages.see_cards_btn') }}-->
<!--                </button>-->


<!--                <div class="rating mb-1">-->
<!--                    <i v-for="index in maxRating" class="fa-star"-->
<!--                       v-bind:class="{ fas: resourceHasRating(index), far: !resourceHasRating(index) }"></i>-->
<!--                </div>-->

<!--                <p v-if="loggedInUserIsDifferentFromContentUser()" class="rate-text">-->
<!--                    {{ trans('messages.give_rating') }} <a class="rate-link"-->
<!--                                                           @click="showRateModal">-->
<!--                    {{ trans('messages.rating') }}-->
<!--                </a>-->
<!--                </p>-->
<!--            </div>-->
<!--        </div>-->
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
        resourcesRoute: String,
        userIdToGetContent: Number,
        exercisesType: String,
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
            this.rateModalOpen = true;
            if (this.userRating)
                return;
            if (this.userLoggedIn()) {
                this.get({
                    url: route('resources.user-rating.get')
                        + '?resources_exercise_id=' + this.resource.id + '&user_id=' + this.user.id,
                    urlRelative: false
                }).then(response => {
                    this.userRating = response.data.rating;
                });
            }
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
                    resources_exercise_id: this.resource.id,
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
        isPatientExercise() {
            return this.exercisesType !== "carer";
        },
        isCarerExercise() {
            return this.exercisesType === "carer";
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
