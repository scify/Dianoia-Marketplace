<template>
    <div>
        <div class="exercise-options ">
            <div class="exercise-options__title content">
                <h1 class="mb-3">
                    Ασκήσεις
                </h1>
                <div class="exercise-options__text-box row">

                    <div class="col-12">
                        <div class="row">
                            <div class="text-box-2 col-md-6 col-sm-12"> Επίλεξε ασκήσεις από τις παρακάτω κατηγορίες.
                                Δες την άσκηση και κατέβασέ την. Εκτύπωσέ την ή στείλε την στον άνθρωπο που φροντίζεις
                                <br />
                                <br />
                                Ένα σύνολο από επιλεγμένες ασκήσεις είναι διαθέσιμες και μέσω της mobile εφαρμογής.
                            </div>
                            <div class="text-box-3 col-md-6 col-sm-12">Δημιούργησε μια καινούργια άσκηση και βοήθησε
                                χιλιάδες συνανθρώπους σου που πάσχουν από αρχόμενη άνοια, πάτησε το κουμπί “Νέα άσκηση”.
                                <br />
                                <br />
                                Δες το έγγραφο-παράδειγμα στο πράσινο πλαίσιο παρακάτω.
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-box-1 row">
                            <div class="col">Σε περίπτωση που γίνει δεκτή η άσκηση που θα δημιουργήσεις, η διαχειριστική
                                ομάδα της SciFY θα επιλέξει αν η άσκηση θα είναι διαθέσιμη μόνο από το marketplace για
                                κατέβασμα σαν .pdf, ή και από τη mobile εφαρμογή<br /><br />




                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="search-section mt-5">

            <div class="search-section__options content d-flex justify-content-between">

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Γλώσσα
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <i v-for="language in this.contentLanguages">
                            <li><a class="dropdown-item" @click="setContentLanguage(language)">{{language.name}}</a></li>
                        </i>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Επίπεδο
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <li><a class="dropdown-item" @click="sortDifficulty('descending')">Μεγαλύτερη Δυσκολία</a></li>
                        <li><a class="dropdown-item" @click="sortDifficulty('ascending')">Χαμηλότερη Δυσκολία</a></li>
<!--                        <li><a class="dropdown-item" @click="sortDifficulty('bydate')">Νεότερες βαθμολογίες</a></li>-->
                        <li><a class="dropdown-item" @click="sortDifficulty('reset')">Όλες οι δυσκολίες</a></li>
                    </ul>
                </div>


                <div class="dropdown">

                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton3"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Κατηγορία
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                        <li><a class="dropdown-item"  id="patientCategoriesList" @click="initializeTypes('patient')">Ασκήσεις για Ασθενείς</a></li>
                        <li><a class="dropdown-item" id="carerCategoriesList" @click="initializeTypes('carer')">Ασκήσεις για Φροντιστές</a></li>
                        <li><a class="dropdown-item" id="allCategoriesList" @click="initializeTypes('all')">Όλες οι Κατηγορίες Ασκήσεων</a></li>
                    </ul>
                </div>

                <div class="dropdown" id="patient-exercise-categories" style="display: none">
                    <a class="dropdown-toggle" type="text" id="dropdownMenuButton4"
                            data-bs-toggle="dropdown" aria-expanded="false">
                       <u>Τύποι Ασκήσεων για Ασθενείς</u>
                    </a>
                    <ul class="checkboxes" aria-labelledby="dropdownMenuButton4" >
                        <i v-for="type in this.contentTypes">
                            <div v-if="isPatientExercise(type)" ><input v-bind:id="type.name" style="margin-right:0.5em" type="checkbox" @click="selectType(type)">{{type.name}}</div>
                        </i>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton5"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Βαθμολογία
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                        <li><a class="dropdown-item" @click="sortRating('descending')">Μεγαλύτερη Βαθμολογία</a></li>
                        <li><a class="dropdown-item" @click="sortRating('ascending')">Χαμηλότερη Βαθμολογία</a></li>
                        <li><a class="dropdown-item" @click="sortRating('bydate')">Νεότερες βαθμολογίες</a></li>
                        <li><a class="dropdown-item" @click="sortRating('reset')">Όλες οι δυσκολίες</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton6"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Χρήστης
                    </button>
<!--                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton6">-->
<!--                        <li><a class="dropdown-item" href="#">Ιδιώτης Φροντιστής</a></li>-->
<!--                        <li><a class="dropdown-item" href="#">Επαγγελματίας Φροντιστής</a></li>-->
<!--                        <li><a class="dropdown-item" href="#">Οργανισμός</a></li>-->
<!--                       -->
<!--                    </ul>-->

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                        <i v-for="role in this.userRoles">
                            <li><a class="dropdown-item" @click="filterResourcesByUserRole(role.id)">{{role.name}}</a></li>
                        </i>
                        <li><a class="dropdown-item" @click="filterResourcesByUserRole()">Από όλους</a></li>
                    </ul>

                </div>
            </div>


            <div class="search-section__input mt-5 content mb-5 d-flex justify-content-between align-items-center">
                <p><i class="fas fa-long-arrow-alt-down"></i> | <i class="fas fa-long-arrow-alt-up"></i> {{this.numExercises}} συνολικές
                    δραστηριότητες</p>

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
                <div> <a :href="this.creationRoute" class="btn btn--primary" target="_blank">Δημιούργησε νέα άσκηση</a>
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
                    :approve-resources="approveResources"
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

export default {
    mounted() {
        this.getContentLanguages();
        this.getContentTypes();
        this.getContentDifficulties();
        this.getUsers();
        this.getRatings();
        this.setCarerExercises();
        this.setPatientExercises();
        this.getRoles();
        this.getUserRoleMapping();
        this.initializeTypes();
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
        resourcesRoute: String,
        creationRoute: String,
        initExerciseTypes: {
            type: Object,
            default: function () {
                return {};
            }
        },
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
            searchPlaceholder: 'Αναζήτηση καταχωρήσεων',//,window.translate('messages.search_resources_package'),
            searchLoading: false,
            numExercises: 0,
        }
    },
    methods: {
        ...mapActions([
            'get',
            'handleError'
        ]),
        selectType(type) {
            let index =  this.selectedTypes.indexOf(type);
            if (index >= 0) { //unselect object
                this.selectedTypes.splice(index, 1);

            }
            else{ //select object
                this.selectedTypes.push(type);
            }
            let types = _.map(this.selectedTypes, 'name')
            console.log(type.name);
            console.log(types);
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
            console.log(language);
            this.selectedContentLanguage = language;
            this.getResources();
        },
        sortDifficulty(option){
              if(option === "reset"){
                  this.contentDifficulties=[];
                  this.getResources();
                  this.getContentDifficulties();
              }
              else {
                  this.getContentDifficulties();
                  this.contentDifficulties.sort(function (a, b) {
                      if (option === "ascending") {
                          return a.id - b.id;
                      } else if (option === "descending") {
                          return b.id - a.id;
                      }
                  });
                  this.getResources();
                  // this.getContentDifficulties();
              }
        },
        sortRating(option){
            console.log('sort ratings');
            this.contentRatings.sort(function(a, b){
                if (option === "ascending") {
                    return a.rating - b.rating;
                } else if (option === "descending") {
                    return b.rating - a.rating;
                }
                else if (option === "bydata") {
                    return b.updated_at - a.updated_at;
                }
            });
            let resourcesOrder = _.map(this.contentRatings, 'resources_id')
            console.log('sorted ratings:'+resourcesOrder);
            this.filteredResources.sort(function(a,b){
                return resourcesOrder.indexOf(a.id) - resourcesOrder.indexOf(b.id);
            })
            let resources = _.map(this.filteredResources, 'name')
            console.log('sorted resources:'+resources);
        },

        getUserRoleMapping(){
            this.get({
                url: route('user_role_mapping.get'),
                urlRelative: false
            }).then(response => {
                this.userRoleMapping = response.data;
                let userIds = _.map(this.userRoleMapping, 'user_id')
                console.log('userIds')
                console.log(userIds);
            });

        },

         filterResourcesByUserRole(roleId=null){
             this.filteredResources = this.resources.slice(0);
             console.log('Filter by role id '+roleId);
            if(roleId === null){
                return;
            }
            let usersWithRole = _.map(_.filter(this.userRoleMapping, function(map) {
                    return map.role_id === roleId;
            }),'user_id');
            console.log('usersWithRole - ',usersWithRole);
            let resources= _.map(this.filteredResources,'name');
            console.log('PreFilter:'+resources);
            this.filteredResources = this.filteredResources.filter(
                item =>usersWithRole.includes(item.creator_user_id));
            let resourceNames = _.map( this.filteredResources ,'name');
            console.log(resourceNames);
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

            this.get({
                url: route('content_types.get'),
                urlRelative: false
            }).then(response => {
                this.contentTypes = response.data;
                let types = _.map(this.contentTypes, 'name')
                console.log('types:'+types);
            });

        },
        getRoles(){
            console.log('get roles');
            this.get({
                url: route('user_roles.get'),
                urlRelative: false
            }).then(response => {
                this.userRoles = response.data;
                let roles = _.map(this.userRoles, 'name')
                console.log('roles:'+roles);
            });
        },
        getContentDifficulties(){

            this.get({
                url: route('content_difficulties.get'),
                urlRelative: false
            }).then(response => {
                this.contentDifficulties = response.data;
                let difficulties = _.map(this.contentDifficulties, 'name')
                console.log('difficulties:'+difficulties);
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
            if (this.selectedTypes.length) {
                url += '&type_ids=' + _.map(this.selectedTypes, 'id').join();
            }
            url += '&status_ids=' + _.map(this.resourcesStatuses).join();
            url += '&is_admin=' + this.isAdmin;
            url += '&difficulties=' + _.map(this.contentDifficulties,'id').join();
            // url += '&ratings=' + _.map(this.contentRatings,'id').join();
            console.log(url);
            this.get({
                url: url,
                urlRelative: false
            }).then(response => {
                this.resources = response.data;
                this.filteredResources = this.resources;
                let names = _.map(this.filteredResources, 'id')
                this.numExercises = names.length;
                console.log(names);
                this.loadingResources = false;
            });

        },
        getRatings(){
            this.get({
                url: route('content_ratings.get'),
                urlRelative: false
            }).then(response => {
                this.contentRatings = response.data;
                let ratings = _.map(this.contentRatings, 'rating')
                console.log('ratings:'+ratings);
            });
        },
        search(searchTerm) {
            if (this.timer) {
                console.log('searching...'+searchTerm);
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
        initializeTypes(mode){
            if(this.initExerciseTypes.length > 0){
                console.log('initialize types filter');
                this.selectedTypes = this.initExerciseTypes;
                $('#dropdownMenuButton3').click()
                this.initExerciseTypes = [];
            }
            else{
                if(mode==="patient"){
                    this.selectedTypes  =  this.contentTypes.filter(type => this.isPatientExercise(type));
                }
                else if (mode==="all"){
                    this.selectedTypes  =  this.contentTypes.slice(0);
                }
                else if(mode==="carer"){
                    this.selectedTypes = this.contentTypes.filter(type => this.isCarerExercise(type));
                }
            }
            console.log(_.map(this.selectedTypes,'name'));
            for(let x in this.contentTypes){
                let type = this.contentTypes[x];
                if(jQuery.inArray(type,  this.selectedTypes) !== -1){
                    console.log('check '+type.name)
                    $("#"+type.name).prop('checked','true');
                } else{
                    console.log('uncheck '+type.name);
                    $('#'+type.name).prop('checked','false');
                }
            }
            this.getResources();
        },
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
