@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/content-guidelines.css') }}">
@endpush

@section('content')
    <section id="intro" class="">
        <div class="container">
            <div style="margin-top:200px; text-align:left; top:357px; left: 255px; width:574px; height: 53px; font-size: 40px; color: black; font-family: 'Roboto Condensed Medium',sans-serif">
                    Instructions for content creators.
            </div>
            <div style="margin-top:25px; font-size: 18px; font-family: 'Roboto Condensed',serif;">

                <p  class="mb-1">
                    Dianoia Marketplace is an online application implemented and available for free by the non-profit  SciFY so that everyone can create and share their own free content for the Dianoia application.
                </p>

                <p>
                    The content of Dianoia Marketplace is mainly aimed at people that take care of people/patients with onset dementia or/and Alzheimer’s.
                </p>

                <p>
                    People with onset dementia, due to the progressive decline of their mental abilities, have the need for appropriate care
                    at every stage. The caregivers feel that they have a great responsibility for their care.
                </p>

            </div>
        </div>
    </section>
    <section id="resources-steps" class="pt-5" style="background-color: var(--page-background-color);">
        <div class="container">
            <div class="row">
                <div class="col-md-10" >
                    <div class="accordion" id="accordionExample" >
                        <div class="accordion-item my-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button guidelines-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <span class="section-title">  Content creation - Content for people with onset dementia</span>
                                </button>
                            </h2>
                            <div style=" background-color:  var(--page-background-color);" id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                <div class="accordion-body guidelines-accordion-body">
                                    <p>
                                        The goal of the content uploaded on Dianoia Marketplace is to help people with onset dementia improve their mental functions, their mood, their functionality, and quality of life, by giving them riddles, helping them look back on memories, or even on daily chores or activities they loved.
                                    </p>

                                    <p>
                                        Also, the goal is for Dianoia Marketplace to become a point of reference and content hub for exercises in categories like: Memory exercises, Attention, Thought and Speech, Executive Functions, which are available in 2 levels of difficulty (normal and hard).

                                    </p>
                                    <p>
                                        The users of Dianoia Marketplace must upload content with simple language, comprehensible text, and legible font and instructions. More analytic instructions for the various content categories for people/patients with onset dementia are given below:
                                    </p>

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
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="float:left">
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-title">Category "Attention Exercises"</p>
                                                            <p class="card-text">In this category, there are exercises aiming at exercising and improving the patient’s attention. Examples of exercises:</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="float:left">
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-title">Category "Thought and Speech Exercises"</p>
                                                            <p class="card-text">In this category, there are exercises aiming at exercising and improving the patient’s speech ability, as well as the connection between their speech and thought. Examples of exercises:</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="float:left">
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-title">Category “Executive Functions”</p>
                                                            <p class="card-text">In this category, there are exercises aiming at bringing the patient in contact with daily chores, as well as exercising on simple processes. Examples of exercises:</p>
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
                            <h2 class="accordion-header" >
                                <button class="accordion-button guidelines-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                    <span class="section-title"> Content creation - Content for caregivers of people with onset dementia </span>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                 aria-labelledby="headingTwo">
                                <div class="accordion-body guidelines-accordion-body">
                                    <p>
                                        Other than the exercises and the activities for people with onset dementia, the Dianoia Marketplace platform also aims to create and deliver content to the caregivers of these people.
                                    </p>
                                    <p>
                                        For that reason, there’s also the category “Exercises for the caregivers” which includes exercises and activities for the caregivers. Examples of exercises:
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item my-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button guidelines-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    <span class="section-title"> Notes for the finding, editing, and uploading content for the exercises and activities</span>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse show"
                                 aria-labelledby="headingThree">
                                <div class="accordion-body guidelines-accordion-body">
                                    <p><b>0.1 Images</b></p>
                                    <p>The image that accompanies an exercise/activity must show in the clearest way possible the content of the exercise, to cover the patient’s need. For example, in a “Name-Animal-Object-Plant” exercise, we must select an image that meets all the following criteria:</p>
                                    <p><span class="list-number">1</span> <span >It must show the exercise’s table and an example for every category, but no other objects that may confuse the user and their caregiver.</span></p>
                                    <p><span class="list-number">2</span> <span>Its dimensions must be approximately 600 by 400 pixels.</span></p>
                                    <p><span class="list-number">3</span> <span>It mustn’t be larger than 2 megabytes.</span></p>
                                    <p><span class="list-number">4</span> <span >It must be a .png, .jpg, or .jpeg file.</span></p>
                                    <p><span class="list-number">5</span> <span >It must be able to be used freely, with the appropriate copyright.</span></p>

                                    <p>To crop, reduce or change the type of images we have on our computer or that we have downloaded from the Internet, we can use an online tool, such as <span style="color:green; font-family: 'Roboto Condensed Extrabold'"> Online Image Converter.</span>
                                    <p>To find images with copyright that allow their use, we can use the following websites (indicative):                                     or download a tool such as <span style="color:green; font-family: 'Roboto Condensed Extrabold'">Pixabay / Unsplash / Pexels / Shutterstock</span></p>

                                    <p style="margin-top:75px"><b>0.2 Exercises/Activities' Documents</b></p>
                                    <p>Every exercise/activity available in “Dianoia” is accompanied by a PDF file (.pdf file extension) containing the full exercise, with a description of its goal and its instructions. This makes things easier for the caregiver concerning the printing of the exercise so that it’s easier for the patient to do. Every file uploaded to the Dianoia Marketplace platform must meet all the following criteria:</p>

                                    <p><span class="list-number">1</span> <span>It must include in a clear way the title of the exercise, its description, its goal, as well as its instructions.</span></p>
                                    <p><span class="list-number">2</span> <span>It must be complete as to the content of the exercise/activity.</span></p>
                                    <p><span class="list-number">3</span> <span >It mustn’t be larger than 2 megabytes.</span></p>
                                    <p><span class="list-number">4</span> <span>It must be a PDF file</span></p>
                                    <p><span class="list-number">5</span> <span>It must be able to be used freely, with the appropriate copyright.</span></p>


                                    <p>
                                        To crop, edit or change a file we have on our computer, our mobile phone or that we have downloaded from the Internet, we can use an online tool, such as Small Pdf.
                                    </p>
                                    <p>
                                        To create text documents on our computer, with copyright that allows their use, we can use the following applications: Libreoffic / Microsoft Office
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col md-2 guidelines-sidebar">
                    <span class="sidebar-title">Content</span>
                    <hr>
                    <span class="sidebar-content"> Content creation - Content for people with onset dementia</span>
                    <hr>
                    <span class="sidebar-content">Content creation - Content for caregivers of people with onset dementia</span>
                    <hr>
                    <span class="sidebar-content"> Notes for the finding, editing, and uploading content for the exercises and activities</span>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ mix('dist/js/home.js') }}"></script>
@endpush
