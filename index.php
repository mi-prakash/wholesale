<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location: login.php");
    }
    $thisPage = "Home";
?>

<?php 
    include_once $base_url."layouts/header.php";
    include_once $base_url."layouts/navbar.php";
    include_once $base_url."includes/product-content.inc.php";
?>

<section class="py-4 text-center container">
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Lists of Product</h1>
        </div>
    </div>
</section>
<div class="py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
                $products = ProductContent::get_all_products();

                foreach ($products as $product) {
                ?>
                    <div class="col mb-3">
                        <div class="card shadow-sm">
                            <?php
                                $img_url = "assets/images/no-image.jpg";
                                if (!empty($product['image'])) {
                                    $img_url = $product['image'];
                                }
                            ?>
                            <div class="bd-placeholder-img card-img-top text-center pt-1 px-1">
                                <!-- <img src="<?=$img_url?>" alt="image"> -->
                                <div class="img" style="background-image: url('<?=$img_url?>');"></div>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><b><?=$product['name']?></b></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <?php
                                        if ($_SESSION['type'] == 'customer') {
                                        ?>
                                            <b>Price</b> $<?=$product['retail_price']?>
                                        <?php
                                        } else {
                                        ?>
                                            <b>Price</b> $<span class="text-decoration-line-through"><?=$product['retail_price']?></span> <?=$product['wholesell_price']?>
                                        <?php
                                        }
                                        ?> 
                                    </small>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-info">Buy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        adjust_product_height();
    });

    $(window).on('resize', function(){
        adjust_product_height();
    });

    function adjust_product_height() {
        var max_height = 0;
        $(".container .row .col .card-text").each(function(){
            if ($(this).height() > max_height) {
                max_height = $(this).height();
            }
        });
        $(".container .row .col .card-text").height(max_height);
    }
</script>
<?php include_once $base_url."layouts/footer.php"; ?>