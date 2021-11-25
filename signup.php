<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (isset($_SESSION['id'])) {
        header("location: index.php");
    }
    $thisPage = "Sign Up";
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once $base_url."layouts/header.php"; ?>

<main class="form-signin text-center">
    <form  autocomplete="off" action="includes/signup.inc.php" method="POST">
        <h3>Wholesale App</h3>
        <h5 class="mb-3 fw-normal">Sign Up</h5>

        <div class="form-floating mb-1">
            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
            <label for="name">Full Name</label>
        </div>

        <div class="form-floating mb-1">
            <select class="form-select" name="type" id="type">
                <option value="">Select Any</option>
                <option value="customer">Customer</option>
                <option value="seller">Seller</option>
            </select>
            <label for="type">User Type</label>
        </div>

        <div class="form-floating mb-1">
            <input autocomplete="off" type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-1">
            <input autocomplete="new-password" type="password" class="form-control" id="password" name="password" placeholder="Password">
            <label for="password">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-info text-light" type="submit" name="submit"><i class="fa fa-save"></i> Register</button>
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
                if(isset($_GET["error"]) && $_GET["error"] == "emailmatch") {
                ?>
                    <p>This Email is already taken</p>
                <?php
                }
                if(isset($_GET["error"]) && $_GET["error"] == "queryfailed") {
                ?>
                    <p>Error! Please Try again</p>
                <?php
                }
            ?>
        </div>
        <p class="mt-4 mb-3 text-muted">Go back to <a href="login.php" class="text-info">Log In</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; Wholesale by Mahmudul Islam</p>
    </form>
</main>

<?php include_once $base_url."layouts/footer.php"; ?>