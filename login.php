<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (isset($_SESSION['id'])) {
        header("location: index.php");
    }
    $thisPage = "Log In";
?>

<?php include_once $base_url."layouts/header.php"; ?>

<main class="form-signin text-center">
    <form action="includes/login.inc.php" method="POST">
        <h3>Wholesale App</h3>
        <h5 class="mb-3 fw-normal">Please Log In</h5>

        <div class="form-floating">
            <input type="email" class="form-control" id="email" name="email" placeholder="name@wholesale.com">
            <label for="email">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <label for="password">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-info text-light" type="submit" name="submit"><i class="fa fa-sign-in-alt"></i> Log In</button>
        <div class="alert mt-3 text-success">
            <?php
                if(isset($_GET["response"]) && $_GET["response"] == "signupsuccess") {
                ?>
                    <p>Registration success! Please Log In</p>
                <?php
                }
            ?>
        </div>
        <div class="errors mt-3 text-danger">
            <?php
                if(isset($_GET["error"]) && $_GET["error"] == "emptyinput") {
                ?>
                    <p>Please fill up all the fields</p>
                <?php
                }
                if(isset($_GET["error"]) && $_GET["error"] == "invalidemail") {
                ?>
                    <p>The Email is invalid</p>
                <?php
                }
                if(isset($_GET["error"]) && $_GET["error"] == "usernotfound") {
                ?>
                    <p>The User is not found</p>
                <?php
                }
                if(isset($_GET["error"]) && $_GET["error"] == "wrongpassword") {
                ?>
                    <p>Your Password is wrong</p>
                <?php
                }
                if(isset($_GET["error"]) && $_GET["error"] == "queryfailed") {
                ?>
                    <p>Error! Please Try again</p>
                <?php
                }
            ?>
        </div>
        <p class="mt-4 mb-3 text-muted">Not a member? <a href="signup.php" class="text-info">Sign Up</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; Wholesale by Mahmudul Islam</p>
    </form>
</main>

<?php include_once $base_url."layouts/footer.php"; ?>