<?php
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();

    include_once $base_url."includes/product-content.inc.php";

    if (isset($_GET["product_id"])) {
        $product_id = $_GET["product_id"];
    } else {
        return false;
    }

    $product = ProductContent::get_product_detail_by_id($product_id);
    $product = $product[0];
?>

<div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-inner" style=" width:auto; max-height: 400px !important;">
        <div class="carousel-item text-center active">
            <?php
                $image_url = "assets/images/no-image.jpg";
                if(!empty($product["image"])) {
                    $image_url = $product["image"];
                }
            ?>
            <img src="<?=$image_url?>" class="d-block" alt="img">
        </div>
        <?php
            if(!empty($product["image_2"])) {
            ?>
                <div class="carousel-item text-center">
                    <img src="<?=$product["image_2"]?>" class="d-block" alt="img">
                </div>
            <?php
            }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<h5 class="mt-4 mb-4"><?=$product['name']?></h5>
<div class="clearfix">
    <p class="mb-2">Posted by <span class="text-info"><?=$product['username']?></span></p>
    <p class="mb-2"><b>Price</b> $<?=$product['retail_price']?></p>
    <div class="text-center">
        <?php
            $disabled = "";
            if ($_SESSION['id'] == $product['publish_by']) {
                $disabled = "disabled";
            }
        ?>
        <button type="button" class="btn btn-sm btn-info text-light buy <?=$disabled?>" data-id="<?=$product['id']?>" style="width: 100%"><i class="fa fa-shopping-bag"></i> Buy</button>
    </div>
</div>

