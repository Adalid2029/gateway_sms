<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Social</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Social</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-3 col-ed-4 col-xl-4 box-col-4">
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="card social-profile">
                        <div class="card-body">
                            <div class="social-img-wrap">
                                <div class="social-img"><img src="<?= base_url() ?>/assets/images/dashboard-5/profile.png" alt="profile"></div>
                                <div class="edit-icon">
                                    <svg>
                                        <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#profile-check"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="social-details">
                                <h5 class="mb-1"><a href="<?= base_url("social-app") ?>">Brooklyn Simmons</a></h5><span class="f-light">@brookly.simmons</span>
                                <ul class="social-follow">
                                    <li>
                                        <h5 class="mb-0">1,908</h5><span class="f-light">Posts</span>
                                    </li>
                                    <li>
                                        <h5 class="mb-0">34.0k</h5><span class="f-light">Followers</span>
                                    </li>
                                    <li>
                                        <h5 class="mb-0">897</h5><span class="f-light">Following</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-6">
                    <div class="card mobile-app-card">
                        <div class="card-header card-no-border pb-0">
                            <h5 class="mb-3"> <span class="f-16 f-light">Have you Tried Our </span>Mobile Application?</h5>
                            <button class="purchase-btn btn btn-primary btn-hover-effect f-w-500" type="button">Try Now</button>
                        </div>
                        <div class="card-body p-0 text-end"><img class="wavy" src="<?= base_url() ?>/assets/images/dashboard-5/wave.png" alt=""><img src="<?= base_url() ?>/assets/images/dashboard-5/mobile-img.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-ed-8 col-xl-8 box-col-8e">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="card social-widget widget-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="social-icons"><img src="<?= base_url() ?>/assets/images/dashboard-5/social/1.png" alt="facebook icon"></div><span>Facebook</span>
                                </div><span class="font-success f-12 d-xxl-block d-xl-none">+22.9%</span>
                            </div>
                            <div class="social-content">
                                <div>
                                    <h5 class="mb-1">12,098</h5><span class="f-light">Followers</span>
                                </div>
                                <div class="social-chart">
                                    <div id="radial-facebook"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="card social-widget widget-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="social-icons"><img src="<?= base_url() ?>/assets/images/dashboard-5/social/2.png" alt="instagram icon"></div><span>Instagram</span>
                                </div><span class="font-success f-12 d-xxl-block d-xl-none">+27.4%</span>
                            </div>
                            <div class="social-content">
                                <div>
                                    <h5 class="mb-1">15,080</h5><span class="f-light">Followers</span>
                                </div>
                                <div class="social-chart">
                                    <div id="radial-instagram"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card social-widget widget-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="social-icons"><img src="<?= base_url() ?>/assets/images/dashboard-5/social/3.png" alt="twitter icon"></div><span>Twitter</span>
                                </div><span class="font-success f-12 d-xxl-block d-xl-none">+14.09%</span>
                            </div>
                            <div class="social-content">
                                <div>
                                    <h5 class="mb-1">12,564</h5><span class="f-light">Followers</span>
                                </div>
                                <div class="social-chart">
                                    <div id="radial-twitter"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Instagram Subscribers<span class="f-14 f-w-500 ms-1 f-light">(75% activity growth)</span></h5>
                                <div class="card-header-right-icon">
                                    <div class="dropdown icon-dropdown">
                                        <button class="btn dropdown-toggle" id="subscribeButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="subscribeButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="subscriber-chart-container">
                                <div id="subscriber-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="card click-widgets widget-hover">
                                <div class="card-body">
                                    <div class="dropdown icon-dropdown text-end">
                                        <button class="btn dropdown-toggle" id="photoButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="photoButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <div class="click-chart">
                                            <div id="photo-click"> </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-0">%76</h4><span class="f-light d-block my-1">Photo Clicks</span><span class="font-success">+72.9%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="card click-widgets widget-hover">
                                <div class="card-body">
                                    <div class="dropdown icon-dropdown text-end">
                                        <button class="btn dropdown-toggle" id="clickButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="clickButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <div class="click-chart">
                                            <div id="link-click"> </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-0">%89</h4><span class="f-light d-block my-1">Link Clicks</span><span class="font-secondary">79.9%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-ed-none d-xxl-block d-lg-none box-col-none">
            <div class="row">
                <div class="col-lg-12 col-sm-6">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top gap-1">
                                <h5>Follower Gender</h5>
                                <div class="dropdown icon-dropdown">
                                    <button class="btn dropdown-toggle" id="followerdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="followerdropdown"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="follower-chart">
                                <div id="followerchart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-6">
                    <div class="card follower-wrap">
                        <div class="card-header card-no-border">
                            <h5 class="mb-1">Facebook Campaign</h5>
                            <div class="d-inline-block badge badge-light-success rounded-pill">Active</div>
                        </div>
                        <div class="card-body pt-0 papernote-wrap">
                            <ul class="campaign-list">
                                <li>
                                    <div class="campaign-box">
                                        <h5 class="mb-1">1,897</h5><span class="f-light">Followers today</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="campaign-box">
                                        <h5 class="mb-1">50,000</h5><span class="f-light">Followers goals</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="customers">
                                <ul>
                                    <li class="d-inline-block"><img class="img-40 rounded-circle" src="<?= base_url() ?>/assets/images/dashboard/user/1.jpg" alt="user"></li>
                                    <li class="d-inline-block"><img class="img-40 rounded-circle" src="<?= base_url() ?>/assets/images/dashboard/user/6.jpg" alt="user"></li>
                                    <li class="d-inline-block"><img class="img-40 rounded-circle" src="<?= base_url() ?>/assets/images/dashboard/user/7.jpg" alt="user"></li>
                                    <li class="d-inline-block"><img class="img-40 rounded-circle" src="<?= base_url() ?>/assets/images/dashboard/user/3.jpg" alt="user"></li>
                                    <li class="d-inline-block"><img class="img-40 rounded-circle" src="<?= base_url() ?>/assets/images/dashboard/user/8.jpg" alt="user"></li>
                                    <li class="d-inline-block">
                                        <div class="light-card"><span class="f-w-500">+5</span></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h5 class="m-0">All Campaigns</h5>
                        <div class="card-header-right-icon">
                            <div class="dropdown icon-dropdown">
                                <button class="btn dropdown-toggle" id="allcampButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="allcampButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0 campaign-table">
                    <div class="recent-table table-responsive currency-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="f-light">AD Platform</th>
                                    <th class="f-light">Campaign</th>
                                    <th class="f-light">GEO</th>
                                    <th class="f-light">Profitability</th>
                                    <th class="f-light">Max Participation Avai.</th>
                                    <th class="f-light">Status</th>
                                    <th class="f-light">Create</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-icon facebook">
                                        <div>
                                            <div class="social-circle"><i class="fa fa-facebook"></i></div>
                                        </div>
                                    </td>
                                    <td>Jane Cooper</td>
                                    <td>UK</td>
                                    <td>
                                        <div class="change-currency"><i class="font-success me-1" data-feather="trending-up"></i>45.6%</div>
                                    </td>
                                    <td>$9,786</td>
                                    <td>
                                        <button class="btn badge-light-primary">Active</button>
                                    </td>
                                    <td>
                                        <button class="plus-btn">+ </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-icon instagram">
                                        <div>
                                            <div class="social-circle"><i class="fa fa-instagram"></i></div>
                                        </div>
                                    </td>
                                    <td>Floyd Miles</td>
                                    <td>DE</td>
                                    <td>
                                        <div class="change-currency"><i class="font-danger me-1" data-feather="trending-down"></i>12.3%</div>
                                    </td>
                                    <td>$19,7098</td>
                                    <td>
                                        <button class="btn badge-light-primary">Active</button>
                                    </td>
                                    <td>
                                        <button class="plus-btn">+ </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-icon pinterest">
                                        <div>
                                            <div class="social-circle"><i class="fa fa-pinterest"></i></div>
                                        </div>
                                    </td>
                                    <td>Guy Hawkins</td>
                                    <td>ES</td>
                                    <td>
                                        <div class="change-currency"><i class="font-success me-1" data-feather="trending-up"></i>65.6%</div>
                                    </td>
                                    <td>$90,986</td>
                                    <td>
                                        <button class="btn badge-light-primary">Active</button>
                                    </td>
                                    <td>
                                        <button class="plus-btn">+ </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-icon twitter">
                                        <div>
                                            <div class="social-circle"><i class="fa fa-twitter"></i></div>
                                        </div>
                                    </td>
                                    <td> Travis Wright</td>
                                    <td>ES</td>
                                    <td>
                                        <div class="change-currency"><i class="font-danger me-1" data-feather="trending-down"></i>35.6%</div>
                                    </td>
                                    <td>$23,654</td>
                                    <td>
                                        <button class="btn badge-light-light disabled">Inactive</button>
                                    </td>
                                    <td>
                                        <button class="plus-btn">+ </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-icon you-tube">
                                        <div>
                                            <div class="social-circle"><i class="fa fa-youtube-play"></i></div>
                                        </div>
                                    </td>
                                    <td>Mark Green</td>
                                    <td>UK</td>
                                    <td>
                                        <div class="change-currency"><i class="font-success me-1" data-feather="trending-up"></i>45.6%</div>
                                    </td>
                                    <td>$12,796</td>
                                    <td>
                                        <button class="btn badge-light-light disabled" type="button">Inactive</button>
                                    </td>
                                    <td>
                                        <button class="plus-btn" type="button">+ </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top">
                        <h5 class="m-0">Views</h5>
                        <div class="card-header-right-icon">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" id="viewButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="viewButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="view-container">
                        <div id="view"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url() ?>/assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="<?= base_url() ?>/assets/js/dashboard/dashboard_5.js"></script>
<?= $this->endSection() ?>