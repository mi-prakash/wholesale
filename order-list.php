<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location: login.php");
    }
    $thisPage = "Order List";
?>

<?php include_once $base_url."layouts/header.php"; ?>

<?php include_once $base_url."layouts/navbar.php"; ?>

<section class="py-4 text-center container">
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light"><?= $thisPage ?></h1>
        </div>
    </div>
</section>
<div class="py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem magnam ratione dicta saepe sint, mollitia beatae velit optio minus reiciendis cum obcaecati perferendis deserunt amet maxime culpa officiis maiores corrupti.</p>
        </div>
    </div>
</div>

<?php include_once $base_url."layouts/footer.php"; ?>