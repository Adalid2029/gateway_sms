<?= $this->extend('Admin/layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Crypto</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Crypto</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-3 col-xl-4 box-col-4">
            <div class="row">
                <div class="col-xl-12 col-sm-6">
                    <div class="card crypto-main-card">
                        <div class="card-body">
                            <div class="deposit-wrap">
                                <div>
                                    <h5>Cryptocurrency just got even better.</h5>
                                    <p>Lorem Ipsum is simply dummy text</p>
                                    <button class="btn btn-white f-w-500">Deposit Now</button>
                                </div><img src="<?= base_url() ?>/assets/images/dashboard-4/crypto.png" alt="crypto">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-sm-6">
                    <div class="card widget-hover">
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
                <div class="col-xl-12 col-sm-6">
                    <div class="card widget-hover">
                        <div class="card-body radial-progress-card">
                            <div>
                                <h6 class="mb-0">Average Profit Per Day</h6>
                                <div class="sale-details">
                                    <h5 class="font-secondary mb-0">89.6%</h5><span class="f-12 f-light f-w-500"><i data-feather="arrow-up"></i>+2.7%</span>
                                </div>
                                <p class="f-light"> The point of using Lorem Ipsum</p>
                            </div>
                            <div class="radial-chart-wrap">
                                <div id="radial-chart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-sm-6">
                    <div class="card widget-hover">
                        <div class="card-body radial-progress-card">
                            <div>
                                <h6 class="mb-0">Average Visits Per Day</h6>
                                <div class="sale-details">
                                    <h5 class="font-success mb-0">70k</h5><span class="f-12 f-light f-w-500"><i data-feather="arrow-up"></i>+1.5%</span>
                                </div>
                                <p class="f-light"> The point of using Lorem Ipsum</p>
                            </div>
                            <div class="radial-chart-wrap">
                                <div id="radial-chart3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card tranaction-card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5>Transactions</h5>
                                <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="false">Buy</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="sell-tab" data-bs-toggle="tab" data-bs-target="#sell" type="button" role="tab" aria-controls="sell" aria-selected="false">Sell</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                                    <div class="table-responsive recent-table transaction-table">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy BTC</h6><span class="f-light">14 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell ETH</h6><span class="f-light">25 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.089 ETH</span></td>
                                                    <td> <span class="f-light f-w-500">$116.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy LTC</h6><span class="f-light">28 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy LTC</h6><span class="f-light">05 Apr, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.089 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$29.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell BTC</h6><span class="f-light">16 Apr, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.012 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy BTC</h6><span class="f-light">14 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell ETH</h6><span class="f-light">25 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.089 ETH</span></td>
                                                    <td> <span class="f-light f-w-500">$116.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy LTC</h6><span class="f-light">28 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="buy" role="tabpanel" aria-labelledby="buy-tab">
                                    <div class="table-responsive recent-table transaction-table">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy LTC</h6><span class="f-light">30 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.010 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$105.00</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy ETH</h6><span class="f-light">05 Apr, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.075 ETH</span></td>
                                                    <td> <span class="f-light f-w-500">$120.74</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy BTC</h6><span class="f-light">14 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy LTC</h6><span class="f-light">05 Apr, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.089 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$29.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy BTC</h6><span class="f-light">17 Sep, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.08 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$380.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy LTC</h6><span class="f-light">30 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.010 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$105.00</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy ETH</h6><span class="f-light">05 Apr, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.075 ETH</span></td>
                                                    <td> <span class="f-light f-w-500">$120.74</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Buy BTC</h6><span class="f-light">14 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                                    <div class="table-responsive recent-table transaction-table">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell BTC</h6><span class="f-light">14 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell ETH</h6><span class="f-light">25 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.089 ETH</span></td>
                                                    <td> <span class="f-light f-w-500">$116.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell LTC</h6><span class="f-light">28 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell LTC</h6><span class="f-light">05 Apr, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.089 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$29.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell BTC</h6><span class="f-light">16 Apr, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.012 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell BTC</h6><span class="f-light">14 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 BTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-danger me-2" data-feather="trending-down"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell ETH</h6><span class="f-light">25 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.089 ETH</span></td>
                                                    <td> <span class="f-light f-w-500">$116.89</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex"> <i class="font-success me-2" data-feather="trending-up"></i>
                                                            <div>
                                                                <h6 class="f-14 mb-0">Sell LTC</h6><span class="f-light">28 Mar, 2022</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> <span class="f-light f-w-500">0.018 LTC</span></td>
                                                    <td> <span class="f-light f-w-500">$236.89</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-8 box-col-8e">
            <div class="row">
                <div class="col-sm-4">
                    <div class="currency-widget warning">
                        <div class="d-flex">
                            <div class="currency-icon-widget">
                                <svg>
                                    <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#beta"></use>
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
                                    <h5 class="mb-0">$21,43</h5><span class="f-12 f-w-500 font-warning"><i class="me-1" data-feather="trending-up"></i>+50%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="currency-widget primary">
                        <div class="d-flex">
                            <div class="currency-icon-widget">
                                <svg>
                                    <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#eth"></use>
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
                <div class="col-sm-4">
                    <div class="currency-widget success">
                        <div class="d-flex">
                            <div class="currency-icon-widget">
                                <svg>
                                    <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#ltc"></use>
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
                <div class="col-xl-12">
                    <div class="card market-card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5>Market Graph</h5>
                                <ul class="nav nav-tabs custom-tab" id="tabdesign" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="hour-tab" data-bs-toggle="tab" data-bs-target="#hour" type="button" role="tab" aria-selected="false">1H</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="day-tab" data-bs-toggle="tab" data-bs-target="#day" type="button" role="tab" aria-selected="false">1D</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="week-tab" data-bs-toggle="tab" data-bs-target="#week" type="button" role="tab" aria-selected="true">1W</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month" type="button" role="tab" aria-selected="false">1M</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="year-tab" data-bs-toggle="tab" data-bs-target="#year" type="button" role="tab" aria-selected="false">1Y</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row m-0 overall-card">
                                <div class="col-xxl-8 col-xl-7 col-md-8 col-sm-7 p-0 box-col-7 col-ed-7">
                                    <div class="market-chart-container">
                                        <div id="market-chart"></div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-5 col-md-4 col-sm-5 p-0 box-col-5 col-ed-5">
                                    <div class="row g-sm-3 g-2">
                                        <div class="col-md-12">
                                            <div class="light-card balance-card align-items-center">
                                                <h6 class="f-w-400 f-14 mb-0">Coinmarketcap</h6>
                                                <div class="ms-auto text-end"><span class="badge badge-light-success rounded-pill">+11.67%</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="light-card balance-card align-items-center">
                                                <h6 class="f-w-400 f-14 mb-0">Binance</h6>
                                                <div class="ms-auto text-end"><span class="badge badge-light-success rounded-pill">+10.67%</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="light-card balance-card align-items-center">
                                                <h6 class="f-w-400 f-14 mb-0">Coinbase</h6>
                                                <div class="ms-auto text-end"><span class="badge badge-light-secondary rounded-pill">-11.67%</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="light-card balance-card align-items-center">
                                                <h6 class="f-w-400 f-14 mb-0">Yobit</h6>
                                                <div class="ms-auto text-end"><span class="badge badge-light-success rounded-pill">+13.67%</span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-outline-dark w-100" type="button">See All Balance</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5>My Currencies</h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="recent-table table-responsive currency-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="f-light">Coin Name</th>
                                            <th class="f-light">Price</th>
                                            <th class="f-light">24h Change</th>
                                            <th class="f-light">Total Balance</th>
                                            <th class="f-light">Total Coin</th>
                                            <th class="f-light">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="currency-icon warning">
                                                        <svg>
                                                            <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#beta"></use>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h6 class="f-14 mb-0 f-w-400">Bitcoin</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$13,098.09</td>
                                            <td>
                                                <div class="change-currency font-success"> <i class="me-1" data-feather="trending-up"></i>5.90</div>
                                            </td>
                                            <td>$74,871.470</td>
                                            <td>1.09634721</td>
                                            <td>
                                                <button class="btn badge-light-primary">Trade</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="currency-icon success">
                                                        <svg>
                                                            <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#ltc"></use>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h6 class="f-14 mb-0 f-w-400">Litecoin</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$11,098.04</td>
                                            <td>
                                                <div class="change-currency font-secondary"><i class="me-1" data-feather="trending-down"></i>2.90</div>
                                            </td>
                                            <td>$87,897.098</td>
                                            <td>1.09675432</td>
                                            <td>
                                                <button class="btn badge-light-primary">Trade</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="currency-icon primary">
                                                        <svg>
                                                            <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#eth"></use>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h6 class="f-14 mb-0 f-w-400">Eathereum</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$45,198.09</td>
                                            <td>
                                                <div class="change-currency font-success"><i class="me-1" data-feather="trending-up"></i>0.12</div>
                                            </td>
                                            <td>$45,178.010</td>
                                            <td>1.41557127</td>
                                            <td>
                                                <button class="btn badge-light-primary">Trade</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="currency-icon secondary">
                                                        <svg>
                                                            <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#bin"></use>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h6 class="f-14 mb-0 f-w-400">Binance</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$35,098.34</td>
                                            <td>
                                                <div class="change-currency font-success"><i class="me-1" data-feather="trending-up"></i>3.56</div>
                                            </td>
                                            <td>$64,100.066</td>
                                            <td>1.78142254</td>
                                            <td>
                                                <button class="btn badge-light-primary">Trade</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="currency-icon dark-green">
                                                        <svg>
                                                            <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#te"></use>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h6 class="f-14 mb-0 f-w-400">Tether</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$56,898.91</td>
                                            <td>
                                                <div class="change-currency font-secondary"><i class="me-1" data-feather="trending-down"></i>1.23</div>
                                            </td>
                                            <td>$61,574.218</td>
                                            <td>1.574215</td>
                                            <td>
                                                <button class="btn badge-light-primary">Trade</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top gap-1">
                                <h5>Buy Coins</h5>
                                <div class="dropdown icon-dropdown">
                                    <button class="btn dropdown-toggle" id="buydropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="buydropdown"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <form class="theme-form crypto-form">
                                <div class="mb-3">
                                    <label class="form-label f-light" for="money">Enter your Money</label>
                                    <div class="position-relative">
                                        <input class="form-control" id="money" type="number" placeholder="100">
                                        <select class="form-select crypto-select warning">
                                            <option>USD</option>
                                            <option>BTC</option>
                                            <option>LTC</option>
                                            <option>ETH</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label f-light" for="coin">Enter Coins Converted to</label>
                                    <div class="position-relative">
                                        <input class="form-control" id="coin" type="number" placeholder="0.0043">
                                        <select class="form-select crypto-select primary">
                                            <option>BTC</option>
                                            <option>USD</option>
                                            <option>LTC</option>
                                            <option>ETH</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-hover-effect w-100" type="button">Buy Coins</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top gap-1">
                                <h5>Sell Coins</h5>
                                <div class="dropdown icon-dropdown">
                                    <button class="btn dropdown-toggle" id="selldropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="selldropdown"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <form class="theme-form crypto-form">
                                <div class="mb-3">
                                    <label class="form-label f-light" for="crypto-coin">Enter Crypto Coins</label>
                                    <div class="position-relative">
                                        <input class="form-control" id="crypto-coin" type="number" placeholder="100">
                                        <select class="form-select crypto-select warning">
                                            <option>USD</option>
                                            <option>BTC</option>
                                            <option>LTC</option>
                                            <option>ETH</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label f-light" for="bitcoin">Enter Money Converted to</label>
                                    <div class="position-relative">
                                        <input class="form-control" id="bitcoin" type="number" placeholder="0.0043">
                                        <select class="form-select crypto-select primary">
                                            <option>LTC</option>
                                            <option>USD</option>
                                            <option>BTC</option>
                                            <option>ETH</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-hover-effect w-100" type="button">Sell Coins</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 box-col-12">
            <div class="row box-order">
                <div class="col-xxl-12 col-sm-6 box-col-6">
                    <div class="card balance-box">
                        <div class="card-body">
                            <div class="balance-profile">
                                <div class="balance-img"><img src="<?= base_url() ?>/assets/images/dashboard-4/user.png" alt="user vector"><a class="edit-icon" href="<?= base_url("user/user-profile") ?>">
                                        <svg>
                                            <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#pencil"></use>
                                        </svg></a></div><span class="f-light d-block">Your Balance </span>
                                <h5 class="mt-1">$768,987.90</h5>
                                <ul>
                                    <li>
                                        <div class="balance-item danger">
                                            <div class="balance-icon-wrap">
                                                <div class="balance-icon"><i data-feather="arrow-down-right"></i></div>
                                            </div>
                                            <div> <span class="f-12 f-light">Investment </span>
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
                <div class="col-xxl-12 order-xxl-0 order-1">
                    <div class="card portfolio-card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">My Portfolio</h5>
                                <div class="card-header-right-icon">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" id="portfolioButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">BTC</button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="portfolioButton"><a class="dropdown-item" href="#">ETH</a><a class="dropdown-item" href="#">USD</a><a class="dropdown-item" href="#">LTC</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xxl-12 col-xl-7 col-sm-6 box-col-6">
                                    <div class="portfolio-chart-container">
                                        <div id="portfolio-chart"> </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-5 col-sm-6 box-col-6">
                                    <div class="portfolio-table recent-table table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon warning">
                                                            <svg>
                                                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#beta"></use>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-1">Bitcoin</h6>
                                                            <div class="d-flex align-items-center gap-1"><span class="status bg-success"></span><span class="f-light">BTC</span></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <h6 class="f-14 f-w-400 mb-1">BTC 0.00876543</h6><span class="font-success">$14,987.13</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon success">
                                                            <svg>
                                                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#ltc"></use>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-1">Ethereum</h6>
                                                            <div class="d-flex align-items-center gap-1"><span class="status bg-danger"></span><span class="f-light">ETH</span></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <h6 class="f-14 f-w-400 mb-1">ETC 1.60876543</h6><span class="font-danger">$49,987.13</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon primary">
                                                            <svg>
                                                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#eth"></use>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-1">Litecoin</h6>
                                                            <div class="d-flex align-items-center gap-1"><span class="status bg-success"></span><span class="f-light">LTC</span></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <h6 class="f-14 f-w-400 mb-1">LTC 1.60876543</h6><span class="font-success">$35,571.25</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="currency-icon light-blue">
                                                            <svg>
                                                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#dash"></use>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h6 class="f-14 mb-1">Dash</h6>
                                                            <div class="d-flex align-items-center gap-1"><span class="status bg-success"></span><span class="f-light">DSH</span></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <h6 class="f-14 f-w-400 mb-1">DSH 1.80741510</h6><span class="font-success">$17,047.30</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12 col-sm-6 box-col-6">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Activities</h5>
                                <div class="card-header-right-icon">
                                    <div class="dropdown icon-dropdown">
                                        <button class="btn dropdown-toggle" id="activitiesButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="activitiesButton"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Yearly</a><a class="dropdown-item" href="#">Monthly</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 activity-card">
                            <div class="appointment-table customer-table table-responsive">
                                <table class="table table-bordernone">
                                    <tbody>
                                        <tr>
                                            <td><img class="img-fluid img-40 rounded-circle me-2" src="<?= base_url() ?>/assets/images/dashboard/user/3.jpg" alt="user"></td>
                                            <td class="img-content-box"><a class="d-block f-w-500" href="<?= base_url("user/user-profile") ?>">Anna K.</a><span class="f-light">To : 0x187...12bb</span></td>
                                            <td class="text-end"> <span class="font-success">+0.3BNB</span><span class="d-block f-light">29.09.22</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="img-fluid img-40 rounded-circle me-2" src="<?= base_url() ?>/assets/images/dashboard/user/12.jpg" alt="user"></td>
                                            <td class="img-content-box"><a class="d-block f-w-500" href="<?= base_url("user/user-profile") ?>">Guy Hawkins</a><span class="f-light">To : 0x187...12bb</span></td>
                                            <td class="text-end"> <span class="font-success">+0.3BNB</span><span class="d-block f-light">29.09.22</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="img-fluid img-40 rounded-circle me-2" src="<?= base_url() ?>/assets/images/dashboard/user/10.jpg" alt="user"></td>
                                            <td class="img-content-box"><a class="d-block f-w-500" href="<?= base_url("user/user-profile") ?>">Jenny Wilson</a><span class="f-light">To : 0x187...12bb</span></td>
                                            <td class="text-end"> <span class="font-danger">-0.1BNB</span><span class="d-block f-light">29.09.22</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="img-fluid img-40 rounded-circle me-2" src="<?= base_url() ?>/assets/images/dashboard/user/11.jpg" alt="user"></td>
                                            <td class="img-content-box"><a class="d-block f-w-500" href="<?= base_url("user/user-profile") ?>">Jacob B.</a><span class="f-light">To : 0x187...12bb</span></td>
                                            <td class="text-end"> <span class="font-success">+0.3BNB</span><span class="d-block f-light">29.09.22</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="img-fluid img-40 rounded-circle me-2" src="<?= base_url() ?>/assets/images/dashboard/user/13.jpg" alt="user"></td>
                                            <td class="img-content-box"><a class="d-block f-w-500" href="<?= base_url("user/user-profile") ?>">Esther Howard</a><span class="f-light">To : 0x187...12bb</span></td>
                                            <td class="text-end"> <span class="font-danger">-0.2BNB</span><span class="d-block f-light">29.09.22</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="img-fluid img-40 rounded-circle me-2" src="<?= base_url() ?>/assets/images/dashboard/user/5.jpg" alt="user"></td>
                                            <td class="img-content-box"><a class="d-block f-w-500" href="<?= base_url("user/user-profile") ?>">Leslie Alexander</a><span class="f-light">To : 0x187...12bb</span></td>
                                            <td class="text-end"> <span class="font-success">+0.3BNB</span><span class="d-block f-light">29.09.22</span></td>
                                        </tr>
                                    </tbody>
                                </table>
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
<script src="<?= base_url() ?>/assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="<?= base_url() ?>/assets/js/dashboard/dashboard_4.js"></script>
<?= $this->endSection() ?>