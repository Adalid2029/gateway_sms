<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/vendors/rating.css">

<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Rating</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Bonus Ui</li>
                    <li class="breadcrumb-item active">Rating</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><span>1/10</span> Rating</h5>
                </div>
                <div class="card-body">
                    <div class="rating-container">
                        <select id="u-rating-1to10" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7" selected="selected">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Movie Rating</h5>
                </div>
                <div class="card-body">
                    <div class="rating-container">
                        <select id="u-rating-movie" name="rating" autocomplete="off">
                            <option value="Bad">Bad</option>
                            <option value="Mediocre">Mediocre</option>
                            <option value="Good" selected="selected">Good</option>
                            <option value="Awesome">Awesome</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Square Rating</h5>
                </div>
                <div class="card-body">
                    <div class="rating-container">
                        <select id="u-rating-square" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Pill Rating</h5>
                </div>
                <div class="card-body">
                    <div class="rating-container">
                        <select id="u-rating-pill" name="rating" autocomplete="off">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Reversed Rating</h5>
                </div>
                <div class="card-body">
                    <div class="rating-container">
                        <select id="u-rating-reversed" name="rating" autocomplete="off">
                            <option value="Strongly Agree">Strongly Agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Neither Agree or Disagree" selected="selected">Neither Agree or Disagree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly Disagree">Strongly Disagree</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Star Rating</h5>
                </div>
                <div class="card-body">
                    <div class="rating-container">
                        <select id="u-rating-fontawesome" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Horizontal Rating</h5>
                </div>
                <div class="card-body height-equal">
                    <div class="rating-container">
                        <select id="u-rating-horizontal" name="rating" autocomplete="off">
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1" selected="selected">1</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card height-equal">
                <div class="card-header">
                    <h5>Star Rating</h5>
                </div>
                <div class="card-body height-equal">
                    <div class="rating-container">
                        <div class="star-ratings">
                            <div class="stars stars-example-fontawesome-o">
                                <select id="u-rating-fontawesome-o" name="rating" data-current-rating="5.6" autocomplete="off">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select><span class="title current-rating">Current rating: <span class="value"></span></span><span class="title your-rating hidden">Your rating: <span class="value"></span><a class="clear-rating" href="#"><i class="fa fa-times-circle"></i></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/rating/jquery.barrating.js"></script>
<script src="<?=base_url()?>/assets/js/rating/rating-script.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>


<?= $this->endSection() ?>