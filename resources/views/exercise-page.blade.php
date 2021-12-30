@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{mix('dist/css/exercise-template.css')}}">
    <link rel="stylesheet" href="{{mix('dist/css/exercise-page.css')}}">
@endpush

@section('content')
    <div class="exercise-options ">
        <div class="exercise-options__title content">
            <h1 class="mb-3">
                {!!__('messages.exercises')!!}
            </h1>
            <div class="exercise-options__text-box row">

                <div class="col-12">
                    <div class="row">
                        <div class="text-box-2 col-md-6 col-sm-12"> {!!__('messages.exercise-tutorial')!!}
                        </div>
                        <div class="text-box-3 col-md-6 col-sm-12">{!!__('messages.exercise-tutorial-2')!!}
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="text-box-1 row">
                        <div class="col">{{__('messages.submission-tutorial')}}<br /><br />
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
                    :resources-statuses='@json([$viewModel->resourceStatuses['accepted']])'
                    :user='@json($user)'
                    :is-admin="'{{$viewModel->isAdmin}}'"
                    :init-exercise-types="'{{$viewModel->preselect_types}}'">
                </exercises-with-filters>
            </div>
        </div>
    </main>


@endsection

@push('scripts')

    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
