@extends('layouts.app')
@push('css')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('dist/css/main.css')}}">
    <link rel="stylesheet" href="{{mix('dist/css/exercise-page.css')}}">
    <link rel="stylesheet" href="{{mix('dist/css/exercise-template.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
          integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
@endpush

@section('content')

    <main>

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
                        <li><a class="dropdown-item" href="#">Μεγαλύτερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Χαμηλότερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Νεότερες βαθμολογίες</a></li>
                        <li><a class="dropdown-item" href="#">Όλες οι βαθμολογίες</a></li>
                    </ul>
                </div>


                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Επίπεδο
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <li><a class="dropdown-item" href="#">Μεγαλύτερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Χαμηλότερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Νεότερες βαθμολογίες</a></li>
                        <li><a class="dropdown-item" href="#">Όλες οι βαθμολογίες</a></li>
                    </ul>
                </div>


                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton3"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Κατηγορία
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                        <li><a class="dropdown-item" href="#">Μεγαλύτερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Χαμηλότερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Νεότερες βαθμολογίες</a></li>
                        <li><a class="dropdown-item" href="#">Όλες οι βαθμολογίες</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton4"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Βαθμολογία
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                        <li><a class="dropdown-item" href="#">Μεγαλύτερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Χαμηλότερη βαθμολογία</a></li>
                        <li><a class="dropdown-item" href="#">Νεότερες βαθμολογίες</a></li>
                        <li><a class="dropdown-item" href="#">Όλες οι βαθμολογίες</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton5"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Χρήστης
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
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
                <div> <a href="{{route('resources.create',['viewModel' => $viewModel])}}" class="btn btn--primary" target="_blank">Δημιούργησε νέα άσκηση</a>
                </div>
            </div>

            <div class="search-section__results">
                <div class="exercise-template shadow content mb-5 mt-5">
                    <div class="exercise-box" id="patient-template">
                        <div class="exercise-title-row p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="title">Σκίαση σχημάτων.</p>
                                <p>Αντιγράψτε τα σχέδια, σκιάζοντας τα αντίστοιχα τετράγωνα.</p>

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
                            <div class="created-by">Δημιουργήθηκε από Επαγγελματίας φροντιστής</div>
                            <div class="level">Κανονικό επίπεδο</div>
                            <div class="language">Ελληνικά</div>
                            <div class="category">Ασκήσεις προσοχής</div>

                        </div>
                    </div>
                </div>

                <div class="exercise-template shadow content mb-5 mt-5">
                    <div class="exercise-box" id="carer-template">
                        <div class="exercise-title-row p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="title">Εβδομαδιαίο Πρόγραμμα Δραστηριοτήτων</p>
                                <p>Δημιουργήστε το εβδομαδιαίο σας πρόγραμμα με τις δραστηριότητές σας.</p>

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
                            <div class="created-by">Δημιουργήθηκε από  Alzheimer Athens</div>
                            <div class="language">Ελληνικά</div>
                            <div class="category">Ασκήσεις για φροντιστές</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>


@endsection

@push('scripts')
    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
