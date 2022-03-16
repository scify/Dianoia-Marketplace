@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/content-guidelines.css') }}">
@endpush

@section('content')
    <section id="intro" >
        <div class="container ">
            <div style="margin-top:200px; text-align:left; top:357px; left: 255px; width:574px; height: 53px; font-size: 40px; color: black; font-family: 'Roboto Condensed Medium',sans-serif">
                    Instructions for content creators.
            </div>
            <div style="margin-top:25px; font-size: 18px; font-family: 'Roboto Condensed',serif;">
                <p class="mb-1">
                    {!! __('messages.guidelines-prologue') !!}
                </p>
            </div>
        </div>
    </section>
    <section id="resources-steps" class="guidelines-steps pt-5" style="background-color: var(--page-background-color);">
        <div class="container">
            <div class="row">
                <div class="col-md-10" >
                    <div id="my_accordion" class="accordion">
                        <div class="accordion-item my-3">
                            <h2 id="header-1" class="accordion-header">
                                <button id="section_one" class="accordion-button guidelines-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <span class="section-title">  {!! __('messages.guidelines-header-1') !!}</span>
                                </button>
                            </h2>

                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                                <div class="accordion-body guidelines-accordion-body">
                                  {!! __('messages.guidelines-section-1') !!}

                                    <!--Carousel Wrapper-->
                                    <div id="multi-item-example" class="carousel guidelines-carousel  slide carousel-multi-item" data-ride="carousel">

                                        <!--Slides-->
                                        <div class="carousel-inner" role="listbox">

                                            <!--First slide-->
                                            <div class="carousel-item active">

                                                <div class="col-md-3" style="float:left">
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-title">Category "Memory Exercises"</p>
                                                            <p class="card-text">In this category, there are exercises aiming at exercising and improving the patient’s memory. Examples of exercises</p>

                                                            <p style="bottom: 40pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1ZTqNmydadRqn7DR0p-g39CkeS2Da-VfW/view" target="_blank">See Memorize word list </a>
                                                            </p>
                                                            <p style="bottom: 10pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1eBv6cc3iU1DuTUXy-Br5mfVrPwO33xIv/view" target="_blank">See Word Categories</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="float:left">
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-title">Category "Attention Exercises"</p>
                                                            <p class="card-text">In this category, there are exercises aiming at exercising and improving the patient’s attention. Examples of exercises:</p>

                                                            <p style="bottom: 40pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1K6ozqJheub91goQ0jxWBmNccus89mw6h/view" target="_blank">Shading Shapes </a>
                                                            </p>
                                                            <p style="bottom: 10pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1NpKILAmzk0dk6mXd77xDky4lWmgnQy7W/view" target="_blank">Copy correctly</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="float:left">
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-title">Category "Thought and Speech Exercises"</p>
                                                            <p class="card-text">In this category, there are exercises aiming at exercising and improving the patient’s speech ability, as well as the connection between their speech and thought. Examples of exercises:</p>
                                                            <p style="bottom: 50pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1vz_KLGHC3KU7cS4ggVtbeCpfk2fYVvTy/view" target="_blank">Find the word </a>
                                                            </p>
                                                            <p style="bottom: 5pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1_ZpddHjEQrPLo2daZGj4iz1zadmTDIKV/view" target="_blank">Color and Think - Double work exercise</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="float:left">
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-title">Category “Executive Functions”</p>
                                                            <p class="card-text">In this category, there are exercises aiming at bringing the patient in contact with daily chores, as well as exercising on simple processes. Examples of exercises:</p>
                                                            <p style="bottom: 40pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1bxraGStL8uRhCuVnDt70_Ma7Ph8hSCMU/view" target="_blank">Relaxation techniques for stress relief</a>
                                                            </p>
                                                            <p style="bottom: 10pt; position:absolute">
                                                                <a  href="https://drive.google.com/file/d/1DMTGkJGOAw2Wqhn_hZ-RdX1gp2TwaLgS/view" target="_blank">Use of Mindfulness Technique</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.First slide-->
                                        </div>
                                        <!--/.Slides-->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item my-3">
                            <h2 id="header-2" class="accordion-header" >
                                <button id="section_two" class="accordion-button guidelines-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                    <span class="section-title"> {!! __('messages.guidelines-header-2') !!}</span>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                                <div class="accordion-body guidelines-accordion-body">
                                    {!! __('messages.guidelines-section-2') !!}
                                    <div style="margin-top:20pt">
                                        <p>
                                            <a href="https://drive.google.com/file/d/1bxraGStL8uRhCuVnDt70_Ma7Ph8hSCMU/view" target="_blank">  See Relaxation techniques for stress relief </a>
                                        </p>
                                        <p>
                                            <a href="https://drive.google.com/file/d/1DMTGkJGOAw2Wqhn_hZ-RdX1gp2TwaLgS/view" target="_blank">  See Use of Mindfulness Technique </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item my-3">
                            <h2 id="header-3" class="accordion-header">
                                <button id="section_three" class="accordion-button guidelines-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    <span class="section-title"> {!! __('messages.guidelines-header-3') !!}</span>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                                <div class="accordion-body guidelines-accordion-body">
                                    <p><b>0.1 {!! __('messages.guidelines-section-3-subsection-header-1') !!}</b></p>
                                    {!! __('messages.guidelines-section-3-subsection-1')!!}

                                    <p style="margin-top:75px"><b>0.2 {!! __('messages.guidelines-section-3-subsection-2-header') !!}</b></p>
                                    {!! __('messages.guidelines-section-3-subsection-2') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col md-2 guidelines-sidebar">
                    <span class="sidebar-title">Content</span>
                    <hr>
                    <span id="linkToFirstSection" class="sidebar-content" type="button" style="color:var(--primary)"> {!! __('messages.guidelines-header-1') !!}</span>
                    <hr>
                    <span id="linkToSecondSection" class="sidebar-content" type="button" style="color:var(--primary)"> {!! __('messages.guidelines-header-2') !!}</span>
                    <hr>
                    <span id="linkToThirdSection" class="sidebar-content" type="button" style="color:var(--primary)">  {!! __('messages.guidelines-header-3') !!}</span>
                </div>
            </div>
        </div>
        <!-- Back to top button -->
        <button  type="button"  class="btn btn-floating btn-lg"  id="btn-back-to-top"> <i class="fas fa-arrow-up" style="font-size:20pt"></i></button>
    </section>
@endsection
@push('scripts')

    <script src="{{ mix('dist/js/content-guidelines.js') }}"></script>
@endpush
