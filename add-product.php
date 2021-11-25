<?php
    session_start();
    // Create a new CSRF token.
    if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
?>

<form id="form-add" method="POST" enctype="multipart/form-data">
    <div class="row px-3 add-product-form">
        <div class="cols">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name<span class="badge bg-danger label-required">Required</span></label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="retail_price" class="form-label">Retail Price<span class="badge bg-danger label-required">Required</span></label>
                <input type="number" class="form-control" id="retail_price" name="retail_price" min="0" pattern="^\d*(\.\d{0,2})?$" step=".01">
            </div>
            <div class="mb-3">
                <label for="wholesale_price" class="form-label">Wholesale Price</label>
                <input type="text" class="form-control" id="wholesale_price" name="wholesale_price" value="0.00" readonly>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status<span class="badge bg-danger label-required">Required</span></label>
                <select class="form-select" name="status" id="status">
                    <option value="">Select Any</option>
                    <option value="published">Published</option>
                    <option value="unpublished">Unpublished</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 text-center">
                        <label for="" class="form-label">Image</label>
                        <img id="frame1" src="assets/images/no-image.jpg" class="form-control product-img mb-2 px-2 y-2">
                        <input type="file" id="image" name="image" class="form-control btn-img hidden" data-frame="frame1" accept="image/*">
                        <label for="image" class="btn btn-sm btn-info text-light"><i class="fa fa-image"></i> Select Image</label>
                        <input type="hidden" class="frame1" name="is_img1_added" value="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 text-center">
                        <label for="" class="form-label">Image (Optional)</label>
                        <img id="frame2" src="assets/images/no-image.jpg" class="form-control product-img mb-2 px-2 y-2">
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
        <button type="submit" class="btn btn-info text-light save-product"><i class="fa fa-save"></i> Save</button>
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
        $(".add-product-form").on('keyup', '#retail_price', function() {
            var value = $(this).val();
            var wholesale_value = 0.00;
            if (value > 0) {
                wholesale_value = value - ((value*10)/100);
            }
            $("#wholesale_price").val(wholesale_value.toFixed(2));
        });

        $(".add-product-form").on('change', '.btn-img', function() {
            var frame = $(this).data("frame");
            document.getElementById(frame).src = URL.createObjectURL(event.target.files[0]);
            $("."+frame).val('1');
        });

        $("#form-add").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: "includes/add-product.inc.php",
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                data:  new FormData(this),
                beforeSend: function() {
                    $(".save-product").attr("disabled", true);
                    $("body .app-loader").removeClass("hidden");
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == "success") {
                        $(".errors ul").html("");
                        $("body .success-alert .text").text(data.message);
                        $("body .success-alert").removeClass("hidden");

                        var dataTable = $('#datatable').DataTable();
                        var counter = dataTable.rows().count() + 1;
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
                        var row = dataTable.row.add( [
                            counter,
                            "<img src='"+img_url+"' class='rounded table-img' alt='img'> "+data.data[0]['name'],
                            "$"+data.data[0]['retail_price'],
                            "$"+data.data[0]['wholesale_price'],
                            "<span class='badge rounded-pill "+badge_clr+"'>"+status+"</span>",
                            moment(data.data[0]['created_at']).format('yyyy-MM-DD hh:mm A'),
                            "<button type='button' class='btn btn-info text-light btn-sm edit-product' data-id='"+data.data[0]['id']+"' data-bs-toggle='modal' data-bs-target='#WholeSaleModal'><i class='fa fa-edit'></i> Edit</button>"
                        ] );
                        dataTable.row(row).nodes().to$().addClass('product_'+data.data[0]['id']);
                        dataTable.row(row).column(0).nodes().to$().addClass('align-middle');
                        dataTable.row(row).column(1).nodes().to$().addClass('align-middle');
                        dataTable.row(row).column(2).nodes().to$().addClass('align-middle text-end');
                        dataTable.row(row).column(3).nodes().to$().addClass('align-middle text-end');
                        dataTable.row(row).column(4).nodes().to$().addClass('align-middle text-center');
                        dataTable.row(row).column(5).nodes().to$().addClass('align-middle text-center');
                        dataTable.row(row).column(6).nodes().to$().addClass('align-middle text-center');
                        dataTable.row(row).draw();
                        
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

                    $(".save-product").attr("disabled", false);
                }
            });
        }));
    });
</script>