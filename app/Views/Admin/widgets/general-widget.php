<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/vendors/date-picker.css">                
<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3>General</h3>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a <?=base_url("/")?>>                                       
                        <svg class="stroke-icon">
                          <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Widgets</li>
                    <li class="breadcrumb-item active">General</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-4 col-xxl-2"> 
                <div class="currency-widget warning height-equal widget-currency">
                  <div class="d-flex">
                    <div class="currency-icon-widget"> 
                      <svg>
                        <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#beta"></use>
                      </svg>
                    </div>
                    <div> 
                      <h6>Bitcoin <span class="f-light">BTC</span></h6>
                    </div>
                  </div>
                  <div class="card"> 
                    <div class="card-body d-flex">
                      <div class="currency-chart-wrap">
                        <div id="currency-chart"> </div>
                      </div>
                      <div class="bg-light-warning text-center"> 
                        <h5 class="mb-sm-0">$21,43</h5><span class="f-12 f-w-500 font-warning"><i class="me-1" data-feather="trending-up"></i>+50%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-xxl-2"> 
                <div class="currency-widget primary height-equal widget-currency">
                  <div class="d-flex">
                    <div class="currency-icon-widget"> 
                      <svg>
                        <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#eth"></use>
                      </svg>
                    </div>
                    <div> 
                      <h6>Ethereum <span class="f-light">ETC</span></h6>
                    </div>
                  </div>
                  <div class="card"> 
                    <div class="card-body d-flex">
                      <div class="currency-chart-wrap">
                        <div id="currency-chart2"></div>
                      </div>
                      <div class="bg-light-primary text-center"> 
                        <h5 class="mb-0">$7,450</h5><span class="f-12 f-w-500 font-primary"><i class="me-1" data-feather="trending-up"> </i>+35%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-xxl-2"> 
                <div class="currency-widget success height-equal widget-currency">
                  <div class="d-flex">
                    <div class="currency-icon-widget"> 
                      <svg>
                        <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#ltc"></use>
                      </svg>
                    </div>
                    <div> 
                      <h6>Leave Travel <span class="f-light">LTC</span></h6>
                    </div>
                  </div>
                  <div class="card"> 
                    <div class="card-body d-flex">
                      <div class="currency-chart-wrap">
                        <div id="currency-chart3"></div>
                      </div>
                      <div class="bg-light-success text-center"> 
                        <h5 class="mb-0">$2,198</h5><span class="f-12 f-w-500 font-success"><i class="me-1" data-feather="trending-up"> </i>+73%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-sm-6"> 
                <div class="card height-equal radial-height">
                  <div class="card-body radial-progress-card"> 
                    <div> 
                      <h6 class="mb-0">Average Sales Per Day</h6>
                      <div class="sale-details"> 
                        <h5 class="font-primary mb-0">45,908</h5><span class="f-12 f-light f-w-500"><i data-feather="arrow-up"></i>+5.7%</span>
                      </div>
                      <p class="f-light"> The point of using Lorem Ipsum</p>
                    </div>
                    <div class="radial-chart-wrap"> 
                      <div id="radial-chart"> </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-sm-6"> 
                <div class="card height-equal radial-height">
                  <div class="card-body radial-progress-card"> 
                    <div> 
                      <h6 class="mb-0">Average Profit Per Day</h6>
                      <div class="sale-details"> 
                        <h5 class="font-primary mb-0">89.6%</h5><span class="f-12 f-light f-w-500"><i data-feather="arrow-up"></i>+2.7%</span>
                      </div>
                      <p class="f-light"> The point of using Lorem Ipsum</p>
                    </div>
                    <div class="radial-chart-wrap"> 
                      <div id="radial-chart1"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
                <div class="card widget-1">
                  <div class="card-body"> 
                    <div class="widget-content">
                      <div class="widget-round secondary">
                        <div class="bg-round">
                          <svg class="svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#cart"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#halfcircle"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>10,000</h4><span class="f-light">Purchase</span>
                      </div>
                    </div>
                    <div class="font-secondary f-w-500"><i class="icon-arrow-up icon-rotate me-1"></i><span>+50%</span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
                <div class="card widget-1">
                  <div class="card-body"> 
                    <div class="widget-content">
                      <div class="widget-round primary">
                        <div class="bg-round">
                          <svg class="svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#tag"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#halfcircle"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>4,200</h4><span class="f-light">Sales</span>
                      </div>
                    </div>
                    <div class="font-primary f-w-500"><i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
                <div class="card widget-1">
                  <div class="card-body"> 
                    <div class="widget-content">
                      <div class="widget-round warning">
                        <div class="bg-round">
                          <svg class="svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#return-box"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#halfcircle"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>7000</h4><span class="f-light">Sales return</span>
                      </div>
                    </div>
                    <div class="font-warning f-w-500"><i class="icon-arrow-down icon-rotate me-1"></i><span>-20%</span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
                <div class="card widget-1">
                  <div class="card-body"> 
                    <div class="widget-content">
                      <div class="widget-round success">
                        <div class="bg-round">
                          <svg class="svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#rate"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#halfcircle"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>5700</h4><span class="f-light">Purchase rate</span>
                      </div>
                    </div>
                    <div class="font-success f-w-500"><i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-4 col-md-6 box-col-6">
                <div class="row"> 
                  <div class="col-sm-12">
                    <div class="card course-box widget-course">
                      <div class="card-body"> 
                        <div class="course-widget"> 
                          <div class="course-icon"> 
                            <svg class="fill-icon">
                              <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#course-1"></use>
                            </svg>
                          </div>
                          <div> 
                            <h4 class="mb-0">100+</h4><span class="f-light">Completed Courses</span><a class="btn btn-light f-light" href="<?=base_url("learning/learning-list-view")?>">View course<span class="ms-2"> 
                                <svg class="fill-icon f-light">
                                  <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#arrowright"></use>
                                </svg></span></a>
                          </div>
                        </div>
                      </div>
                      <ul class="square-group">
                        <li class="square-1 warning"></li>
                        <li class="square-1 primary"></li>
                        <li class="square-2 warning1"></li>
                        <li class="square-3 danger"></li>
                        <li class="square-4 light"></li>
                        <li class="square-5 warning"></li>
                        <li class="square-6 success"></li>
                        <li class="square-7 success"></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="card course-box widget-course"> 
                      <div class="card-body"> 
                        <div class="course-widget"> 
                          <div class="course-icon warning"> 
                            <svg class="fill-icon">
                              <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#course-2"></use>
                            </svg>
                          </div>
                          <div> 
                            <h4 class="mb-0">50+</h4><span class="f-light">In Progress Courses</span><a class="btn btn-light f-light" href="<?=base_url("learning/learning-list-view")?>">View course<span class="ms-2"> 
                                <svg class="fill-icon f-light">
                                  <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#arrowright"></use>
                                </svg></span></a>
                          </div>
                        </div>
                      </div>
                      <ul class="square-group">
                        <li class="square-1 warning"></li>
                        <li class="square-1 primary"></li>
                        <li class="square-2 warning1"></li>
                        <li class="square-3 danger"></li>
                        <li class="square-4 light"></li>
                        <li class="square-5 warning"></li>
                        <li class="square-6 success"></li>
                        <li class="square-7 success"></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-4 col-xl-5 col-md-6 box-col-6">
                <div class="row"> 
                  <div class="col-xl-12"> 
                    <div class="card">
                      <div class="card-header card-no-border pb-0">
                        <div class="header-top">
                          <h5>Total Users</h5>
                          <div class="dropdown icon-dropdown">
                            <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body py-lg-3">
                        <ul class="user-list">
                          <li> 
                            <div class="user-icon primary">
                              <div class="user-box"><i class="font-primary" data-feather="user-plus"></i></div>
                            </div>
                            <div> 
                              <h5 class="mb-1">178,098</h5><span class="font-primary d-flex align-items-center"><i class="icon-arrow-up icon-rotate me-1"> </i><span class="f-w-500">+30.89</span></span>
                            </div>
                          </li>
                          <li> 
                            <div class="user-icon success">
                              <div class="user-box"><i class="font-success" data-feather="user-minus"></i></div>
                            </div>
                            <div> 
                              <h5 class="mb-1">178,098</h5><span class="font-danger d-flex align-items-center"><i class="icon-arrow-down icon-rotate me-1"></i><span class="f-w-500">-08.89</span></span>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12"> 
                    <div class="card growth-wrap">
                      <div class="card-header card-no-border pb-0">
                        <div class="header-top">
                          <h5>Followers Growth</h5>
                          <div class="dropdown icon-dropdown">
                            <button class="btn dropdown-toggle" id="growthdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthdropdown"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="growth-wrapper">
                          <div id="growthchart"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-5 col-xl-3 col-md-12 box-col-12">
                <div class="card visitor-card"> 
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h5 class="m-0">Visitors<span class="f-14 font-primary f-w-500 ms-1">
                          <svg class="svg-fill me-1">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#user-visitor"></use>
                          </svg>(+2.8)</span></h5>
                      <div class="card-header-right-icon">
                        <div class="dropdown icon-dropdown">
                          <button class="btn dropdown-toggle" id="visitorButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="visitorButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body pt-3">
                    <div class="visitors-container">
                      <div id="visitor-chart"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6"> 
                <div class="card social-widget">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-2">
                        <div class="social-icons"><img src="<?=base_url()?>/assets/images/dashboard-5/social/1.png" alt="facebook icon"></div><span>Facebook</span>
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
              <div class="col-xl-3 col-sm-6"> 
                <div class="card social-widget">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-2">
                        <div class="social-icons"><img src="<?=base_url()?>/assets/images/dashboard-5/social/3.png" alt="twitter icon"></div><span>Twitter</span>
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
              <div class="col-xl-3 col-sm-6"> 
                <div class="card social-widget">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-2">
                        <div class="social-icons"><img src="<?=base_url()?>/assets/images/dashboard-5/social/2.png" alt="instagram icon"></div><span>Instagram</span>
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
              <div class="col-xl-3 col-sm-6"> 
                <div class="card social-widget">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-2">
                        <div class="social-icons"><img src="<?=base_url()?>/assets/images/dashboard-5/social/4.png" alt="you tube icon"></div><span>Youtube</span>
                      </div><span class="font-success f-12 d-xxl-block d-xl-none">+22.9%</span>
                    </div>
                    <div class="social-content">
                      <div> 
                        <h5 class="mb-1">68,954</h5><span class="f-light">Followers</span>
                      </div>
                      <div class="social-chart">
                        <div id="radial-youtube"> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-5 col-xl-8 box-col-12">
                <div class="row g-sm-3 height-equal-2 widget-charts">
                  <div class="col-sm-6"> 
                    <div class="card small-widget mb-sm-0">
                      <div class="card-body primary"> <span class="f-light">New Orders</span>
                        <div class="d-flex align-items-end gap-1">
                          <h4>2,435</h4><span class="font-primary f-12 f-w-500"><i class="icon-arrow-up"></i><span>+50%</span></span>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#new-order"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6"> 
                    <div class="card small-widget mb-sm-0"> 
                      <div class="card-body warning"><span class="f-light">New Customers</span>
                        <div class="d-flex align-items-end gap-1">
                          <h4>2,908</h4><span class="font-warning f-12 f-w-500"><i class="icon-arrow-up"></i><span>+20%</span></span>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#customers"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6"> 
                    <div class="card small-widget mb-sm-0"> 
                      <div class="card-body secondary"><span class="f-light">Average Sale</span>
                        <div class="d-flex align-items-end gap-1">
                          <h4>$389k</h4><span class="font-secondary f-12 f-w-500"><i class="icon-arrow-down"></i><span>-10%</span></span>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#sale"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6"> 
                    <div class="card small-widget mb-sm-0"> 
                      <div class="card-body success"><span class="f-light">Gross Profit</span>
                        <div class="d-flex align-items-end gap-1">
                          <h4>$3,908</h4><span class="font-success f-12 f-w-500"><i class="icon-arrow-up"></i><span>+80%</span></span>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#profit"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6"> 
                    <div class="card widget-1 widget-with-chart mb-xl-0">
                      <div class="card-body"> 
                        <div> 
                          <h4 class="mb-1">1,80k</h4><span class="f-light">Orders</span>
                        </div>
                        <div class="order-chart"> 
                          <div id="orderchart"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6"> 
                    <div class="card widget-1 widget-with-chart mb-xl-0">
                      <div class="card-body"> 
                        <div> 
                          <h4 class="mb-1">6,90k</h4><span class="f-light">Profit</span>
                        </div>
                        <div class="profit-chart"> 
                          <div id="profitchart"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-4 col-sm-6 box-col-6"> 
                <div class="card balance-box height-equal-2">
                  <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="balance-profile">
                      <div class="balance-img"><img src="<?=base_url()?>/assets/images/dashboard-4/user.png" alt="user vector"><a class="edit-icon" href="<?=base_url("user/user-profile")?>">
                          <svg>
                            <use href="<?=base_url()?>/assets/svg/icon-sprite.svg#pencil"></use>
                          </svg></a></div><span class="f-light d-block">Your Balance </span>
                      <h5 class="mt-1">$768,987.90</h5>
                      <ul> 
                        <li>
                          <div class="balance-item danger"> 
                            <div class="balance-icon-wrap"> 
                              <div class="balance-icon"><i data-feather="arrow-down-right"></i></div>
                            </div>
                            <div> <span class="f-12 f-light">Investment  </span>
                              <h5>78.8K</h5><span class="badge badge-light-danger rounded-pill">-11.67%</span>
                            </div>
                          </div>
                        </li>
                        <li>
                          <div class="balance-item success">
                            <div class="balance-icon-wrap"> 
                              <div class="balance-icon"><i data-feather="arrow-up-right"></i></div>
                            </div>
                            <div> <span class="f-12 f-light">Cash Back</span>
                              <h5>19.7K</h5><span class="badge badge-light-success rounded-pill">+10.67%</span>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 d-xxl-block d-xl-none col-sm-6 box-col-6">  
                <div class="card height-equal-2"> 
                  <div class="card-body">
                    <div class="default-datepicker">
                      <div class="datepicker-here" data-language="en"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
    <script src="<?= base_url() ?>/assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="<?= base_url() ?>/assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="<?= base_url() ?>/assets/js/datepicker/date-picker/datepicker.js"></script>
    <script src="<?= base_url() ?>/assets/js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="<?= base_url() ?>/assets/js/datepicker/date-picker/datepicker.custom.js"></script>
    <script src="<?= base_url() ?>/assets/js/general-widget.js"></script>
    <script src="<?= base_url() ?>/assets/js/height-equal.js"></script>
<?= $this->endSection() ?>