<?php
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    // Create a new CSRF token.
    if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));

    include_once $base_url."includes/product-content.inc.php";

    if (isset($_GET["product_id"])) {
        $product_id = $_GET["product_id"];
    } else {
        return false;
    }

    $product = ProductContent::get_product_by_id($product_id);
?>

<form id="form-edit" method="POST" enctype="multipart/form-data">
    <div class="row px-3 edit-product-form">
        <div class="cols">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="id" value="<?=$product[0]['id']?>">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name<span class="badge bg-danger label-required">Required</span></label>
                <input type="text" class="form-control" id="name" name="name" value="<?=$product[0]['name']?>">
            </div>
            <div class="mb-3">
                <label for="retail_price" class="form-label">Retail Price<span class="badge bg-danger label-required">Required</span></label>
                <input type="number" class="form-control" id="retail_price" name="retail_price" min="0" pattern="^\d*(\.\d{0,2})?$" step=".01" value="<?=$product[0]['retail_price']?>">
            </div>
            <div class="mb-3">
                <label for="wholesale_price" class="form-label">Wholesale Price</label>
                <input type="text" class="form-control" id="wholesale_price" name="wholesale_price" value="<?=$product[0]['wholesale_price']?>" readonly>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status<span class="badge bg-danger label-required">Required</span></label>
                <select class="form-select" name="status" id="status">
                    <option value="">Select Any</option>
                    <option value="published" <?php if($product[0]['status'] == 'published'){echo 'selected';}?>>Published</option>
                    <option value="unpublished" <?php if($product[0]['status'] == 'unpublished'){echo 'selected';}?>>Unpublished</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 text-center">
                        <label for="" class="form-label">Image</label>
                        <?php
                            $img_url = "assets/images/no-image.jpg";
                            if (!empty($product[0]['image'])) {
                                $img_url = $product[0]['image'];
                            }
                        ?>
                        <img id="frame1" src="<?=$img_url?>" class="form-control product-img mb-2 px-2 y-2">
                        <input type="file" id="image" name="image" class="form-control btn-img hidden" data-frame="frame1" accept="image/*">
                        <label for="image" class="btn btn-sm btn-info text-light"><i class="fa fa-image"></i> Select Image</label>
                        <input type="hidden" class="frame1" name="is_img1_added" value="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 text-center">
                        <label for="" class="form-label">Image (Optional)</label>
                        <?php
                            $img_url = "assets/images/no-image.jpg";
                            if (!empty($product[0]['image_2'])) {
                                $img_url = $product[0]['image_2'];
                            }
                        ?>
                        <img id="frame2" src="<?=$img_url?>" class="form-control product-img mb-2 px-2 y-2">
                        <input type="file" id="image_2" name="image_2" class="form-control btn-img hidden" data-frame="frame2" accept="image/*">
                        <label for="image_2" class="btn btn-sm btn-info text-light"><i class="fa fa-image"></i> Select Image</label>
                        <input type="hidden" class="frame2" name="is_img2_added" value="0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="errors text-danger">
        <ul></ul>
    </div>
    <div class="modal-footer mt-3 px-0 pb-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-info text-light update-product"><i class="fa fa-save"></i> Update</button>
    </div>
</form>
    

<script>
    $(document).on('keydown', 'input[pattern]', function(e) {
        var input = $(this);
        var oldVal = input.val();
        var regex = new RegExp(input.attr('pattern'), 'g');

        setTimeout(function() {
            var newVal = input.val();
            if (!regex.test(newVal)) {
                input.val(oldVal);
            }
        }, 1);
    });

    $(document).ready(function() {
        $(".edit-product-form").on('keyup', '#retail_price', function() {
            var value = $(this).val();
            var wholesale_value = 0.00;
            if (value > 0) {
                wholesale_value = value - ((value*10)/100);
            }
            $("#wholesale_price").val(wholesale_value.toFixed(2));
        });

        $(".edit-product-form").on('change', '.btn-img', function() {
            var frame = $(this).data("frame");
            document.getElementById(frame).src = URL.createObjectURL(event.target.files[0]);
            $("."+frame).val('1');
        });

        $("#form-edit").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: "includes/edit-product.inc.php",
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                data:  new FormData(this),
                beforeSend: function() {
                    $(".update-product").attr("disabled", true);
                    $("body .app-loader").removeClass("hidden");
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == "success") {
                        $(".errors ul").html("");
                        $("body .success-alert .text").text(data.message);
                        $("body .success-alert").removeClass("hidden");

                        var img_url = "assets/images/no-image.jpg";
                        var badge_clr = "bg-danger";
                        var status = "Unpublished";
                        if (data.data[0]['image'] !== null) {
                            img_url = data.data[0]['image'];
                        }
                        if (data.data[0]['status'] == 'published') {
                            badge_clr = "bg-info";
                            status = "Published";
                        }
                        $(".product_"+data.data[0]['id']+" td:nth-child(2)").html("<img src='"+img_url+"' class='rounded table-img' alt='img'> "+data.data[0]['name']);
                        $(".product_"+data.data[0]['id']+" td:nth-child(3)").text(data.data[0]['retail_price']);
                        $(".product_"+data.data[0]['id']+" td:nth-child(4)").text(data.data[0]['wholesale_price']);
                        $(".product_"+data.data[0]['id']+" td:nth-child(5)").html("<span class='badge rounded-pill "+badge_clr+"'>"+status+"</span>");
                        
                        setTimeout(function(){ $("body .success-alert").addClass("hidden"); }, 5000);
                        setTimeout(function(){ $(".app-loader").addClass("hidden"); $("#WholeSaleModal .btn-close").click(); }, 1500);

                    } else if (data.status == "error" || data.status == "csrf_error") {
                        $(".errors ul").html("<li>"+data.message+"</li>");
                        $("body .error-alert .text").text(data.message);
                        $("body .error-alert").removeClass("hidden");
                        setTimeout(function(){ $("body .error-alert").addClass("hidden"); }, 5000);
                        setTimeout(function(){ $(".app-loader").addClass("hidden"); }, 1500);
                    } else {
                        $(".errors ul").html("<li>"+data.message+"</li>");
                        $("body .error-alert .text").text(data.message);
                        $("body .error-alert").removeClass("hidden");
                        setTimeout(function(){ $("body .error-alert").addClass("hidden"); }, 5000);
                        setTimeout(function(){ $(".app-loader").addClass("hidden"); }, 1500);
                    }

                    $(".update-product").attr("disabled", false);

                    // location.reload();
                }
            });
        }));
    });
</script>