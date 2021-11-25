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
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4 home-products">
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
                                <div class="img" style="background-image: url('<?=$img_url?>')"></div>
                            </div>
                            <div class="card-body">
                                <p class="card-text p-name"><b><?=$product['name']?></b></p>
                                <p class="published-by m-0 text-muted">by <span class="text-info p-uname"><?=$product['username']?></span></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-dark p-price">
                                        <b>Price</b> $<?=$product['retail_price']?>
                                    </small>
                                    <div class="btn-group">
                                        <?php
                                            $disabled = "";
                                            if ($_SESSION['id'] == $product['publish_by']) {
                                                $disabled = "disabled";
                                            }
                                        ?>
                                        <button type="button" class="btn btn-sm btn-info text-light buy <?=$disabled?>" data-id="<?=$product['id']?>"><i class="fa fa-shopping-bag"></i> Buy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>
        </div>
        <div class="row">
            <div class="col text-center pt-4">
                <button type="button" class="btn btn-info text-light load-more"><i class="fa fa-redo"></i> Load More</button>
                <input type="hidden" id="offset" value="8">
            </div>
        </div>
    </div>
</div>

<!-- Product template -->
<div class="product-template hidden">
    <div class="col mb-3">
        <div class="card shadow-sm">
            <div class="bd-placeholder-img card-img-top text-center pt-1 px-1">
                <div class="img" style="background-image: url('assets/images/no-image.jpg')"></div>
            </div>
            <div class="card-body">
                <p class="card-text p-name"><b>Name</b></p>
                <p class="published-by m-0 text-muted">by <span class="text-info p-uname">User Name</span></p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-dark p-price">
                        <b>Price</b> $00.0
                    </small>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info text-light buy" data-id=""><i class="fa fa-shopping-bag"></i> Buy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        adjust_product_height();
        var prod_html = $(".product-template");

        $("body").on('click', '.load-more', function() {
            var session_id = "<?=$_SESSION['id']?>";
            var offset = parseInt($("#offset").val());
            var prod_tmp = prod_html;
            $.ajax({
                url: "includes/get-offset-product.php",
                type: "GET",
                data: {offset: offset},
                beforeSend: function() {
                    $(".load-more").attr("disabled", true);
                    $(".load-more svg").addClass("fa-spin");
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.length === 0) {
                        $(".load-more").attr("disabled", false);
                        $(".load-more svg").removeClass("fa-spin");
                    } else {
                        $(data).each(function() {
                            if ($(this)[0].image !== null) {
                                var image_url = $(this)[0].image;
                            } else {
                                var image_url = "assets/images/no-image.jpg";
                            }
                            prod_tmp.find(".img").attr("style", "background-image: url('"+image_url+"')");
                            prod_tmp.find(".p-name").html("<b>"+$(this)[0].name+"</b>");
                            prod_tmp.find(".p-uname").text($(this)[0].username);
                            prod_tmp.find(".p-price").html("<b>Price</b> $"+$(this)[0].retail_price);
                            prod_tmp.find(".buy").attr("data-id", $(this)[0].id);
                            if (session_id == $(this)[0].publish_by) {
                                prod_tmp.find(".buy").addClass("disabled");
                            }
                            $(".home-products").append(prod_tmp.html());
                        });

                        $("#offset").val(offset + 8);
                        $(".load-more").attr("disabled", false);
                        $(".load-more svg").removeClass("fa-spin");
                    }
                }
            });
        });

        $("body").on('click', '.buy', function() {
            console.log('clicked');
        });
    });

    $(window).on('resize', function(){
        adjust_product_height();
    });

    function adjust_product_height() {
        var max_height = 0;
        var max_btn_height = 0;
        $(".container .row .col .card-text").each(function(){
            if ($(this).height() > max_height) {
                max_height = $(this).height();
            }
        });
        $(".container .row .col .card-text").height(max_height);
        $(".container .row .col .align-items-center").each(function(){
            if ($(this).height() > max_btn_height) {
                max_btn_height = $(this).height();
            }
        });
        $(".container .row .col .align-items-center").height(max_btn_height);
    }
</script>
<?php include_once $base_url."layouts/footer.php"; ?>