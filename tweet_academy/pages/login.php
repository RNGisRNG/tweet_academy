<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>Move or commit them before checkout
    <title>Title</title>
    <link rel="stylesheet" href="../styles/main.css"/>
</head>
<body class="text-center" data-bs-theme="dark">
<div class="container color_header ">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4">
        <img class="logo" src="../assets/logo.png" width="100" height="100" alt="logo">
    </header>
</div>
<div class="container">
    <div class="row justify-content-evenly mt-5">
        <div class="col-5 d-flex flex-column align-items-center">
            <h1 class="text-center text-primary">MetaSphere</h1>
            <p>
                Install our official mobil app and stay in touch with your friends anytime and anywhere. </p>
            <img src="../assets/telephone.png" width="400" height="500" alt="Two phones">
        </div>
        <div class="col-5 d-flex bloc_sign_in">
            <form class="col-12 d-flex flex-column align-items-center justify-content-center" id="sendLogin">
                <h1 class="h3 mb-5 fw-normal">Please sign in</h1>
                <div class="form-floating mb-3 w-50">
                    <input type="text" class="form-control bg-dark" id="loginEmail" placeholder="Email"/>
                    <label for="loginEmail">Email address</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input type="password" class="form-control bg-dark" id="loginPassword" placeholder="Password"/>
                    <label for="loginPassword">Password</label>
                </div>
                <button class="w-50 btn btn-lg btn-primary mb-3" type="submit">
                    Sign in
                </button>
                <p class="text-danger d-none mb-3" id="errorSignIn"></p>
                <p>Don´t have an account <a href="javascript:undefined" class="link-primary" id="signInButton">Sign
                        Up!</a></p>
                <p class="mt-5 mb-3 text-muted">© 2017–2022</p>
            </form>
            <form class="col-12 d-flex flex-column align-items-center justify-content-center d-none" id="sendRegister">
                <h1 class="h3 mt-5 mb-5 fw-normal">Please sign up</h1>
                <div class="form-floating mb-3 w-50">
                    <input type="text" class="form-control bg-dark" id="registerEmail" placeholder="Email"/>
                    <label for="registerEmail">Email</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input type="date" class="form-control bg-dark" id="registerBirthdate"/>
                    <label for="registerBirthdate">Birthdate</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input type="text" class="form-control bg-dark" id="registerName" placeholder="Name">
                    <label for="registerName">Name</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input type="password" class="form-control bg-dark" id="registerPassword" placeholder="Password"/>
                    <label for="registerPassword">Password</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input type="password" class="form-control bg-dark" id="registerConfirmPassword"
                           placeholder="Password"/>
                    <label for="registerConfirmPassword">Confirm Password</label>
                </div>
                <p class="text-danger d-none mb-3" id="errorSignUp"></p>
                <button class="w-50 btn btn-lg btn-primary mb-3" type="submit">
                    Sign Up
                </button>
                <p>Already have an account?
                    <a href="javascript:undefined" class="link-primary" id="signUpButton">
                        Sign In!</a></p>
                <p class="mt-2 text-muted">© 2017–2022</p>
            </form>
        </div>
    </div>
</div>
</body>
<footer>
    <?php include_once "../components/footer.php"; ?>
    <script type="module" src="../scripts/login.js"></script>
</footer>
</html>
