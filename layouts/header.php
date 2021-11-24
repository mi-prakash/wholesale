<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Mahmudul Islam">
    <title>Wholesale - <?=$thisPage?></title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <?php
        if($thisPage == "Log In" || $thisPage == "Sign Up") {
        ?>
        <link href="assets/css/signin.css" rel="stylesheet">
        <?php
        }
    ?>
    <link href="assets/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="assets/js/jquery3.6.0.min.js"></script>
    
    <?php
        if($thisPage == "Log In" || $thisPage == "Sign Up") {
        ?>
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <?php
        }
    ?>
</head>
<body>
    <div id="app-alerts">
        <div class="alert alert-info success-alert hidden" role="alert">
            <i class="fa fa-check-circle"></i> <span class="text"> Success Alert</span>
        </div>
        <div class="alert alert-danger error-alert hidden" role="alert">
            <i class="fa fa-exclamation-circle"></i> <span class="text"> Danger Alert</span>
        </div>
    </div>
    <div class="app-loader hidden">
        <div class="loader text-center my-5 py-5"><span class="fa fa-refresh fa-3x fa-spin mb-2"></span><p>Processing...</p></div>
    </div>