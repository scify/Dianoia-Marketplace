@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{mix('dist/css/exercise-template.css')}}">
    <link rel="stylesheet" href="{{mix('dist/css/exercise-page.css')}}">
@endpush

@section('content')
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
    <main>

        <div class="row mt-5">
            <div class="col">
                <exercises-with-filters
                    :resources-route="'{{ route('resources.get') }}'"
                    :creation-route="'{{route('resources.create')}}'"
                    :user='@json($user)'
                    :resources-statuses='@json($viewModel->types)'
                    :is-admin="'{{$viewModel->isAdmin}}'"
                    :approve-resources="{{0}}"
                    :init-exercise-types="'{{$viewModel->preselect_types}}'">
                </exercises-with-filters>
            </div>
        </div>
    </main>


@endsection

@push('scripts')

    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
