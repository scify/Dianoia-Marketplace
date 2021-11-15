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
                        <p>{{$user->type}}</p>
                    </div>

                    <div class="col-xl-3 col-md-5 col-xs-12">
                        <!-- Modal button -->
                        <button type="submit" class="btn btn--secondary" data-bs-toggle="modal"
                                data-bs-target="#edit-profile">Επεξεργασία προφίλ</button>

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
                                        <h2 class="text-center mb-5">Επεξεργασία στοιχείων προφίλ χρήστη</h2>
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput" class="form-label">Όνομα</label>
                                            <input type="text" class="form-control" id="formGroupExampleInput"
                                                   placeholder="{{$user->name}}">
                                        </div>
{{--                                        <div class="mb-3">--}}
{{--                                            <label for="formGroupExampleInput2" class="form-label">Επώνυμο</label>--}}
{{--                                            <input type="text" class="form-control" id="formGroupExampleInput2"--}}
{{--                                                   placeholder="{{$user->name}}">--}}
{{--                                        </div>--}}
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Χρήστης</label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected>Ιδιώτης Φροντιστής</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>

                                        <div class="mt-5 mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Κωδικός</label>


                                            <input id="password-field" type="password" class="form-control"
                                                   name="password" value="secret">
                                            <span toggle="#password-field"
                                                  class="fa fa-fw fa-eye field-icon toggle-password me-3"></span>
                                        </div>


                                    </div>
                                    <div class="modal-footer text-center justify-content-center mb-5 flex-column">
                                        <div>
                                            <p class="mb-5">Είστε σίγουροι ότι θέλετε να συνεχίσετε?</p>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn--secondary me-5"
                                                    data-bs-dismiss="modal">Ακύρωση</button>
                                            <button type="button" class="btn btn--primary">Καταχώρηση
                                                στοιχείων</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="exercises-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="patients-tab" data-bs-toggle="tab"
                                    data-bs-target="#patients" type="button" role="tab" aria-controls="patients"
                                    aria-selected="true">Ασκήσεις για
                                ασθενείς</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="carer-tab" data-bs-toggle="tab" data-bs-target="#carer"
                                    type="button" role="tab" aria-controls="carer" aria-selected="false">Ασκήσεις για
                                φροντιστές</button>
                        </li>

                    </ul>

                </div>

            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="patients" role="tabpanel" aria-labelledby="patients-tab">
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
                <div class="tab-pane fade" id="carer" role="tabpanel" aria-labelledby="carer-tab">
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


                    <div class="exercise-template shadow content mb-5 mt-5">
                        <div class="exercise-box p-5" id="registered-template">
                            <div class="registered-message text-center">Η άσκησή σας έχει καταχωρηθεί. Για να γίνει
                                διαθέσιμη στην
                                εφαρμογή και να μπορείτε να την χρησιμοποιήσετε, πρέπει πρώτα να εγκριθεί από τον
                                διαχειριστή. Θα ενημερωθείτε με email για την πορεία της έγκρισης.</div>

                            <div class="exercise-title-row d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="title">Εβδομαδιαίο Πρόγραμμα Δραστηριοτήτων</p>
                                    <p>Δημιουργήστε το εβδομαδιαίο σας πρόγραμμα με τις δραστηριότητές σας.</p>

                                </div>
                                <div>
                                    <!-- Modal button Αφού επεξεργαστείτε τα στοιχεία της άσκησης -->
                                    <button type="submit" class="btn btn--edit" data-bs-toggle="modal"
                                            data-bs-target="#editModal3"><i class="far fa-edit"></i></button>

                                    <a href="#" class="btn btn--secondary" target="_blank">Δες
                                        την άσκηση</a>
                                </div>


                            </div>
                            <hr>
                            <div class="exercise-rating d-flex justify-content-between">
                                <div class="rating">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <div class="created-by">Δημιουργήθηκε από Επαγγελματίας φροντιστής</div>
                                <div class="level">Κανονικό επίπεδο</div>
                                <div class="language">Ελληνικά</div>
                                <div class="category">Ασκήσεις για φροντιστές</div>

                            </div>
                        </div>


                    </div>

                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="patients" role="tabpanel" aria-labelledby="patients-tab">
                </div>
                <div class="tab-pane fade" id="carer" role="tabpanel" aria-labelledby="carer-tab">
                    <div class="exercise-template shadow content mb-5 mt-5">
                        <div class="exercise-box p-5" id="registered-template">
                            <div class="registered-message text-center">Η άσκησή σας έχει καταχωρηθεί. Για να γίνει
                                διαθέσιμη στην
                                εφαρμογή και να μπορείτε να την χρησιμοποιήσετε, πρέπει πρώτα να εγκριθεί από τον
                                διαχειριστή. Θα ενημερωθείτε με email για την πορεία της έγκρισης.</div>
                            <div class="exercise-title-row d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="title">Εβδομαδιαίο Πρόγραμμα Δραστηριοτήτων</p>
                                    <p>Δημιουργήστε το εβδομαδιαίο σας πρόγραμμα με τις δραστηριότητές σας.</p>

                                </div>
                                <div>
                                    <!-- Modal button Αφού επεξεργαστείτε τα στοιχεία της άσκησης -->
                                    <button type="submit" class="btn btn--edit" data-bs-toggle="modal"
                                            data-bs-target="#editModal3"><i class="far fa-edit"></i></button>

                                    <a href="#" class="btn btn--secondary" target="_blank">Δες
                                        την άσκηση</a>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="editModal3" tabindex="-1"
                                     aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body mb-5 d-flex justify-content-center">
                                                <p class="text-center">Αφού επεξεργαστείτε τα στοιχεία της άσκησης,
                                                    μια νέα ειδοποίηση
                                                    θα
                                                    σταλθεί στον διαχειριστή για να επεξεργαστεί τα καινούργια
                                                    δεδομένα.</p>
                                            </div>
                                            <div
                                                class="modal-footer text-center justify-content-center mb-5 flex-column">
                                                <div>
                                                    <p class="mb-5">Είστε σίγουροι ότι θέλετε να συνεχίσετε?</p>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn--secondary me-5"
                                                            data-bs-dismiss="modal">Ακύρωση</button>
                                                    <button type="button" class="btn btn--primary">Ναι</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
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
