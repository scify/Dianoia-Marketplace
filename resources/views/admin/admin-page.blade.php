@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{mix('dist/css/profile-page.css')}}">

@endpush

@section('content')
<main>
    <div class="back-color">
        <div class="content">
            <!-- Section with administration card (user-info & exercises-tabs)  -->
            <div class="user-card shadow mt-5">

                <div class="row user-info ">
                    <div class="col-xl-9 col-md-7 col-xs-12 ">
                        <h1>{{$user->name}} <span>({{$user->email}})</span> </h1>
                        <p>{{trans('messages.'.$user->type->name)}}</p>
                    </div>

                    <div class="col-xl-3 col-md-5 col-xs-12">
                        <!-- Modal button -->
                        <button type="submit" class="btn btn--secondary" data-bs-toggle="modal"
                                data-bs-target="#edit-profile">{{__('messages.edit-profile')}}</button>

                        <!-- Modal -->
                        <div class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mb-5">
                                        <form id="form" enctype="multipart/form-data"  role="form" method="POST"
                                              action="{{ route('users.update', $user) }}">
                                            @if(true)
                                                @method('PUT')
                                            @endif
                                            {{ csrf_field() }}
                                            <div class="form form-new mt-5 mb-5 rounded">
                                                <p class="form-new__title p-4">
                                                    {{__('messages.edit-profile-info')}}</p>
                                                <hr>
                                            </div>
                                            <div class="form-new__fields p-5">
                                                <div class="col-12">
                                                    <label for="username" class="form-label">{{__('messages.name')}} <span>*</span></label>
                                                    <input type="text" class="form-control" id="username" name="name" value="{{$user->name}}">
                                                </div>
                                                <input style="display:none" type="text" class="form-control" name="prev_type_id" value="{{$user->type->id}}">

                                                <p style="display:none">{{trans('messages.'.$user->type->name)}}</p>
                                                <div class="col-12">
                                                    <label for="email" class="form-label">Email <span>*</span></label>
                                                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email}}" required autocomplete="email">
                                                </div>
                                                <div class="col-12">
                                                    <label for="password" class="form-label">{{__('messages.password')}} <span>*</span></label>
                                                    <input id="password-field" type="password" class="form-control"
                                                           name="password" placeholder="********">
                                                    <span toggle="#password-field"

                                                          class="fa fa-fw fa-eye field-icon toggle-password me-3"></span>
                                                </div>

                                                <div class="col-12">
                                                    <label for="formGroupExampleInput2" class="form-label">{{__('messages.user')}}</label>

                                                    <select class="form-select" aria-label="Default select example"  name="type_id">
                                                        @foreach(['Private Carer', 'Professional Carer', 'Organization'] as $i=>$type)
                                                            @if($type === $user->type->name)
                                                                <option value="{{$user->type->id}}" selected> {{trans('messages.'.$user->type->name)}}</option>
                                                            @else
                                                                <option value="{{$i+2}}">{{trans('messages.'.$type)}} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-new__submmit-btn d-flex justify-content-end p-5">
                                                <div>
                                                    <p class="mb-5">{{__('messages.continue-confirm')}}</p>
                                                    <a class="btn btn--secondary mt-1" href="{{route('resources.my_profile')}}">
                                                        {{trans("messages.cancel")}}
                                                    </a>
                                                    <input  id="userEditBtrn" class="btn btn--primary mt-1 ms-4" type="submit" value="{{__('messages.submit-info')}}">
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="exercises-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-exercises-tab" data-bs-toggle="tab"
                                    data-bs-target="#pending" type="button" role="tab" aria-controls="pending"
                                    aria-selected="true">Pending Exercises</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="accepted-exercises-tab" data-bs-toggle="tab" data-bs-target="#accepted"
                                    type="button" role="tab" aria-controls="accepted" aria-selected="false">Accepted Exercises</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rejected-exercises-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                                    type="button" role="tab" aria-controls="rejected" aria-selected="false">Rejected Exercises</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-exercises-tab">
                    <div class="row">
                        <div class="col">
                            <exercises-with-filters
                                :resources-route="'{{ route('resources.get') }}'"
                                :creation-route="'{{route('resources.create')}}'"
                                :user='@json($user)'
                                :resources-statuses='@json($viewModel->types)'
                                :is-admin="'{{$viewModel->isAdmin}}'"
                                :approve-resources="{{0}}"
                                :init-exercise-types=" 'patient' "
                                :user-id-to-get-content='{{$user->id}}'>
                            </exercises-with-filters>
                        </div>
                     </div>
                </div>
                <div class="tab-pane fade" id="accepted" role="tabpanel" aria-labelledby="accepted-exercises-tab">
                    <div class="row mt-5">
                        <div class="col">
                            <exercises-with-filters
                                :resources-route="'{{ route('resources.get') }}'"
                                :creation-route="'{{route('resources.create')}}'"
                                :user='@json($user)'
                                :resources-statuses='@json($viewModel->types)'
                                :is-admin="'{{$viewModel->isAdmin}}'"
                                :approve-resources="{{0}}"
                                :init-exercise-types=" 'carer' "
                                :user-id-to-get-content='{{$user->id}}'>
                            </exercises-with-filters>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-exercises-tab">
                    <div class="row mt-5">
                        <div class="col">
                            <exercises-with-filters
                                :resources-route="'{{ route('resources.get') }}'"
                                :creation-route="'{{route('resources.create')}}'"
                                :user='@json($user)'
                                :resources-statuses='@json($viewModel->types)'
                                :is-admin="'{{$viewModel->isAdmin}}'"
                                :approve-resources="{{0}}"
                                :init-exercise-types=" 'carer' "
                                :user-id-to-get-content='{{$user->id}}'>
                            </exercises-with-filters>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });</script>
<script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
