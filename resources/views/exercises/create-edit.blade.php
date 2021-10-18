@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/communication-cards-create-edit.css') }}">
@endpush

@section('content')




    <form id="md-form" enctype="multipart/form-data" role="form" method="POST"
          action="{{ $viewModel->isEditMode() ? route('resources.update',$viewModel->resource->id) : route('resources.store') }}">
    @if($viewModel->isEditMode())
        @method('PUT')
    @endif

    <!--form class="md-form" action="{{route('resources.store')}}" method="POST" enctype="multipart/form-data"-->
        {{ csrf_field() }}
        <div class="container rounded py-4" style="border:1px solid grey">
            <div class="mx-3">
                <b>{{trans("messages.new_package")}}</b>
            </div>
            <hr/>
            <div class="container-sm px-5">

                <!-- Content here -->
                <div class="mb-3">
                    <label for="category_name" class="form-label">{{__('messages.name')}} <span style="color:#ff0000">*</span></label>
                    <input type="text" class="form-control" id="category_name"
                           name="name"
                           required
                           value="{{ old('name') ? old('name') : $viewModel->resource->name }}">
                </div>
                <div class="mb-3">
                    <label for="category_lang" class="form-label">{{trans("messages.language")}}</label>
                    <select class="form-select"@if($viewModel->lang_id != -1) disabled @endif aria-label="category_lang" name="lang">
                        @foreach ($viewModel->languages as $lang){
                        @if($viewModel->lang_id === $lang->id)
                            <option selected> {{$lang->name}} </option>
                        @else
                            <option value="{{$lang->id}}"> {{$lang->name}} </option>
                        @endif

                        @endforeach
                    </select>
                    <!--<input type="radio" class="form-control" id="category_lang"> -->
                </div>
                <div class="mb-3">
                    <label for="upload_img" class="form-label"> {{trans("messages.upload_img")}} <span
                            style="color:#ff0000">*</span></label>
                    <div class="file-field px-5">
                        <a class="btn-floating float-left">
                            <!--<i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>-->
                            <input type="button" class="btn btn-third" id="loadFileXml" value="+"
                                   onclick="document.getElementById('upload_img').click();"/>
                            <input type="file" accept="image/*"
                                   class="btn btn-third @error('image') is-invalid @enderror" style="display:none;"
                                   name="image" id="upload_img">

                        </a>

                    </div>
                    @if($viewModel->isEditMode())
                        <img src={{asset("storage/".$viewModel->resource->img_path)}} id="url" class="mt-3"
                             height="200px"/>
                    @else
                        <img src={{asset('/audio/happiness.png')}} style="display:none" id="url"
                             class="mt-3"
                             height="200px"/>
                    @endif


                </div>
                @error('image')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
                <div class="mb-3">
                    <label for="sound_file" class="form-label">Upload Exercise (pdf)<span
                            style="color:#ff0000">*</span></label>
                    @if($viewModel->isEditMode())
                        <input type="file" class="form-control" id="customFile" />
                    @else
                        <input type="file" class="form-control" id="customFile" />

                    @endif
                </div>
                @error('sound')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <hr/>
            <div class="d-flex justify-content-end">
                <!--<input class="btn btn-outline-primary" type="reset" value="Ακύρωση">-->
                <a class="btn btn-outline-primary" href="{{route('resources.index')}}">
                    {{trans("messages.cancel")}}
                </a>

                <input  id="packageSubmitBtn" class="btn btn-primary ms-4" type="submit" value={{trans("messages.save_card")}}>
            </div>
        </div>
    </form>

@endsection
@push('scripts')
    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
