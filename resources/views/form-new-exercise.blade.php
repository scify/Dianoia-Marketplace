@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/form-new-exercise.css') }}">
@endpush

@section('content')
    <form id="md-form" enctype="multipart/form-data"  role="form" method="POST"
          action="{{ $viewModel->isEditMode() ? route('resources.update',$viewModel->resource->id) : route('resources.store') }}">
        @if($viewModel->isEditMode())
            @method('PUT')
        @endif

        {{ csrf_field() }}
        <div class="form form-new mt-5 mb-5 rounded">

            <p class="form-new__title p-4">Νέα άσκηση</p>
            <hr>
            <div class="form-new__fields p-5">
                <div class="row g-3">

                    <div class="col-12">
                        <label for="category_name" class="form-label">{{__('messages.name')}} <span>*</span></label>
                        <input type="text" class="form-control" id="category_name" name="name" required="true"  value="{{ old('name') ? old('name') : $viewModel->resource->name }}">
                    </div>
                    <div class="col-12">
                        <label for="formGroupExampleInput2" class="form-label">Περιγραφή άσκησης <span>*</span></label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="description">
                    </div>
                    @error('description')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="col-md-6">
                        <label for="upload_img" class="form-label">Ανέβασε εικόνα</label>
{{--                        <div class="file btn rounded">--}}
{{--                            <i class="fas fa-plus-circle"></i>--}}
{{--                            <input type="button" class="btn btn-third" id="loadFileXml" value="+"--}}
{{--                                   onclick="document.getElementById('upload_img').click();"/>--}}
{{--                            <input type="file" accept="image/*"--}}
{{--                                   class="btn btn-third @error('image') is-invalid @enderror" style="display:none;"--}}
{{--                                   name="image" id="upload_img">--}}

                            <div class="file btn rounded">
                                <i class="fas fa-plus-circle"></i>
                                <input id="upload_img" type="file" name="image" />
                            </div>

{{--                        </div>--}}
                        @if($viewModel->isEditMode())
                            <img src={{asset("storage/".$viewModel->resource->img_path)}} id="url" class="mt-3"
                                 height="200px"/>
                        @else
                            <img src={{asset('/img/happiness.png')}} style="display:none" id="url"
                                 class="mt-3"
                                 height="200px"/>
                        @endif

                    </div>
                    @error('image')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                    <p class="required-text">* Απαραίτητα στοιχεία</p>

                    <div class="col-md-6 ">

                        <label for="category_lang" class="form-label">{{trans("messages.language")}}</label>
                        <select class="form-select" aria-label="category_lang" name="lang">
                            @foreach ($viewModel->languages as $lang){
                            @if($viewModel->lang === $lang->code)
                                <option selected value="{{$lang->id}}"> {{$lang->name}} </option>
                            @else
                                <option value="{{$lang->id}}"> {{$lang->name}} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exercise_type" class="form-label">Κατηγορία</label>
                        <select class="form-select" aria-label="category_lang" name="type_id">
                            @foreach ($viewModel->types as $type){
                            @if($viewModel->resource->type_id === $type->id)
                                <option selected> {{$type->name}} </option>
                            @else
                                <option value="{{$type->id}}"> {{$type->name}} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exercise_difficulty" class="form-label">Difficulty</label>
                        <select class="form-select" aria-label="category_lang" name="difficulty_id">
                            @foreach ($viewModel->difficulties as $difficulty){
                            @if($viewModel->resource->difficulty_id === $difficulty->id)
                                <option selected> {{$difficulty->name}} </option>
                            @else
                                <option value="{{$difficulty->id}}"> {{$difficulty->name}} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-new__prototype-file text-center">
                <em> Οι ασκήσεις που θα ανεβάσεις στην πλατφόρμα πρέπει να έχουν περιεχόμενο σύμφωνο με την δομή του
                    πρωτότυπου εγγράφου <a href="">εδώ</a>.</em>

            </div>

            <div class="form-new__submit-exercise-file p-5">

                <div class="pdf-file d-flex align-items-center mb-5 mt-5">
                    <label for="pdf" class="form-label">Upload Exercise (pdf)<span
                            style="color:#ff0000">*</span></label>
                    <div class="file btn circle d-flex align-items-center ms-3">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" class="form-control" id="customFile" name="pdf"/>
                    </div>
                    @error('pdf')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="uploaded-file p-2" style="visibility:hidden" id="pdf-div">
                    <span id="pdf-filename">
                    </span>
                    <button type="button" class="btn btn-outline-secondary reset" id="btnResetFile">X</button>
                </div>

                <div class="copyright-rules mb-5 mt-5 p-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value=none id="flexCheckDefault" name="terms">
                        <label class="form-check-label" for="flexCheckDefault">
                            Έχω διαβάσει τους <b><u>κανόνες περιεχομένου και πνευματικής ιδιοκτησίας</u></b>, καθώς και
                            τους όρους για
                            την
                            δομή της άσκησής, όπως στο <b><u>παράδειγμα</u></b>. <span>*</span>
                        </label>
                    </div>
                    @error('terms')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="admin-message-options p-5">
                    Σε περίπτωση που γίνει δεκτή η άσκηση που θα δημιουργήσεις, η διαχειριστική ομάδα της SciFY θα
                    επιλέξει αν η άσκηση θα είναι διαθέσιμη μόνο από το marketplace για κατέβασμα σαν .pdf, ή και από τη
                    mobile εφαρμογή
                </div>



            </div>

            <hr>

            <div class="form-new__submmit-btn d-flex justify-content-end p-5">
                <a class="btn btn--secondary mt-5" href="{{route('resources.display')}}">
                    {{trans("messages.cancel")}}
                </a>
                <input  id="exerciseSubmitBtn" class="btn btn--primary mt-5 ms-4" type="submit" value={{trans("messages.finish-edit")}}>
            </div>
    </div>
    </form>
@endsection
@push('scripts')
    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
