<template>
    <div>


        <div class="search-section mt-5">

            <div v-if="!isProfilePage()" class="search-section__options content d-flex justify-content-between">

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        {{trans('messages.language')}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <i v-for="language in this.contentLanguages">
                            <li><a class="dropdown-item" @click="setContentLanguage(language)">{{trans('messages.'+language.name)}}</a></li>
                        </i>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        {{trans('messages.level')}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <li><a class="dropdown-item" @click="sortDifficulty('descending')"> {{trans('messages.Μεγάλης Δυσκολίας')}} &#8680; {{trans('messages.Εύκολης Δυσκολίας')}}</a></li>
                        <li><a class="dropdown-item" @click="sortDifficulty('ascending')">{{trans('messages.Εύκολης Δυσκολίας')}} &#8680; {{trans('messages.Μεγάλης Δυσκολίας')}}</a></li>
                        <li><a class="dropdown-item" @click="sortDifficulty('reset')">{{trans('messages.all-levels')}}</a></li>
                    </ul>
                </div>


                <div class="dropdown">

                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton3"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        {{trans('messages.category')}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                        <li><a class="dropdown-item"  id="patientCategoriesList" @click="selectExerciseCategory('patient')">{{trans('messages.patient-exercises')}}</a></li>
                        <li><a class="dropdown-item" id="carerCategoriesList" @click="selectExerciseCategory('carer')">{{trans('messages.Carer')}}</a></li>
                        <li><a class="dropdown-item" id="allCategoriesList" @click="selectExerciseCategory('all')">{{trans('messages.all-categories')}}</a></li>
                    </ul>
                </div>

                <div class="dropdown" id="patient-exercise-categories" style="display: none">
                    <a class="dropdown-toggle" type="text" id="dropdownMenuButton4"
                            data-bs-toggle="dropdown" aria-expanded="false">
                       <u> {{trans('messages.patient-exercises')}}</u>
                    </a>
                    <ul class="checkboxes" aria-labelledby="dropdownMenuButton4" >
                        <i v-for="type in this.contentTypes">
                            <div v-if="isPatientExercise(type)" ><input v-bind:id="type.name" style="margin-right:0.5em" type="checkbox" @click="selectType(type)">{{trans('messages.'+type.name)}}</div>
                        </i>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton5"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        {{trans('messages.rating')}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                        <li><a class="dropdown-item" @click="sortRating('descending')">{{trans('messages.higher-rating')}}</a></li>
                        <li><a class="dropdown-item" @click="sortRating('ascending')">{{trans('messages.lower-rating')}}</a></li>
                        <li><a class="dropdown-item" @click="sortRating('bydate')">{{trans('messages.new-ratings')}}</a></li>
                        <li><a class="dropdown-item" @click="sortRating('reset')">{{trans('messages.all-ratings')}}</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton6"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        {{trans('messages.user')}}
                    </button>
<!--                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton6">-->
<!--                        <li><a class="dropdown-item" href="#">Ιδιώτης Φροντιστής</a></li>-->
<!--                        <li><a class="dropdown-item" href="#">Επαγγελματίας Φροντιστής</a></li>-->
<!--                        <li><a class="dropdown-item" href="#">Οργανισμός</a></li>-->
<!--                       -->
<!--                    </ul>-->

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                        <i v-for="role in this.userRoles">
                            <li><a class="dropdown-item" @click="filterResourcesByUserRole(role.id)">{{trans('messages.'+role.name)}}</a></li>
                        </i>
                        <li><a class="dropdown-item" @click="filterResourcesByUserRole()">{{trans('messages.from-everyone')}}</a></li>
                    </ul>

                </div>
            </div>


            <div class="search-section__input mt-5 content mb-5 d-flex justify-content-between align-items-center">
                <p><i class="fas fa-long-arrow-alt-down"></i> | <i class="fas fa-long-arrow-alt-up"></i> {{this.numExercises}}{{' ' +trans('messages.total-activities')}}</p>

<!--                <div class="input-group">-->
<!--                    <input type="search" class="form-control rounded" placeholder="Αναζήτηση καταχωρήσεων"-->
<!--                           aria-label="Search" aria-describedby="search-addon" />-->
<!--                    <button type="button" class="btn btn-outline-primary" @click="search">Αναζήτηση</button>-->
<!--                </div>-->
                <div class="col-md-4 col-sm-12">
                    <div class="input-group search"><i class="fa fa-search"></i>
                        <input
                            @keyup.stop="search($event.target.value)"
                            type="text" class="form-control"
                            :placeholder="searchPlaceholder">
                        <div v-if="searchLoading" class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div> <a :href="this.creationRoute" class="btn btn--primary" target="_blank">{{trans('messages.exercise-creation')}}</a>
                </div>
            </div>
        </div>

        <div class="row mt-5" v-if="filteredResources.length">
            <div v-for="(resource, index) in filteredResources" :key="index">
                    <exercise
                              :user="user ? user : {}"
                              :user-id-to-get-content="userIdToGetContent"
                              :resource="resource"
                              :is-admin="isAdmin"
                              :languages="contentLanguages"
                              :types="contentTypes"
                              :difficulties="contentDifficulties"
                              :users="users">
                    </exercise>
                </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import Promise from "lodash/_Promise";

export default {
    mounted() {
        this.getExerciseMetadataAndContents();
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
        resourcesRoute: String,
        creationRoute: String,
        initExerciseTypes: String,
    },
    data: function () {
        return {
            // resourcesRoute: '',
            contentLanguages: [],
            contentTypes: [],
            contentDifficulties: [],
            contentRatings: [],
            userRoles: [],
            userRoleMapping: [],
            users: [],
            selectedTypes: [],
            selectedContentLanguage: {},
            loadingResources: false,
            filteredResources: [],
            maxRating: 5,
            patientExercises: [],
            carerExercises: [],
            searchPlaceholder: window.translate('messages.search-submissions'),
            searchLoading: false,
            numExercises: 0,
        }
    },
    methods: {
        ...mapActions([
            'get',
            'handleError'
        ]),

        getExerciseMetadataAndContents() {
            this.loadingResources = true;
            this.setCarerExercises();
            this.setPatientExercises();
            Promise.all([
                this.getContentLanguages(),
                this.getContentTypes(),
                this.getContentDifficulties(),
                this.getUsers(),
                this.getRatings(),
                this.getRoles(),
                this.getUserRoleMapping(),
            ]).then(results => {
                console.log('initialize metadata');
                this.initResources(results[0], results[1], results[2], results[3], results[4], results[5], results[6])
                console.log('initialized metadata');
                this.getResources();
                this.loadingResources = false;
            });
        },

        initResources(languages, types, difficulties, users, ratings, roles, role_mapping) {
            this.contentLanguages = languages;
            this.contentTypes = types;
            this.contentDifficulties = difficulties;
            this.users  = users;
            this.contentRatings = ratings;
            this.userRoles= roles;
            this.userRoleMapping = role_mapping;
            this.initializeTypes();
        },



        selectType(type) {
            let index =  this.selectedTypes.indexOf(type);
            if (index >= 0) { //unselect object
                this.selectedTypes.splice(index, 1);
            }
            else{ //select object
                this.selectedTypes.push(type);
            }
            let types = _.map(this.selectedTypes, 'name')
            console.log('selected types: '+types);
            this.getResources();
        },
        setPatientExercises(){
            this.patientExercises = ["Attention","Memory","Executive","Reason"];
        },

        setCarerExercises(){
            this.carerExercises = ["Carer"];
        },
        isPatientExercise(type){

            return this.patientExercises.includes(type.name);
        },
        isCarerExercise(type){
            return this.carerExercises.includes(type.name);
        },

        setContentLanguage(language) {

            this.selectedContentLanguage = language;
            this.getResources();
        },
        sortDifficulty(option){
           this.getContentDifficulties();
           if(option !== "reset"){
               this.contentDifficulties.sort(function (a, b) {
                  if (option === "ascending") {
                      return a.id - b.id;
                  } else if (option === "descending") {
                      return b.id - a.id;
                  }
              });
               this.getResources(true);
               this.getContentDifficulties();
           }
           else{
               this.contentDifficulties = [];
               this.getResources();
               this.getContentDifficulties();

           }
        },
        sortRating(option){
            this.filteredResources.sort(function(a, b){
                if (option === "ascending") {
                    if(a.avg_rating === 0)//place empty ratings at the bottom
                        return true;
                    return a.avg_rating - b.avg_rating;
                } else if (option === "descending") {
                    return b.avg_rating - a.avg_rating;
                }
                else if (option === "bydate") {//show newest ratings at the top
                    return new Date(b.updated_at) - new Date(a.updated_at);
                }
            });
        },

        getUserRoleMapping(){
            const instance = this;
            return new Promise(function callback(resolve, reject) {
                instance.get({
                    url: route('user_role_mapping.get'),
                    urlRelative: false
                }).then(response => {
                    instance.userRoleMapping = response.data;
                    resolve(instance.userRoleMapping );
                }).catch(e => reject(e));
            });
        },

         filterResourcesByUserRole(roleId=null){this.filteredResources = this.resources.slice(0);
            if(roleId === null){
                return;
            }
            let usersWithRole = _.map(_.filter(this.userRoleMapping, function(map) {
                    return map.role_id === roleId;
            }),'user_id');
            this.filteredResources = this.filteredResources.filter(
                item =>usersWithRole.includes(item.creator_user_id));
        },
        getContentLanguages() {
            console.log('retrieving languages');
            const instance = this;
            return new Promise(function callback(resolve, reject) {
                instance.get({
                    url: route('content_languages.get'),
                    urlRelative: false
                }).then(response => {
                    instance.contentLanguages = response.data;
                    // instance.selectedContentLanguage = instance.contentLanguages[0];
                    console.log('retrieved languages');
                    console.log(_.map(instance.contentLanguages,'name'));
                    resolve(instance.contentLanguages );
                }).catch(e => reject(e));
            });
        },
        getContentTypes(){
            console.log('retrieving types');
            const instance = this;
            return new Promise(function callback(resolve, reject) {
                instance.get({
                    url: route('content_types.get'),
                    urlRelative: false
                }).then(response => {
                    instance.contentTypes = response.data;
                    console.log('retrieved types');
                    console.log(_.map(instance.contentTypes,'name'));
                    resolve(instance.contentTypes );
                }).catch(e => reject(e));
            });
        },
        getRoles(){
            console.log('retrieving roles');
            const instance = this;
            return new Promise(function callback(resolve, reject) {
                instance.get({
                    url: route('user_roles.get'),
                    urlRelative: false
                }).then(response => {
                    instance.userRoles = response.data;
                    console.log('retrieved roles');
                    console.log(_.map(instance.userRoles,'name'));
                    resolve(instance.userRoles );
                }).catch(e => reject(e));
            })
        },
        getContentDifficulties(){
            console.log('retrieving difficulties');
            const instance = this;
            return new Promise(function callback(resolve, reject) {
                instance.get({
                    url: route('content_difficulties.get'),
                    urlRelative: false
                }).then(response => {
                    instance.contentDifficulties = response.data;
                    console.log('retrieved difficulties');
                    console.log(_.map(instance.contentDifficulties,'name'));
                    resolve(instance.contentDifficulties );
                }).catch(e => reject(e));
            });
        },
        getUsers(){
            console.log('retrieving users');
            const instance = this;
            return new Promise(function callback(resolve, reject) {
                instance.get({
                    url: route('users.get'),
                    urlRelative: false
                }).then(response => {
                    instance.users = response.data;
                    console.log('retrieved users');
                    console.log(_.map(instance.users,'name'));
                    resolve(instance.users );
                }).catch(e => reject(e));
            });
        },
        getResources(sort_difficulty=false) {
            this.resources = [];
            this.filteredResources = [];
            let url = "";
            if(this.selectedContentLanguage){
                url += this.resourcesRoute + '?lang_id=' + this.selectedContentLanguage.id;
            }
            else{
                url += this.resourcesRoute + '?lang_id=';
            }

            if (this.userIdToGetContent) {
                url += ('&user_id_to_get_content=' + this.userIdToGetContent);
            }
            if (this.selectedTypes.length) {
                url += '&type_ids=' + _.map(this.selectedTypes, 'id').join();
            }
            if (this.isAdmin){
                url += '&status_ids=' + _.map(this.resourcesStatuses).join();
            }
            url += '&is_admin=' + this.isAdmin;
            if(sort_difficulty) {
                url += '&difficulties=' + _.map(this.contentDifficulties, 'id').join();
            }
            this.get({
                url: url,
                urlRelative: false
            }).then(response => {
                this.resources = response.data;
                this.filteredResources = this.resources;
                let names = _.map(this.filteredResources, 'name')
                this.numExercises = names.length;
            });

        },
        getRatings(){
            const instance = this;
            console.log('retrieve ratings');
            return new Promise(function callback(resolve, reject) {
                instance.get({
                    url: route('content_ratings.get'),
                    urlRelative: false
                }).then(response => {
                    instance.contentRatings = response.data;
                    console.log('retrieved ratings');
                    console.log(_.map(instance.contentRatings,'id'));
                    resolve(instance.contentRatings );
                }).catch(e => reject(e));
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
                    return p.name.toLowerCase().includes(searchTerm.toLowerCase())
                        || p.description.toLowerCase().includes(searchTerm.toLowerCase());
                });
                this.searchLoading = false;
            }, 500);
        },


        filterTypesByExerciseCategory(category){
            if(category==="patient"){
                this.selectedTypes  =  this.contentTypes.filter(type => this.isPatientExercise(type));
                $('#dropdownMenuButton3').click();
            }
            else if(category==="carer"){
                this.selectedTypes = this.contentTypes.filter(type => this.isCarerExercise(type));
                $('#dropdownMenuButton3').click();
            }
            else if (category==="all"){
                this.selectedTypes  =  this.contentTypes.slice(0);
            }
        },

        selectExerciseCategory(category){
            this.filterTypesByExerciseCategory(category);
            this.showTypeDropdownMenu();
            this.getResources();
        },

        initializeTypes(){
            this.selectedContentLanguage = null;
            this.filterTypesByExerciseCategory(this.initExerciseTypes);
            this.showTypeDropdownMenu();
        },


        showTypeDropdownMenu(){
            for(let x in this.contentTypes){
                let type = this.contentTypes[x];
                if(jQuery.inArray(type,  this.selectedTypes) !== -1){
                    $("#"+type.name).prop('checked','true');
                } else{
                    $('#'+type.name).prop('checked','false');
                }
            }
        },

        getCurrentUserId(){
            return this.user['id'];
        },
        isProfilePage(){
            return this.userIdToGetContent > 0;
        }
    }


}


</script>

<style scoped lang="scss">
@import "resources/sass/common/variables";
@import "resources/sass/exercise-page";



.btn.selected {
    background-color:  var(--color-blue);;
}

</style>
