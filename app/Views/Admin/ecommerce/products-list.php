<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/vendors/datatables.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/vendors/owlcarousel.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/vendors/rating.css">
<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Product list</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
              <svg class="stroke-icon">
                <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#stroke-home"></use>
              </svg></a></li>
          <li class="breadcrumb-item">ECommerce</li>
          <li class="breadcrumb-item active">Product list</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <!-- Individual column searching (text inputs) Starts-->
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5>Individual column searching (text inputs) </h5><span>The searching functionality provided by DataTables is useful for quickly search through the information in the table - however the search is global, and you may wish to present controls that search on specific columns.</span>
        </div>
        <div class="card-body">
          <div class="table-responsive product-table">
            <table class="display" id="basic-1">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Details</th>
                  <th>Amount</th>
                  <th>Stock</th>
                  <th>Start date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-1.png" alt=""></td>
                  <td>
                    <h6> Red Shirt</h6><span>Wild West - Red Cotton Blend Regular Fit Men's Formal Shirt.</span>
                  </td>
                  <td>$10</td>
                  <td class="font-success">In Stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-2.png" alt=""></td>
                  <td>
                    <h6> blue Shirt</h6>
                    <p>Vida Loca - Blue Denim Fit Men's Casual Shirt.</p>
                  </td>
                  <td>$10</td>
                  <td class="font-primary">Low Stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-3.png" alt=""></td>
                  <td>
                    <h6>Men Solid Denim Jacket</h6>
                    <p>The Dry State - Blue Denim Regular Fit Men's Denim Jacket.</p>
                  </td>
                  <td>$10</td>
                  <td class="font-danger">out of stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-4.png" alt=""></td>
                  <td>
                    <h6>Cyclamen</h6>
                    <p> Stylish co-ord Set 2 piece dress for women</p>
                  </td>
                  <td>$10</td>
                  <td class="font-primary">Low Stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-5.png" alt=""></td>
                  <td>
                    <h6>Women shorts </h6>
                    <p>Women Shorts Set</p>
                  </td>
                  <td>$10</td>
                  <td class="font-success">In Stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-6.png" alt=""></td>
                  <td>
                    <h6> Women Top</h6>
                    <p>Women's Top</p>
                  </td>
                  <td>$10</td>
                  <td class="font-primary">Low Stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-1.png" alt=""></td>
                  <td>
                    <h6> Red shirt </h6>
                    <p>Wild West - Red Cotton Blend Regular Fit Men's Formal Shirt.</p>
                  </td>
                  <td>$10</td>
                  <td class="font-danger">out of stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-2.png" alt=""></td>
                  <td>
                    <h6> Blue shirt </h6>
                    <p>Vida Loca - Blue Denim Fit Men's Casual Shirt.</p>
                  </td>
                  <td>$10</td>
                  <td class="font-danger">out of stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-3.png" alt=""></td>
                  <td>
                    <h6> Men Solid Denim Jacket</h6>
                    <p>The Dry State - Blue Denim Regular Fit Men's Denim Jacket.</p>
                  </td>
                  <td>$10</td>
                  <td class="font-success">In Stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
                <tr>
                  <td><img src="<?=base_url()?>/assets/images/ecommerce/product-table-4.png" alt=""></td>
                  <td>
                    <h6> Cyclamen</h6>
                    <p>Stylish co-ord Set 2 piece dress for women</p>
                  </td>
                  <td>$10</td>
                  <td class="font-danger">out of stock</td>
                  <td>2011/04/25</td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Delete</button>
                    <button class="btn btn-success btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="">Edit</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Individual column searching (text inputs) Ends-->
  </div>
</div>
<!-- Container-fluid Ends-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url() ?>/assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/js/rating/jquery.barrating.js"></script>
<script src="<?= base_url() ?>/assets/js/rating/rating-script.js"></script>
<script src="<?= base_url() ?>/assets/js/owlcarousel/owl.carousel.js"></script>
<script src="<?= base_url() ?>/assets/js/ecommerce.js"></script>
<script src="<?= base_url() ?>/assets/js/product-list-custom.js"></script>
<script src="<?= base_url() ?>/assets/js/tooltip-init.js"></script>
<?= $this->endSection() ?>