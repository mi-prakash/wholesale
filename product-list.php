<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location: login.php");
    }
    if($_SESSION['type'] == "customer") {
        header("location: index.php");
    }
    $thisPage = "Product List";
?>

<?php 
    include_once $base_url."layouts/header.php";
    include_once $base_url."layouts/navbar.php";
    include_once $base_url."includes/product-content.inc.php";
?>

<section class="py-4 text-center container">
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light"><?= $thisPage ?></h1>
        </div>
    </div>
</section>
<div class="py-5 bg-light">
    <div class="container">
        <button class="btn btn-info text-white mb-3 add-new" data-bs-toggle="modal" data-bs-target="#WholeSaleModal"><i class="fa fa-plus"></i> Add New</button>
        <div class="row row-cols g-3">
            <table id="datatable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="table-dark">#</th>
                        <th class="table-dark">Product Name</th>
                        <th class="table-dark text-end">Retail Price</th>
                        <th class="table-dark text-end">Wholesale Price</th>
                        <th class="table-dark text-center">Status</th>
                        <th class="table-dark text-center">Created At</th>
                        <th class="table-dark text-center" data-orderable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $products = ProductContent::get_products();
                        $x = 1;
                        foreach ($products as $product) {
                            ?>
                            <tr class="product_<?=$product['id']?>">
                                <td class="align-middle"><?=$x?></td>
                                <td class="align-middle">
                                <?php
                                    $image_url = "assets/images/no-image.jpg";
                                    if (!empty($product['image'])) {
                                        $image_url = $product['image'];
                                    }
                                ?>
                                    <img src="<?=$image_url?>" class="rounded table-img" alt="img">
                                    <?=$product['name']?>
                                </td>
                                <td class="align-middle text-end"><?=$product['retail_price']?></td>
                                <td class="align-middle text-end"><?=$product['wholesale_price']?></td>
                                <td class="align-middle text-center">
                                <?php
                                    if($product['status'] == "published") {
                                    ?>
                                        <span class="badge rounded-pill bg-info">Published</span>
                                    <?php
                                    } else {
                                    ?>
                                        <span class="badge rounded-pill bg-danger">Unpublished</span>
                                    <?php
                                    }
                                ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?=date("Y-m-d h:i A", strtotime($product['created_at']))?>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-info text-light btn-sm edit-product" data-id="<?=$product['id']?>" data-bs-toggle="modal" data-bs-target="#WholeSaleModal"><i class="fa fa-edit"></i> Edit</button>
                                </td>
                            </tr>
                            <?php
                            $x++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="WholeSaleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WholeSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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
        var dataTable = $('#datatable').DataTable();

        $("body").on('click', '.add-new', function() {
            $.ajax({
                url: "add-product.php",
                type: "GET",
                data: {},
                beforeSend: function() {
                    $("#WholeSaleModal .modal-title").text("Add Product");
                    $("#WholeSaleModal .modal-body").html("<div class='text-center py-5'><span class='fa fa-refresh fa-3x fa-spin'></span></div>");
                },
                success: function(response) {
                    $("#WholeSaleModal .modal-body").html(response);
                }
            });
        });

        $("body").on('click', '.edit-product', function() {
            var product_id = $(this).data("id");
            $.ajax({
                url: "edit-product.php",
                type: "GET",
                data: {product_id: product_id},
                beforeSend: function() {
                    $("#WholeSaleModal .modal-title").text("Edit Product");
                    $("#WholeSaleModal .modal-body").html("<div class='text-center py-5'><span class='fa fa-refresh fa-3x fa-spin'></span></div>");
                },
                success: function(response) {
                    $("#WholeSaleModal .modal-body").html(response);
                }
            });
        });
    });
</script>
<?php include_once $base_url."layouts/footer.php"; ?>