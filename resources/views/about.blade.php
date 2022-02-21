@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/homepage.css') }}">
    <title> About Page</title>
@endpush

@section('content')

    <header class="mt-5 mb-5" style="text-align: center">
        <h1 style="font-style:oblique;text-decoration:underline; color:var(--color-blue-light-1)">About {{__('messages.dianoia')}}</h1>
    </header>
    <main>
    <div class="container" style="margin-bottom: 100px; margin-top: 60px">
        <h2 style="font-style: oblique; text-decoration: underline"><b>διΆνοια mobile εφαρμογή</b></h2>
        <p >
            Η ΔιΆνοια είναι μία εφαρμογή smartphone για φροντιστές ανθρώπων με ήπια γνωστική διαταραχή ή αρχόμενη άνοια που προσφέρεται δωρεάν. Προσφέρει εκτυπώσιμες νοητικές ασκήσεις για τους ασθενείς έτοιμες για χρήση, για να τονώσουμε την αυτοπεποίθησή του ανθρώπου με άνοια, περάσουν χρόνο ευχάριστα. Καθώς και ευχάριστες ασκήσεις και συμβουλές χαλάρωσης για τους φροντιστές, ώστε να ενδυναμώσουν ψυχολογικά.
        </p>
    </div>


    <div class="container" style="margin-bottom: 100px">
        <h2 style="font-style: oblique; text-decoration: underline"><b>διΆνοια marketplace</b></h2>
        <ul>
            <li>
            Επίλεξε ασκήσεις από τις παρακάτω κατηγορίες.
            <ul>
                <li>
                    <a href="{{route('resources.display',['preselect_type_name' => 'patient'])}}" class="btn btn--tertiary" target="_blank">ασκήσεις για ασθενείς</a>
                </li>
                <li>
                    <a href="{{route('resources.display',['preselect_type_name' => 'carer'])}}" class="btn btn--tertiary" target="_blank">ασκήσεις για φροντιστές</a>
                </li>
            </ul>
            </li>


            <li style="margin: 10px 0;">
                Δες την άσκηση και κατέβασέ την. Τύπωσέ την ή στείλε την στον άνθρωπο που φροντίζεις. Κάθε άσκηση είναι διαθέσιμη και μέσω της mobile εφαρμογής.
            </li>
            <li style="margin: 10px 0;">
                Δημιούργησε μια καινούργια άσκηση και βοήθήσε χιλιάδες συνανθρώπους σου που πάσχουν από αρχόμενη άνοια, πάτησε το κουμπί “Νέα άσκηση”.    Δες το έγγραφο-παράδειγμα στο πράσινο πλαίσιο παρακάτω.
            </li>
            <li>
                Σε περίπτωση που γίνει δεκτή η άσκηση που θα δημιουργήσεις, η διαχειριστική ομάδα της SciFY θα επιλέξει αν η άσκηση θα είναι διαθέσιμη μόνο από το marketplace για κατέβασμα σαν .pdf, ή και από τη mobile εφαρμογή.
            </li>
        </ul>

    </div>



{{--    [link για terms and conditions-privacy policy]--}}
{{--    [link για content guidelines]--}}
{{--    [link για gdpr]--}}

{{--    Κείμενο για χρηματοδότηση από “Σημεία Στήριξης” https://www.scify.gr/site/el/impact-areas/assistive-technologies/dianoia--}}

{{--    Κείμενο για χρηματοδότηση από SHAPES--}}
</main>


@endsection
@push('scripts')
    <script src="{{ mix('dist/js/home.js') }}"></script>
@endpush
