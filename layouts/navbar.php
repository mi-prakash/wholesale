<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap" />
                </svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 me-4 <?php if($thisPage == 'Home') { ?>link-info<?php } else { ?>link-light<?php } ?>"><i class="fa fa-home"></i> Home</a></li>
                <?php
                    if($_SESSION['type'] == "seller") {
                    ?>
                    <li><a href="product-list.php" class="nav-link px-2 me-4 <?php if($thisPage == 'Product List') { ?>link-info<?php } else { ?>link-light<?php } ?>"><i class="fa fa-th-list"></i> Product List</a></li>
                    <li><a href="order-list.php" class="nav-link px-2 me-4 <?php if($thisPage == 'Order List') { ?>link-info<?php } else { ?>link-light<?php } ?>"><i class="fa fa-list-ul"></i> Order List</a></li>
                    <?php
                    }
                ?>
                <li><a href="my-order-list.php" class="nav-link px-2 me-4 <?php if($thisPage == 'My Order List') { ?>link-info<?php } else { ?>link-light<?php } ?>"><i class="fa fa-clipboard-list"></i> My Order List</a></li>
            </ul>

            <?php
                if (!isset($_SESSION['id'])) {
                ?>
                    <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                        <a href="login.php" class="btn btn-outline-light me-2">Login</a>
                        <a href="signup.php" class="btn btn-warning">Sign-up</a>
                    </div>
                <?php
                } else {
                ?>
                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user-circle" style="font-size: 1.6em"></i> <span class="nav-user-name"><?=$_SESSION['name']?> <small class="text-info">(<?=ucfirst($_SESSION['type'])?>)</small></span>
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="includes/logout.inc.php"><i class="fa fa-sign-out-alt"></i> Sign out</a></li>
                        </ul>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
</header>