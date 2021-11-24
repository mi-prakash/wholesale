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
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?=$product[0]['name']?>">
            </div>
            <div class="mb-3">
                <label for="retail_price" class="form-label">Retail Price</label>
                <input type="number" class="form-control" id="retail_price" name="retail_price" min="0" pattern="^\d*(\.\d{0,2})?$" value="<?=$product[0]['retail_price']?>">
            </div>
            <div class="mb-3">
                <label for="wholesell_price" class="form-label">Wholesale Price</label>
                <input type="text" class="form-control" id="wholesell_price" name="wholesell_price" value="<?=$product[0]['wholesell_price']?>" readonly>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="status">
                    <option value="">Select Any</option>
                    <option value="published" <?php if($product[0]['status'] == 'published'){echo 'selected';}?>>Published</option>
                    <option value="unpublished" <?php if($product[0]['status'] == 'unpublished'){echo 'selected';}?>>Unpublished</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer mt-3 px-0 pb-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="button" class="btn btn-info text-light update-product"><i class="fa fa-save"></i> Update</button>
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
            $("#wholesell_price").val(wholesale_value.toFixed(2));
        });
    });
</script>