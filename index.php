<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location: login.php");
    }
    $thisPage = "Home";
    // Create a new CSRF token.
    if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
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
                                <a href="#" class="text-info product-link text-decoration-none" data-id="<?=$product['id']?>" data-bs-toggle="modal" data-bs-target="#WholeSaleModal">
                                    <p class="card-text p-name"><b><?=$product['name']?></b></p>
                                </a>
                                <p class="published-by m-0 text-muted">by <span class="text-info p-uname"><?=$product['username']?></span></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-dark p-price">
                                        <?php
                                            if ($_SESSION['type'] == 'customer') {
                                            ?>
                                                <b>Price</b> $<?=$product['retail_price']?>
                                            <?php
                                            } else {
                                            ?>
                                                <b>Price</b> $<span class="text-decoration-line-through"><?=$product['retail_price']?></span> <?=$product['wholesale_price']?>
                                            <?php
                                            }
                                        ?>
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
                <a href="#" class="text-info product-link text-decoration-none" data-id="" data-bs-toggle="modal" data-bs-target="#WholeSaleModal">
                    <p class="card-text p-name"><b>Name</b></p>
                </a>
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

<!-- Modal -->
<div class="modal fade" id="WholeSaleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WholeSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="WholeSaleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        adjust_product_height();
        var prod_html = $(".product-template");

        $("body").on('click', '.load-more', function() {
            var user_type = "<?=$_SESSION['type']?>";
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
                            prod_tmp.find(".product-link").attr("data-id", $(this)[0].id);
                            prod_tmp.find(".p-name").html("<b>"+$(this)[0].name+"</b>");
                            prod_tmp.find(".p-uname").text($(this)[0].username);
                            if (user_type == "seller") {
                                prod_tmp.find(".p-price").html("<b>Price</b> $<span class='text-decoration-line-through'>"+$(this)[0].retail_price+"</span> "+$(this)[0].wholesale_price);
                            } else {
                                prod_tmp.find(".p-price").html("<b>Price</b> $"+$(this)[0].retail_price);
                            }
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

        $("body").on('click', '.product-link', function(e) {
            e.preventDefault();
            var product_id = $(this).data("id");
            $.ajax({
                url: "product-detail.php",
                type: "GET",
                data: {product_id: product_id},
                beforeSend: function() {
                    $("#WholeSaleModal .modal-title").text("Product Detail");
                    $("#WholeSaleModal .modal-body").html("<div class='text-center py-5'><span class='fa fa-refresh fa-3x fa-spin'></span></div>");
                },
                success: function(response) {
                    $("#WholeSaleModal .modal-body").html(response);
                }
            });
        });

        $("body").on('click', '.buy', function() {
            var product_id = $(this).data("id");
            var csrf_token = "<?=$_SESSION['csrf_token']?>";
            $.ajax({
                url: "includes/buy-product.inc.php",
                type: "POST",
                data: {
                    csrf_token: csrf_token,
                    product_id: product_id
                },
                beforeSend: function() {
                    $(this).attr("disabled", true);
                    $(".app-loader").removeClass("hidden");
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    setTimeout(function(){ $(".app-loader").addClass("hidden"); $("#WholeSaleModal .btn-close").click(); }, 1000);

                    if (data.status == "success") {
                        $("body .success-alert .text").text(data.message);
                        $("body .success-alert").removeClass("hidden");
                        setTimeout(function(){ $("body .success-alert").addClass("hidden"); }, 6000);
                    } else if (data.status == "error" || data.status == "csrf_error") {
                        $("body .error-alert .text").text(data.message);
                        $("body .error-alert").removeClass("hidden");
                        setTimeout(function(){ $("body .error-alert").addClass("hidden"); }, 5000);
                    } else {
                        $("body .error-alert .text").text(data.message);
                        $("body .error-alert").removeClass("hidden");
                        setTimeout(function(){ $("body .error-alert").addClass("hidden"); }, 5000);
                    }
                    $(this).attr("disabled", false);
                }
            });
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