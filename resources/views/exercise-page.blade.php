@extends('layouts.app')
@push('css')
    @vite('resources/sass/exercise-template.scss')
    @vite('resources/sass/exercise-page.scss')
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

    @vite('resources/js/create-edit-resource.js')
@endpush
