<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/vendors/datatables.css">
<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Wishlist</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
              <svg class="stroke-icon">
                <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#stroke-home"></use>
              </svg></a></li>
          <li class="breadcrumb-item">Ecommerce</li>
          <li class="breadcrumb-item active">Wishlist</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5>Wishlist</h5>
        </div>
        <div class="card-body">
          <div class="row g-sm-4 g-3">
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-6.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Women Top</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-5.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Womem shorts</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-4.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Cyclamen </a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-3.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Men Solid Denim Jacket</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-2.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Blue shirt</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-1.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Red shirt</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-1.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Red Shirt</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-6.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Women Top</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-5.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Women shorts</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-4.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Cyclamen</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-3.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Men Solid Denim Jacket</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-3.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Men Solid Denim Jacket</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-2.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Blue shirt</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-6.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Women Top</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="prooduct-details-box">
                <div class="media"><img class="align-self-center img-fluid img-60" src="<?=base_url()?>/assets/images/ecommerce/product-table-5.png" alt="#">
                  <div class="media-body ms-3">
                    <div class="product-name">
                      <h6><a href="#">Women Short</a></h6>
                    </div>
                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div class="price d-flex">
                      <div class="text-muted me-2">Price</div>: 210$
                    </div>
                    <div class="avaiabilty">
                      <div class="text-success">In stock</div>
                    </div><a class="btn btn-primary btn-xs" href="#">Move to Cart </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url() ?>/assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/js/datatable/datatables/datatable.custom.js"></script>
<script src="<?= base_url() ?>/assets/js/tooltip-init.js"></script>
<?= $this->endSection() ?>