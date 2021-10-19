<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="resources/sass/main.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <title>dianoia marketplace</title>
</head>

<body>
    <div class="navigation">
        MENU
    </div>
    <main class="content">


        <!-- Section with administration card (user-info & excercises-tabs)  -->
        <div class="user-card shadow mt-5">

            <div class="row user-info ">
                <div class="col-xl-9 col-md-7 col-xs-12 ">
                    <h1>Paul Miller <span>(paulmiller@hotmail.com)</span> </h1>
                    <p>Ιδιώτης Φροντιστής</p>
                </div>

                <div class="col-xl-3 col-md-5 col-xs-12">
                    <button> <a href="#" class="btn btn--secondary" target="_blank">Επεξεργασία προφίλ</a> </button>
                </div>
            </div>


            <div class="excercises-tabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Ασκήσεις για
                            ασθενείς</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Ασκήσεις για
                            φροντιστές</button>
                    </li>

                </ul>

            </div>

        </div>


        <!-- Section with results -->

            <div class="total-results row mt-5 mb-5">
                <div class="col-md-6 col-sm-12">
                    <h2>0 συνολικές προσθήκες</h2>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="input-group ">
                        <input type="search" class="form-control rounded" placeholder="Αναζήτηση καταχωρήσεων"
                            aria-label="Search" aria-describedby="search-addon" />
                        <button type="button" class="btn btn-outline-primary">Αναζήτηση</button>
                    </div>
                </div>

            </div>


            <div class="without-results">
                <p class="text-center">Αυτή τη στιγμή δεν έχετε δημιουργήσει κάποια άσκηση.<br/>
                    Για να δείτε ή να δημιουργήσετε μια καινούργια άσκηση πατήστε <a href="#">εδώ</a>.</p>
            </div>



        <!-- Section with excercises
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <div class="excercises">
                        <div class="excercise-template shadow communication-excercise">
                            <p class="mt-2 mb-4"><i class="fas fa-exclamation-circle"></i></i> Προς έγκριση</p>
                            <div class="text-center">
                                <h3 class="mb-5">
                                    Πακέτο επικοινωνίας
                                </h3>

                                <img src="/images/drink.png" alt="test">
                                <h3 class="mt-2 mb-3">
                                    Ποτά
                                </h3>
                                <button type="button" class="buttons mb-4">Δες το πακέτο</button>
                                <hr class="mt-4 mb-0">

                                <div class="row created-by">
                                    <div class="col-4 date-of-creation">
                                        <p>10 Ιουνίου 2021</p>
                                    </div>

                                    <div class="col-8">
                                        <p>Δημιουργήθηκε από τον <b>John Siller</b> (john-siller@hotmail.com)</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="excercise-template shadow game-excercise">
                            <p class="mt-2 mb-4"><i class="fas fa-exclamation-circle"></i> Προς έγκριση</p>

                            <div class="text-center">
                                <h3 class="mb-5">
                                    Πακέτο παιχνιδιού
                                </h3>

                                <img src="/images/reaction.png" alt="test">
                                <h3 class="mt-2 mb-3">
                                    Ερέθισμα-Αντίδραση
                                </h3>

                                <button type="button" class="buttons mb-4">Δες το πακέτο</button>




                                <hr class="mt-4 mb-0">

                                <div class="row created-by">
                                    <div class="col-4 date-of-creation">
                                        <p>10 Ιουνίου 2021</p>
                                    </div>

                                    <div class="col-8">
                                        <p>Δημιουργήθηκε από τον <b>John Siller</b> (john-siller@hotmail.com)</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
-->
        <!-- Section with excercises approved
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <div id="excercises-approved" class="excercises ">

                        <div class="excercise-template shadow communication-excercise">
                            <p class="mt-2 mb-4"><i class="far fa-check-circle"></i> Εγκρίθηκε στις 15 Ιουνίου 2021</p>
                            <div class="text-center">
                                <h3 class="mb-5">
                                    Πακέτο επικοινωνίας
                                </h3>

                                <img src="/images/drink.png" alt="test">
                                <h3 class="mt-2 mb-3">
                                    Ποτά
                                </h3>
                                <button type="button" class="buttons mb-4">Δες το πακέτο</button>
                                <hr class="mt-4 mb-0">

                                <div class="row created-by">
                                    <div class="col-4 date-of-creation">
                                        <p>10 Ιουνίου 2021</p>
                                    </div>

                                    <div class="col-8">
                                        <p>Δημιουργήθηκε από τον <b>John Siller</b> (john-siller@hotmail.com)</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="excercise-template shadow game-excercise">
                            <p class="mt-2 mb-4"><i class="far fa-check-circle"></i> Εγκρίθηκε στις 15 Ιουνίου 2021</p>

                            <div class="text-center">
                                <h3 class="mb-5">
                                    Πακέτο παιχνιδιού
                                </h3>

                                <img src="/images/reaction.png" alt="test">
                                <h3 class="mt-2 mb-3">
                                    Ερέθισμα-Αντίδραση
                                </h3>

                                <button type="button" class="buttons mb-4">Δες το πακέτο</button>


                                <hr class="mt-4 mb-0">

                                <div class="row created-by">
                                    <div class="col-4 date-of-creation">
                                        <p>10 Ιουνίου 2021</p>
                                    </div>

                                    <div class="col-8">
                                        <p>Δημιουργήθηκε από τον <b>John Siller</b> (john-siller@hotmail.com)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
-->







    </main>
    <footer class="footer">
        <p>Created by SciFY @2021</p>
    </footer>
</body>


</html>
