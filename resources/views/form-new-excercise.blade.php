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

        <div class="form mt-5 mb-5 rounded">
            <p class="form-title">Νέα άσκηση</p>
            <hr>
            <div class="form-fields">
                <form class="row g-3">

                    <div class="col-12">
                        <label for="formGroupExampleInput" class="form-label">Όνομα <span>*</span></label>
                        <input type="text" class="form-control" id="formGroupExampleInput" required="true">
                    </div>
                    <div class="col-12">
                        <label for="formGroupExampleInput2" class="form-label">Περιγραφή άσκησης <span>*</span></label>
                        <input type="text" class="form-control" id="formGroupExampleInput2">
                    </div>

                    <div class="col-md-6">
                        <label for="formFile" class="form-label">Ανέβασε εικόνα</label>
                        <!-- <input class="form-control" type="file" id="formFile"> -->
                        <div class="file btn rounded">
                            <i class="fas fa-plus-circle"></i>
                            <input type="file" name="file" />
                        </div>
                    </div>

                    <p class="required-text">* Απαραίτητα στοιχεία</p>

                    <div class="col-md-6 ">
                        <div class="dropdown">
                            <p>Γλώσσα</p>
                            <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Ελληνικά
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Μεγαλύτερη βαθμολογία</a></li>
                                <li><a class="dropdown-item" href="#">Χαμηλότερη βαθμολογία</a></li>
                                <li><a class="dropdown-item" href="#">Νεότερες βαθμολογίες</a></li>
                                <li><a class="dropdown-item" href="#">Όλες οι βαθμολογίες</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <p>Κατηγορία</p>
                            <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton3"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Ασκήσεις προσοχής
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <li><a class="dropdown-item" href="#">Μεγαλύτερη βαθμολογία</a></li>
                                <li><a class="dropdown-item" href="#">Χαμηλότερη βαθμολογία</a></li>
                                <li><a class="dropdown-item" href="#">Νεότερες βαθμολογίες</a></li>
                                <li><a class="dropdown-item" href="#">Όλες οι βαθμολογίες</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <p>Επίπεδο</p>
                            <button class="btn btn--search dropdown-toggle" type="button" id="dropdownMenuButton2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Κανονικό
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item" href="#">Μεγαλύτερη βαθμολογία</a></li>
                                <li><a class="dropdown-item" href="#">Χαμηλότερη βαθμολογία</a></li>
                                <li><a class="dropdown-item" href="#">Νεότερες βαθμολογίες</a></li>
                                <li><a class="dropdown-item" href="#">Όλες οι βαθμολογίες</a></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

            <div class="prototype-file text-center">
                <em> Οι ασκήσεις που θα ανεβάσεις στην πλατφόρμα πρέπει να έχουν περιεχόμενο σύμφωνο με την δομή του
                    πρωτότυπου εγγράφου <a href="">εδώ</a>.</em>

            </div>

            <div class="submit-exercise-file">

                <div class="pdf-file d-flex align-items-center mb-5 mt-5">
                    <p>Ανέβασε το .pdf αρχείο με την άσκηση </p>

                    <div class="file btn circle d-flex align-items-center ms-3">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" name="file" />
                    </div>

                </div>

                <div class="uploaded-file">
                    No_name.pdf <button type="button" class="btn btn-outline-secondary reset" id="btnResetFile">X</button>
                </div>

                <div class="copyright-rules mb-5 mt-5">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Έχω διαβάσει τους <b><u>κανόνες περιεχομένου και πνευματικής ιδιοκτησίας</u></b>, καθώς και
                            τους όρους για
                            την
                            δομή της άσκησής, όπως στο <b><u>παράδειγμα</u></b>.
                        </label>
                    </div>
                </div>

                <div class="admin-message">
                    Σε περίπτωση που γίνει δεκτή η άσκηση που θα δημιουργήσεις, η διαχειριστική ομάδα της SciFY θα
                    επιλέξει αν η άσκηση θα είναι διαθέσιμη μόνο από το marketplace για κατέβασμα σαν .pdf, ή και από τη
                    mobile εφαρμογή
                </div>



            </div>

            <hr>

            <div class="submmit-btn d-flex justify-content-end p-5">
                <button type="reset" class="btn btn--secondary mt-5">Ακύρωση</button>
                <button type="submit" class="btn btn--primary mt-5 ms-4">Δημιουργία άσκησης</button>
            </div>
        </div>

    </main>
    <footer class="footer">
        <p>Created by SciFY @2021</p>
    </footer>
</body>


</html>
