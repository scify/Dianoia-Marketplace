
@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{mix('dist/css/homepage.css')}}">
@endpush

@section('content')


    <header class="header">
        <div class="header__title content">
            <h1 class="mb-3">
                διΆνοια Marketplace.
            </h1>
            <div class="header__text-box row">
                <div class="col-12">
                    <div class="header__text-box-1 row">
                        <div class="col">Βοηθάς άνθρωπο με αρχόμενη άνοια;<br /><br />
                            <ul>
                                <li>- Βρες νοητικές ασκήσεις και δραστηριότητες που μπορείτε να απολαύσετε από κοινού
                                </li>
                                <li>- Δημιούργησε το δικό σου υλικό</li>
                                <li>- Βρες συμβουλές για να φροντίσεις… εσένα που φροντίζεις!</li>
                            </ul>



                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="header__text-box-2 col-md-6 col-sm-12">Δημιούργησε νέο περιεχόμενο</div>
                        <div class="header__text-box-3 col-md-6 col-sm-12">Μάθε περισσότερα για την “διΆνοια”mobile εφαρμογή .</div>
                    </div>
                </div>

            </div>


        </div>
    </header>
    <main>
        <div class="mobile-app d-flex align-items-center">
            <div class="mobile-app__text content">

                <h1 class="mb-5">διΆνοια mobile εφαρμογή.</h1>
                <p>Η ΔιΆνοια είναι μία εφαρμογή smartphone για φροντιστές ανθρώπων με ήπια γνωστική διαταραχή ή
                    αρχόμενη
                    άνοια που προσφέρεται δωρεάν.
                </p>
                <p class="mb-5">Προσφέρει εκτυπώσιμες νοητικές ασκήσεις για τους ασθενείς έτοιμες για χρήση, για να
                    τονώσουμε την
                    αυτοπεποίθησή του ανθρώπου με άνοια, περάσουν χρόνο ευχάριστα. Καθώς και ευχάριστες ασκήσεις και
                    συμβουλές χαλάρωσης για τους φροντιστές, ώστε να ενδυναμώσουν ψυχολογικά.</p>

                <a href="#" class="mt-5 btn btn--primary" target="_blank">Κατέβασε την εφαρμογή</a>


            </div>

        </div>

        <div class="patient d-flex align-items-center">
            <div class="patient__text content">
                <h1 class="mb-5">Φρόντισε τον ασθενή.</h1>
                <p>Βοήθησε τους ανθρώπους με αρχόμενη άνοια να βελτιώσουν τις νοητικές τους λειτουργίες, τη διάθεση, τη
                    λειτουργικότητα και την ποιότητα ζωής τους δίνοντάς τους γρίφους, ανατρέχοντας σε αναμνήσεις ακόμα
                    και
                    καθημερινές δουλειές ή ασχολίες που συνήθιζαν να λατρεύουν !
                </p>
                <p class="mb-5">Εδώ θα βρεις ασκήσεις σε κατηγορίες όπως: Ασκήσεις Μνήμης, Προσοχής, Σκέψης και Λόγου,
                    Εκτελεστικών Λειτουργιών οι οποίες είναι διαθέσιμες σε 2 επίπεδα δυσκολίας.</p>
                <p>Μπορείς επίσης να δημιουργήσεις τις δικές σου ασκήσεις και αν θέλεις να τις μοιραστείς με την
                    κοινότητα.
                </p>
                <a href="#" class="mt-5 btn btn--tertiary" target="_blank">Δες τις ασκήσεις</a>

            </div>

        </div>
        <div class="carer mt-5 d-flex align-items-center">
            <!--     <img class="img-fluid" loading="lazy" src="/img/grandmother-flowers.png" alt="title-image"> -->
            <div class="carer__text content">

                <h1 class="mb-5">Είσαι φροντιστής; Φρόντισε τον εαυτό σου!</h1>
                <p class="mb-5">Έχεις μεγάλη διάθεση να βοηθήσεις τους ασθενείς σου, όμως αυτό σε αποδυναμώνει
                    ψυχολογικά και ίσως θα ήθελες να ξεφύγεις ευχάριστα. Βοήθησε λοιπόν τον εαυτό σου να ενδυναμωθεί
                    έτσι ώστε να επανέλθει δυναμικά. Χρησιμοποίησε τις δραστηριότητες για φροντιστές. Μπορείς ταυτόχρονα
                    να ανατρέξεις στις πηγές που προσφέρουμε, με συμβουλές ειδικών και άφθονη βιβλιογραφία.</p>


                <a href="#" class="mt-5 btn btn--tertiary" target="_blank">Δες τι σου προσφέρεται</a>
            </div>

        </div>
    </main>
@endsection
@push('scripts')
    <script src="{{ mix('dist/js/home.js') }}"></script>
@endpush
