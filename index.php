<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location: login.php");
    }
    $thisPage = "Home";
?>

<?php include_once $base_url."layouts/header.php"; ?>

<?php include_once $base_url."layouts/navbar.php"; ?>

<section class="py-4 text-center container">
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Lists of Product</h1>
        </div>
    </div>
</section>
<div class="py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
            <div class="col mb-3">
                <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>

                    <div class="card-body">
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><b>Price</b> $10</small>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>

                    <div class="card-body">
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><b>Price</b> $10</small>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>

                    <div class="card-body">
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><b>Price</b> $10</small>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>

                    <div class="card-body">
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><b>Price</b> $10</small>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>

                    <div class="card-body">
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><b>Price</b> $10</small>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>

                    <div class="card-body">
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><b>Price</b> $10</small>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-info">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once $base_url."layouts/footer.php"; ?>