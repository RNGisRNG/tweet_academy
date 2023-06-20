<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../pages/login.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Social Media Twitter alike">
    <title>Meta sphere</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body data-bs-theme="dark">
<?php
include_once '../components/header.php';
createHeader("Profile");
?>

<nav class="navbar bg-body-tertiary p-3">
    <div class="container-fluid">
        <div>
            <a class="navbar-brand" href="../pages/home.php">
                <img width="60" height="48" src="../assets/logo.png" alt="MetaSphere Logo" class="d-inline-block me-3">
                Meta-Sphere</a>
        </div>
        <div>
            <button class="btn btn-secondary me-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-chat-fill" viewBox="0 0 16 16">
                    <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15z"/>
                </svg>
            </button>
            <button class="btn btn-primary" onclick="logout()">Logout</button>
        </div>
    </div>
</nav>
<main class="container mt-5">
    <div class="row">
        <div class="col-3 p-4">
            <div class="row mb-3">
                <div class="col-8">
                    <img width="150" height="150" src="../assets/profile_picture_placeholder.webp" alt="UserPhoto">
                </div>
            </div>
            <div class="row mb-2">
                <div id="userTag" class="col-8">
                    <?php
                    if (!isset($_GET['tag'])) {
                        print($_SESSION['user']['tag']);
                    } else {
                        print($_GET['tag']);
                    }
                    ?>
                </div>
            </div>
            <div class="row" id="followUser">
                <div id="followUser" class="col-3 me-2">
                    <h5>Follow</h5>
                </div>
                <div class="col-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-patch-plus-fill" viewBox="0 0 16 16">
                        <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0z"/>
                    </svg>
                </div>
                <div class="col-12 d-none" id="errorFollow">
                    <p></p>
                </div>
            </div>
        </div>
        <div class="col-6" id="tweetsContainer">
        </div>
    </div>
</main>
</body>
<footer>
    <?php include_once '../components/footer.php' ?>
    <script type="module" src="../scripts/profile.js"></script>
</footer>
</html>
