@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{mix('dist/css/terms-of-use.css')}}">
@endpush
@section('content')

    <div id="terms-of-use-page" class="container py-5">
        <div class="mb-5">
            <div class="row">
                <div class="col-12 mx-auto mb-3 text-center">
                    <h1>{!! __('messages.terms-of-use') !!}</h1>
                </div>
            </div>
            <p>{!! __('messages.terms-of-use-prologue') !!}</p>
            <div class="row">
                <div class="col mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col mx-auto">
                                <ul>
                                    <li>{!! __('messages.term-of-use-1') !!}</li>
                                    <li>{!! __('messages.term-of-use-2') !!}</li>
                                    <li>{!! __('messages.term-of-use-3') !!}</li>
                                    <li>{!! __('messages.term-of-use-4') !!}</li>
                                    <li>{!! __('messages.term-of-use-5') !!}</li>
                                    <li>{!! __('messages.term-of-use-6') !!}</li>
                                    <li>{!! __('messages.term-of-use-7') !!}</li>
                                    <li>{!! __('messages.term-of-use-8') !!}</li>
                                    <li>{!! __('messages.term-of-use-9') !!}</li>
                                    <li>{!! __('messages.term-of-use-10') !!}</li>
                                    <li>{!! __('messages.term-of-use-11') !!}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col mx-auto text-center">
                                <h2 class="fw-bold mb-4">{!! __('messages.data_deletion_title') !!}</h2>
                                <p id="data-deletion" class="text-start">
                                    {!! __('messages.data_deletion_request', ['app_name' => 'Dianoia', 'app_support_email' => 'info[at]scify.org']) !!}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 offset-9">
                                <p>{!! __('messages.last-amendment') !!}: 5 Dec. 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
