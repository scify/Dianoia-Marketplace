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
                        <li><a class="dropdown-item"  id="patientCategoriesList" @click="initializeTypes(carer=false)">Ασκήσεις για Ασθενείς</a></li>
                        <li><a class="dropdown-item" id="carerCategoriesList" @click="initializeTypes(carer=true)">Ασκήσεις για Φροντιστές</a></li>
                        <li><a class="dropdown-item" id="allCategoriesList" @click="initializeTypes(carer=true)">Όλες οι Κατηγορίες Ασκήσεων</a></li>
                    </ul>
                </div>

                <div class="dropdown" id="patient-exercise-categories" style="display: none">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton4"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Τύποι Ασκήσεων για Ασθενείς
                    </button>
                    <ul class="checkboxes" aria-labelledby="dropdownMenuButton4" >
                        <i v-for="type in this.contentTypes">
                            <div v-if="isPatientExercise(type)" ><input v-bind:id="type.name"  type="checkbox" @click="selectType(type)">{{type.name}}</div>
                        </i>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton5"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Βαθμολογία
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                        <li><a class="dropdown-item" @click="sortRating('descending')">Μεγαλύτερη Δυσκολία</a></li>
                        <li><a class="dropdown-item" @click="sortRating('ascending')">Χαμηλότερη Δυσκολία</a></li>
                        <li><a class="dropdown-item" @click="sortRating('bydate')">Νεότερες βαθμολογίες</a></li>
                        <li><a class="dropdown-item" @click="sortRating('reset')">Όλες οι δυσκολίες</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton6"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Χρήστης
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                        <li><a class="dropdown-item" href="#">Ιδιώτης Φροντιστής</a></li>
                        <li><a class="dropdown-item" href="#">Επαγγελματίας Φροντιστής</a></li>
                        <li><a class="dropdown-item" href="#">Οργανισμός</a></li>
                        <li><a class="dropdown-item" href="#">Από όλους</a></li>
                    </ul>
                </div>
            </div>

            <div class="search-section__input mt-5 content mb-5 d-flex justify-content-between align-items-center">
                <p><i class="fas fa-long-arrow-alt-down"></i> | <i class="fas fa-long-arrow-alt-up"></i> 2 συνολικές
                    δραστηριότητες</p>

                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Αναζήτηση καταχωρήσεων"
                           aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary">Αναζήτηση</button>
                </div>
<!--                <div> <a :href="route('resources.create')" class="btn btn&#45;&#45;primary" target="_blank">Δημιούργησε νέα άσκηση</a>-->
<!--                </div>-->
            </div>

<!--            <div class="search-section__results">-->
<!--                <div class="exercise-template shadow content mb-5 mt-5">-->
<!--                    <div class="exercise-box" id="patient-template">-->
<!--                        <div class="exercise-title-row p-4 d-flex justify-content-between align-items-center">-->
<!--                            <div>-->
<!--                                <p class="title">Σκίαση σχημάτων.</p>-->
<!--                                <p>Αντιγράψτε τα σχέδια, σκιάζοντας τα αντίστοιχα τετράγωνα.</p>-->

<!--                            </div>-->
<!--                            <a href="#" class="btn btn&#45;&#45;secondary" target="_blank">Δες την άσκηση</a>-->
<!--                        </div>-->
<!--                        <hr>-->
<!--                        <div class="exercise-rating p-4 d-flex justify-content-between align-items-center">-->
<!--                            <div class="rating">-->
<!--                                <span class="fa fa-star checked"></span>-->
<!--                                <span class="fa fa-star checked"></span>-->
<!--                                <span class="fa fa-star checked"></span>-->
<!--                                <span class="fa fa-star"></span>-->
<!--                                <span class="fa fa-star"></span>-->
<!--                                <p>Δώσε την δική σου βαθμολογία</p>-->
<!--                            </div>-->
<!--                            <div class="created-by">Δημιουργήθηκε από Επαγγελματίας φροντιστής</div>-->
<!--                            <div class="level">Κανονικό επίπεδο</div>-->
<!--                            <div class="language">Ελληνικά</div>-->
<!--                            <div class="category">Ασκήσεις προσοχής</div>-->

<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="exercise-template shadow content mb-5 mt-5">-->
<!--                    <div class="exercise-box" id="carer-template">-->
<!--                        <div class="exercise-title-row p-4 d-flex justify-content-between align-items-center">-->
<!--                            <div>-->
<!--                                <p class="title">Εβδομαδιαίο Πρόγραμμα Δραστηριοτήτων</p>-->
<!--                                <p>Δημιουργήστε το εβδομαδιαίο σας πρόγραμμα με τις δραστηριότητές σας.</p>-->

<!--                            </div>-->
<!--                            <a href="#" class="btn btn&#45;&#45;secondary" target="_blank">Δες την άσκηση</a>-->
<!--                        </div>-->
<!--                        <hr>-->
<!--                        <div class="exercise-rating p-4 d-flex justify-content-between align-items-center">-->
<!--                            <div class="rating">-->
<!--                                <span class="fa fa-star checked"></span>-->
<!--                                <span class="fa fa-star checked"></span>-->
<!--                                <span class="fa fa-star checked"></span>-->
<!--                                <span class="fa fa-star"></span>-->
<!--                                <span class="fa fa-star"></span>-->
<!--                                <p>Δώσε την δική σου βαθμολογία</p>-->
<!--                            </div>-->
<!--                            <div class="created-by">Δημιουργήθηκε από  Alzheimer Athens</div>-->
<!--                            <div class="level">Κανονικό επίπεδο</div>-->
<!--                            <div class="language">Ελληνικά</div>-->
<!--                            <div class="category">Ασκήσεις για φροντιστές</div>-->

<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
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
        initExerciseTypes: {
            type: Array,
            default: function () {
                return [];
            }
        },
    },
    data: function () {
        return {
            // resourcesRoute: '',
            contentLanguages: [],
            contentTypes: [],
            contentDifficulties: [],
            users: [],
            selectedTypes: [],
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

        isPatientExercise(type){
            return type.name !== 'Carer';
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
                  this.getContentDifficulties();
              }
        },
        sortRating(option){
          ;
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
        initializeTypes(carer=false){
            if(this.initExerciseTypes.length > 0){
                this.selectedTypes = this.initExerciseTypes;
                this.initExerciseTypes = [];
            }
            else{
                if(!carer){
                    this.selectedTypes  =  this.contentTypes.filter(type => this.isPatientExercise(type));
                }
                else{
                    this.selectedTypes  =  this.contentTypes.slice(0);
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
