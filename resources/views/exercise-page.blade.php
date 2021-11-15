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
