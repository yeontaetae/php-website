<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>Art by You</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column">
        <?php
            session_start();
            require_once("serverlogin.php");
            $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
            if($conn->connect_error){
                die("Connection failed!".mysqli_connect_error());
            }
            mysqli_select_db($conn, $db_database) or die ("Unable to select database:". mysql_error());

            if(isset($_POST['register'])){
                $name=$_POST['name'];
                $type=$_POST['type'];
                $about=$_POST['about'];
                $img=$_POST['image'];
                $username=$_POST['username'];
                $password=$_POST['password'];
                $img_path='files/' . $type . '/' . $img;

                $artist_ID_query="SELECT `ArtistID` FROM `Artists` WHERE `Name`='$name'";
                $result=$conn->query($artist_ID_query);
                $artist_ID=$result->fetch_assoc();

                $statement=$conn->prepare("INSERT INTO Artists(`Name`, `ArtistImage`, `Type`, `Description`) VALUES (?,?,?,?)");
                $statement->bind_param("ssss", $name, $img_path, $type, $about);
                $statement->execute();
                
                $statement2=$conn->prepare("INSERT INTO Signin(`ArtistID`,`Username`,`Password`) VALUES (?,?,?)");
                $statement2->bind_param("sss", $artist_ID, $username, $password);
                $statement2->execute();

                $statement->close();
                $statement2->close();
            }
            $conn->close();
        ?>
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.php">Art by You</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="post.php">Post</a></li>
                            <li class="nav-item"><a class="nav-link" href="artists.php">Artists</a></li>
                            <li class="nav-item"><a class="nav-link" href="collections.php">Collections</a></li>
                            <li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <section class="py-5">
                <div class="container px-5">
                    <!-- Sign-in form-->
                    <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                        <div class="text-center mb-5">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i></div>
                            <h1 class="fw-bolder">Create New Account</h1>
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                                <form id="signUpForm" method="post" action="createAccount.php">
                                    <!-- Name input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="name" type="text" name="name" placeholder="Enter your name..." data-sb-validations="required" />
                                        <label for="name">Name</label>
                                        <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                                    </div>
                                    <!-- Type of Artist input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="type" type="text" name="type" placeholder="Enter your type..." data-sb-validations="required" />
                                        <label for="type">Type of Artist</label>
                                        <div class="invalid-feedback" data-sb-feedback="type:required">A type is required.</div>
                                    </div>
                                    <!-- About input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="about_you" type="text" name="about" placeholder="Enter your story..." data-sb-validations="required" />
                                        <label for="about_you">Tell us about you</label>
                                        <div class="invalid-feedback" data-sb-feedback="about_you:required">About is required.</div>
                                    </div>
                                    <!-- Image input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="image" type="text" name="image" placeholder="Enter your image name..." data-sb-validations="required" />
                                        <label for="image">Upload an image of yourself</label>
                                        <div class="invalid-feedback" data-sb-feedback="username:required">An image is required.</div>
                                    </div>
                                    <!-- Username input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="username" type="text" name="username" placeholder="Enter your username..." data-sb-validations="required" />
                                        <label for="username">Create a Username</label>
                                        <div class="invalid-feedback" data-sb-feedback="username:required">An username is required.</div>
                                    </div>
                                    <!-- Password input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" type="password" name="password" placeholder="Enter your password..." data-sb-validations="required" />
                                        <label for="password">Create a Password</label>
                                        <div class="invalid-feedback" data-sb-feedback="password:required">A password is required.</div>
                                    </div>
                                    <!-- Submit success message-->
                                    <!---->
                                    <!-- This is what your users will see when the form-->
                                    <!-- has successfully submitted-->
                                    <!-- <div class="d-none" id="submitSuccessMessage">
                                        <div class="text-center mb-3">
                                            <div class="fw-bolder">Form submission successful!</div>
                                            To activate this form, sign up at
                                            <br />
                                            <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                        </div>
                                    </div>
                                    Submit error message-->
                                    <!---->
                                    <!-- This is what your users will see when there is-->
                                    <!-- an error submitting the form-->
                                    <!-- <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div> -->
                                    <!-- Submit Button-->
                                    <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton" name="register" type="submit">Submit</button></div>
                                </form>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Your Website 2022</div></div>
                    <div class="col-auto">
                        <a class="link-light small" href="#!">Privacy</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Terms</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
