<style type="text/css">
	/*.d-card-body {
    overflow-y: auto;
    height: 300px;
}*/
#container {
  height: 400px;
}

.highcharts-figure, .highcharts-data-table table {
  min-width: 310px;
  max-width: 800px;
  margin: 1em auto;
}

#datatable {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #EBEBEB;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
#datatable caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
#datatable th {
	font-weight: 600;
  padding: 0.5em;
}
#datatable td, #datatable th, #datatable caption {
  padding: 0.5em;
}
#datatable thead tr, #datatable tr:nth-child(even) {
  background: #f8f8f8;
}
#datatable tr:hover {
  background: #f1f7ff;
}

#container {
   height: 400px;
   }
   .highcharts-figure, .highcharts-data-table table {
   min-width: 310px;
   max-width: 800px;
   margin: 1em auto;
   }
   #datatable {
   font-family: Verdana, sans-serif;
   border-collapse: collapse;
   border: 1px solid #EBEBEB;
   margin: 10px auto;
   text-align: center;
   width: 100%;
   max-width: 500px;
   }
   #datatable caption {
   padding: 1em 0;
   font-size: 1.2em;
   color: #555;
   }
   #datatable th {
   font-weight: 600;
   padding: 0.5em;
   }
   #datatable td, #datatable th, #datatable caption {
   padding: 0.5em;
   }
   #datatable thead tr, #datatable tr:nth-child(even) {
   background: #f8f8f8;
   }
   #datatable tr:hover {
   background: #f1f7ff;
   }
   .card-box {
   position: relative;
   color: #fff;
   padding: 20px 10px 40px;
   margin: 10px 0px;
   margin-left: 2px;
   }
   .card-box:hover {
   text-decoration: none;
   color: #f1f1f1;
   }
   .card-box:hover .icon i {
   font-size: 100px;
   transition: 1s;
   -webkit-transition: 1s;
   }
   .card-box .inner {
   padding: 5px 10px 0 10px;
   }
   .card-box h3 {
   font-size: 27px;
   font-weight: bold;
   margin: 0 0 8px 0;
   white-space: nowrap;
   padding: 0;
   text-align: left;
   }
   .card-box p {
   font-size: 15px;
   }
   .card-box .icon {
   position: absolute;
   top: auto;
   bottom: 5px;
   right: 20px;
   z-index: 0;
   font-size: 72px;
   color: rgba(0, 0, 0, 0.15);
   }
   .card-box .card-box-footer {
   position: absolute;
   left: 0px;
   bottom: 0px;
   text-align: center;
   padding: 3px 0;
   color: rgba(255, 255, 255, 0.8);
   background: rgba(0, 0, 0, 0.1);
   width: 100%;
   text-decoration: none;
   }
   .card-box:hover .card-box-footer {
   background: rgba(0, 0, 0, 0.3);
   }
   .bg-blue {
   background-color: #14314b !important;
   }
   .bg-green {
   background-color: #05265A !important;
   }
   .bg-orange {
   background-color: #eb7549 !important;
   }
   .bg-red {
   background-color: #d9534f !important;
   }
</style>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <?php /* ?><h5 class="m-b-10">Welcome <?=sessionData('CMPOP_ADMIN_FIRST_NAME')?></h5><?php */ ?>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo getCurrentDashboardPath('dashboard/index'); ?>"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Dashboard</h5>
                    </div>
                    <div class="main-content">
                  <div class="container-fluid">
                     <div class="panel panel-headline">
                        <div class="panel-heading">
                           <h3 class="panel-title">Welcome To Happiest Health CRM </h3>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                              &nbsp;
                           </div>
                          <div class="row">
                                 <div class="col-lg-3 col-sm-6">
                                    <div class="card-box bg-green">
                                       <div class="inner">
                                          <h3 style="color:white;"><?php if ($summit_users == '' ) { echo '0'; } else {echo count($summit_users);}?></h3>
                                          <p>Campaign Leads </p>
                                       </div>
                                       <div class="icon">
                                          <i class="fa fa-users" aria-hidden="true"></i>
                                       </div>
                                       <a href="<?=base_url('admin/adminsummitusers/index')?>" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                 </div>
                                 <!-- <div class="col-lg-3 col-sm-6">
                                    <div class="card-box bg-green">
                                       <div class="inner">
                                          <h3 style="color:white;"> <?php if ($retirement == '' ) { echo '0'; } else {echo count($retirement);}?></h3>
                                          <p> Total Retirement Plan Users</p>
                                       </div>
                                       <div class="icon">
                                          <i class="fa fa-users" aria-hidden="true"></i>
                                       </div>
                                       <a href="<?=base_url('admin/adminretirementusers/index')?>" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                 </div>
                                 <div class="col-lg-3 col-sm-6">
                                    <div class="card-box bg-green">
                                       <div class="inner">
                                          <h3 style="color:white;"><?php if ($lifestyle == '' ) { echo '0'; } else {echo count($lifestyle);}?></h3>
                                          <p> Total Saving Plan Users</p>
                                       </div>
                                       <div class="icon">
                                          <i class="fa fa-users" aria-hidden="true"></i>
                                       </div>
                                       <a href="<?=base_url('admin/adminlifestyleusers/index')?>" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                 </div> -->
                              </div>
                        </div>
                     </div>
                  </div>
               </div>
                    <div class="card-body">
                      <div class="card-block">
                        <div class="row ">
                          <div class="container-fluid">
                            <div class="panel panel-headline">
                              <div class="panel-body">
                                <div class="row box_guard">

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>