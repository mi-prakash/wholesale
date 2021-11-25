<?php 
    $base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location: login.php");
    }
    if($_SESSION['type'] == "customer") {
        header("location: index.php");
    }
    $thisPage = "Order List";
?>

<?php 
    include_once $base_url."layouts/header.php";
    include_once $base_url."layouts/navbar.php";
    include_once $base_url."includes/order-content.inc.php";
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
        <div class="row row-cols g-3">
            <table id="datatable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="table-dark">Order ID</th>
                        <th class="table-dark">Product Name</th>
                        <th class="table-dark">Purchased By</th>
                        <th class="table-dark text-end">Wholesale Price</th>

                        <th class="table-dark text-center">Ordered At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $orders = OrderContent::get_orders();
                        foreach ($orders as $order) {
                            ?>
                            <tr class="order_<?=$order['id']?>">
                                <td class="align-middle"><?=$order['id']?></td>
                                <td class="align-middle">
                                <?php
                                    $image_url = "assets/images/no-image.jpg";
                                    if (!empty($order['image'])) {
                                        $image_url = $order['image'];
                                    }
                                ?>
                                    <img src="<?=$image_url?>" class="rounded table-img" alt="img">
                                    <?=$order['product_name']?>
                                </td>
                                <td class="align-middle"><?=$order['purchased_by']?></td>
                                <td class="align-middle text-end">$<?=$order['wholesale_price']?></td>
                                <td class="align-middle text-center">
                                    <?=date("Y-m-d h:i A", strtotime($order['created_at']))?>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var dataTable = $('#datatable').DataTable();
    });
</script>
<?php include_once $base_url."layouts/footer.php"; ?>