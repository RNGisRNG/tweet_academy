<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Settings</title>
    <link href="../styles/main.css" rel="stylesheet">
</head>

<body data-bs-theme="dark">
<header class="container d-flex flex-row color_header p-2">
    <div class="row justify-content-center align-items-center">
        <div class="col-1">
            <img class="m-3 img-fluid" src="../assets/logo.png" alt="MetaSphere Logo">
        </div>
        <div class="col-11 text-center">
            <h1 class="text-white fw-bold">Account settings</h1>
        </div>
    </div>
</header>
<main>
    <div class="container py-3">
        <button class="col-1 btn btn-primary" type="button" onclick="redirectHome()">Back</button>
    </div>
    <form class="container w-50 p-3 d-flex flex-column justify-content-between p-5 bloc_sign_in settings-form"
          id="formUpdateProfile">
        <div class="row text-center">
            <img class="col-3 rounded-circle" src="" alt="">
            <p>Update your settings</p>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control bg-dark" id="name" placeholder="Name"/>
            <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control bg-dark" id="tagname" placeholder="Tagname"/>
            <label for="tagname">Tagname</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control bg-dark" id="biography" placeholder="Biography"/>
            <label for="biography">Biography</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control bg-dark" id="Email" placeholder="Email"/>
            <label for="Email">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control bg-dark" id="password" placeholder="Password"/>
            <label for="password">Password</label>password
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control bg-dark" id="confirm-password" placeholder="Confirm Password"/>
            <label for="confirm-password">Confirm Password</label>
        </div>
        <div class="row d-flex flex-row justify-content-evenly">
            <button class="col-4 btn btn-primary" type="submit">Validate</button>
            <button class="col-4 btn btn-primary" type="button" onclick="deleteAccount()">Delete account</button>
        </div>
    </form>
</main>
</body>
<footer>
    <?php include_once "../components/footer.php"; ?>
    <script type="module" src="../scripts/settings.js"></script>
</footer>
</html>
