<?php ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Report</h1>
        <div class="d-none d-sm-inline-block">
            <div id="date-picker-widget" class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="left btn btn-sm btn-secondary"><i class="fa fa-angle-left"></i></button>
                <button type="button" class="middle btn btn-sm btn-secondary">
                    <i class="fa fa-calendar"></i> &nbsp;<span id="cdp-description">Dec 2019</span></button>
                <button type="button" class="right btn btn-sm btn-secondary"><i class="fa fa-angle-right"></i></button>
            </div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm"><i class="fas fa-cog fa-sm text-white-50"></i> Options</a>
            <a data-toggle="modal" data-target="#transaction-modal"  href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print fa-sm text-white-50"></i> Print report</a>
        </div>
    </div>

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Income</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 <span id="in-tile" class="aj">

                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Expenses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 <span id="ex-tile" class="aj">

                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Savings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 <span id="sv-tile" class="aj">

                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Average Expense</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 <span id="av-tile" class="aj">

                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Expenses by Category</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div class="aj charts-loader"></div>
                        <canvas id="pie-all-cats"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                        <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                        <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top Expenses</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="list-expenses" class="" style="min-height: 360px;">
                        <div class="aj"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Income vs Expenditure</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <div class="aj charts-loader"></div>
                        <canvas id="incomevsexpense"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
                </div>
                <div class="card-body">
                    <div id="trans-layout" class="table-responsive" style="min-height: 500px;">
                        <div class="aj"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- customer date picker content -->
<div id="custom-date-picker">
    <div id="cdp-menu" class="cdp-options">
        <div class="card" style="padding: 15px;">
            <button  style="margin-bottom: 3px;" class="btn-month btn btn-sm btn-primary">Month</button><br><br>
            <button class="btn-range btn btn-sm btn-primary">Date Range</button>
        </div>
    </div>

    <div id="cdp-month-content" class="cdp">
        <div class="card" style="padding: 15px; width: 300px; display: block;">
            <p style="margin-bottom: 3px;">Pick a month</p>
            <span>Year: </span>&nbsp;&nbsp;<select id="months-picker" style="margin-bottom: 3px; width: 100px; display: inline;">
                <option value="2019" selected>2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
            </select>
            <div class="months-listing" id="cdp-months-listing">
                <div class="mn-item">Jan</div>
                <div class="mn-item">Feb</div>
                <div class="mn-item">Mar</div>
                <div class="mn-item">Apr</div>
                <div class="mn-item">May</div>
                <div class="mn-item">Jun</div>
                <div class="mn-item">Jul</div>
                <div class="mn-item">Aug</div>
                <div class="mn-item">Sep</div>
                <div class="mn-item">Oct</div>
                <div class="mn-item">Nov</div>
                <div class="mn-item">Dec</div>
            </div>
            <button id="cdp-update-months" class="btn btn-sm btn-danger">Update Page</button>
        </div>
    </div>

    <div id="cdp-range-content" class="cdp">
        <div class="card" style="padding: 15px; width: 300px; display: block;">
            <p style="margin-bottom: 3px;">Select a date range</p>
            <span style="color: #4e73df">Start Date</span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input id='cdp-start-date' type="text" class="form-control" placeholder="Start date" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span style="color: #4e73df">End Date</span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input id='cdp-end-date' type="text" class="form-control" placeholder="End date" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <button id="cdp-update-range" class="btn btn-sm btn-danger">Update Page</button>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/pages/insights.js",
    CClientScript::POS_END);?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/custom-datepicker.js",
    CClientScript::POS_END);?>
