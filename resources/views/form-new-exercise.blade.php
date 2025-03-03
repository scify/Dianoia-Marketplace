@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/form-new-exercise.css') }}">
@endpush

@section('content')
    <form id="md-form" enctype="multipart/form-data" role="form" method="POST"
          action="{{ $viewModel->isEditMode() ? route('resources.update',$viewModel->resource->id) : route('resources.store') }}">
        @if($viewModel->isEditMode())
            @method('PUT')
        @endif

        {{ csrf_field() }}
        <div class="form form-new mt-5 mb-5 rounded">
            <hr>
            <div class="form-new__fields p-5">
                <p class="form-new__title p-4">{{__('messages.new-exercise')}}  </p>


                <div class="row g-3">

                    <div class="col-12">
                        <label for="category_name" class="form-label">{{__('messages.name')}} <span>*</span></label>
                        <input type="text" class="form-control" id="category_name" name="name" required="true"
                               value="{{ old('name') ?: $viewModel->resource->name }}">
                        <p class="required-text">* {!!__('messages.necessary-info')!!}</p>

                    </div>
                    <div class="col-12">
                        <label for="formGroupExampleInput2" class="form-label">{{__('messages.exercise-description')}}
                            <span>*</span></label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" name="description"
                               value="{{ old('description') ?: $viewModel->resource->description }}">
                    </div>
                    @error('description')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="col-md-6">
                        <label for="upload_img" class="form-label">{{__('messages.upload-image')}}</label>
                        <div class="file btn rounded">
                            <i class="fas fa-plus-circle"></i>
                            <input id="upload_img" type="file" name="image"/>
                        </div>
                        @if($viewModel->isEditMode())
                            <img src="{{asset("storage/".$viewModel->resource->img_path)}}" id="url" class="mt-3"
                                 alt="resource image"
                                 height="200px"/>
                        @else
                            <img src="{{asset('/img/happiness.png')}}" style="display:none" id="url"
                                 class="mt-3"
                                 height="200px" alt="happiness"/>
                        @endif

                    </div>

                    <div class="col-md-6 ">
                        <label for="category_lang" class="form-label">{{trans("messages.language")}}</label>
                        <select class="form-select" aria-label="category_lang" name="lang">
                            @foreach ($viewModel->languages as $lang)
                                @if($viewModel->lang === $lang->code)
                                    <option selected value="{{$lang->id}}"> {{trans('messages.'.$lang->name)}} </option>
                                @else
                                    <option value="{{$lang->id}}"> {{trans('messages.'.$lang->name)}} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exercise_type" class="form-label">{{trans('messages.category')}}</label>
                        <select class="form-select" aria-label="category_lang" name="type_id">
                            @foreach ($viewModel->types as $type)
                                {
                                @if($viewModel->resource->type_id === $type->id)
                                    <option value="{{$type->id}}" selected> {{trans('messages.'.$type->name)}} </option>
                                @else
                                    <option value="{{$type->id}}"> {{trans('messages.'.$type->name)}}  </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exercise_difficulty" class="form-label">{{trans('messages.level')}}</label>
                        <select class="form-select" aria-label="category_lang" name="difficulty_id">
                            @foreach ($viewModel->difficulties as $difficulty)
                                {
                                @if($viewModel->resource->difficulty_id === $difficulty->id)
                                    <option value="{{$difficulty->id}}"
                                            selected> {{trans('messages.'.$difficulty->name)}} </option>
                                @else
                                    <option
                                            value="{{$difficulty->id}}"> {{trans('messages.'.$difficulty->name)}} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-new__prototype-file text-center">
                <em> {!!__('messages.exercise-upload-rules')!!}</em>
            </div>

            <div class="form-new__submit-exercise-file p-5">

                <div class="pdf-file d-flex align-items-center mb-5 mt-5">
                    <label for="pdf" class="form-label">{!!__('messages.upload-pdf')!!}<span
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
                        @if($viewModel->isEditMode())
                            {{asset("storage/".$viewModel->resource->pdf_path)}}
                        @endif
                    </span>
                    <button type="button" class="btn btn-outline-secondary reset" id="btnResetFile">X</button>
                </div>

                <div class="copyright-rules mb-5 mt-5 p-4">
                    <div class="example">
                        <label class="form-check-label" for="flexCheckDefault">
                            <input required class="form-check-input" type="checkbox" id="flexCheckDefault" value=none
                                   name="accept-guideline-terms" style="margin-right: 10pt">
                            {!!__('messages.checkbox-guidelines')!!}<span style="color:red">*</span>
                        </label>
                    </div>
                    @error('accept-guideline-terms')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="copyright-rules mb-5 mt-5 p-4">
                    <div class="example">
                        <label class="form-check-label" for="flexCheckDefault">
                            <input required class="form-check-input" type="checkbox" id="flexCheckDefault" value=none
                                   name="accept-privacy-terms" style="margin-right: 10pt">
                            {!!__('messages.checkbox-terms-privacy-')!!}<span style="color:red">*</span>
                        </label>
                    </div>
                    @error('accept-privacy-terms')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="admin-message-options p-5">
                    {!!__('messages.submission-tutorial')!!}
                </div>
            </div>

            <hr>

            <div class="form-new__submmit-btn d-flex justify-content-end p-5">
                <a class="btn btn--secondary mt-5" href="{{route('resources.display')}}">
                    {{trans("messages.cancel")}}
                </a>
                <input id="exerciseSubmitBtn" class="btn btn--primary mt-5 ms-4" type="submit"
                       value={{trans("messages.finish-edit")}}>
            </div>
        </div>
    </form>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let span = document.getElementById('pdf-filename');
            if (span.innerHTML) {
                span.innerHTML = span.innerHTML.split("/").at(-1)
                $('#pdf-div').css('visibility', 'visible');
            }
        });
    </script>


    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
