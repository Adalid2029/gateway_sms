<?= $this->extend('Admin/layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Pagination</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
          <li class="breadcrumb-item"> Bonus Ui</li>
          <li class="breadcrumb-item active">Pagination</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <!-- simple pagination-->
    <div class="col-xl-6">
      <div class="card">
        <div class="card-header">
          <h5>Pagination</h5>
        </div>
        <div class="card-body">
          <nav aria-label="Page navigation example">
            <ul class="pagination pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- pagination with icons-->
    <div class="col-xl-6">
      <div class="card">
        <div class="card-header">
          <h5>Pagination with icons</h5>
        </div>
        <div class="card-body">
          <nav aria-label="Page navigation example">
            <ul class="pagination pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- pagination alignment left-->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h5>Pagination alignment</h5>
        </div>
        <div class="card-body">
          <!-- left aligned pagination-->
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <!-- center aligned pagination-->
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination justify-content-center pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <!-- right aligned pagination-->
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- pagination with active and disabled state-->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h5>Pagination with active and disabled</h5>
        </div>
        <div class="card-body">
          <nav aria-label="...">
            <ul class="pagination pagination-primary">
              <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" tabindex="-1">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item active"><a class="page-link" href="javascript:void(0)">2 <span class="sr-only">(current)</span></a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- pagination Color-->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h5>Pagination Color</h5>
        </div>
        <div class="card-body">
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination pagination-secondary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination pagination-success">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination pagination-info">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination pagination-warning">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <nav aria-label="Page navigation example">
            <ul class="pagination pagination-danger">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- pagination sizing-->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h5>Pagination sizing</h5>
        </div>
        <div class="card-body">
          <!-- large size pagination-->
          <nav class="m-b-30" aria-label="Page navigation example">
            <ul class="pagination pagination-lg pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
          <!-- small size pagination-->
          <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm pagination-primary">
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Previous</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
              <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>