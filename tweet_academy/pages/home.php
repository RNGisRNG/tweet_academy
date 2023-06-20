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
createHeader();
?>

<nav class="navbar bg-body-tertiary p-3">
    <div class="container-fluid">
        <div>
            <a class="navbar-brand" href="../pages/home.php">
                <img width="60" height="48" src="../assets/logo.png" alt="MetaSphere Logo"
                     class="d-inline-block me-3">
                Meta-Sphere</a>
        </div>
        <div>
            <form class="row input-group has-validation align-items-center" id="searchUser">
                <div class="col-10">
                    <div class="form-floating">
                        <input type="text" class="form-control bg-dark" id="inputSearch" placeholder="@user">
                        <label for="inputSearch">Search User</label>
                    </div>
                    <div class="invalid-feedback ms-1">
                    </div>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
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
            <button class="btn btn-secondary me-1" onclick="redirectMessage()">
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
            <div class="row">
                <div class="col-12 mb-2">
                    <button class="btn btn-lg btn-dark d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-hash me-2" viewBox="0 0 16 16">
                            <path d="M8.39 12.648a1.32 1.32 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1.06 1.06 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.512.512 0 0 0-.523-.516.539.539 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532 0 .312.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531 0 .313.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242l-.515 2.492zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                        </svg>
                        Explore
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-lg btn-dark d-flex align-items-center
                    justify-content-center" onclick="redirectSettings()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi
                        bi-gear me-2" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                        </svg>
                        Settings
                    </button>
                </div>
            </div>
        </div>
        <div class="col-6 p-4">
            <form class="row mt-2 justify-content-end has-validation" id="sendTweet">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control bg-dark" placeholder="Write a tweet here"
                                  id="inputTweet" style="height: 100px"></textarea>
                        <label for="inputTweet">Tweet</label>
                    </div>
                    <div class="invalid-feedback ms-1">
                    </div>
                    <div class="valid-feedback ms-1">
                    </div>
                </div>
                <div class="col-auto mt-2">
                    <button class="btn btn-primary" type="submit" id="btnTweet">Tweet</button>
                </div>
            </form>
            <div class="row mt-4 d-none" id="tweets">
            </div>
            <p class="d-none text-danger" id="errorTweets">
            </p>
        </div>
        <div class="col-3 p-4">
            <div class="row" id="searchResult">
            </div>
        </div>
    </div>
</main>
</body>
<footer>
    <?php include_once '../components/footer.php' ?>
    <script type="module" src="../scripts/home.js"></script>
</footer>
</html>
