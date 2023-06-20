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
    <title>Messages</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body data-bs-theme="dark" data-tag="<?php echo $_SESSION['user']['tag']; ?>">
<?php
include_once '../components/header.php';
createHeader("Home");
?>
<nav class=" navbar bg-body-tertiary p-3
">
    <div class="container-fluid">
        <div>
            <a class="navbar-brand" href="../pages/home.php">
                <img width="60" height="48" src="../assets/logo.png" alt="MetaSphere Logo"
                     class="d-inline-block me-3">
                Meta-Sphere</a>
        </div>
        <div>
            <button class="btn btn-info me-1" onclick="redirectProfile()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd"
                          d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
            </button>
            <button class="btn btn-primary" onclick="logout()">Logout</button>
        </div>
    </div>
</nav>
<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3 d-none" id="windowConversations">
                <div class="row">
                    <div class="col-12 mb-4">
                        <h5 class="text-primary">Conversations</h5>
                    </div>
                </div>
            </div>
            <div class="col-6 p-4" id="windowMessages">
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</section>
<body>
<footer>
    <?php include_once "../components/footer.php"; ?>
    <script type="module" src="../scripts/messages.js"></script>
</footer>
</html>
