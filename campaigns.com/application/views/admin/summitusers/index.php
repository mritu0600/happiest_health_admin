<style>
  .table-responsive td, .table th {
    border-top: 1px solid #e2e5e8;
    white-space: break-spaces;
    padding: 1.05rem 0.75rem;
}
#delete {
    cursor: pointer;
    color: white;
    background: #E60000;
    border-radius: 2px;
    padding: 8px 11px 6px 0;
    margin-left: 18px;
}
  #delete i{
    margin-right: 5px;
  }
  #simpletable_length{
    margin-top: 39px;
  }
  .view_all_btn {
    margin-top: 35px;
  }
  .inner_content{
    margin: 0px 0px 24px !important;
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
                        <?php /* ?><h5 class="m-b-10">Welcome <?=sessionData('ILCADM_ADMIN_FIRST_NAME')?></h5><?php */ ?>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"> Users List</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <form id="Data_Form" name="Data_Form" method="get" action="<?php echo $forAction; ?>">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-6">
                  <h5>Users List</h5>
                </div>
                <div class="col-md-6"> 
                  <div class="">
                    <input type="text" name="searchValue" class="search" id="searchValue" value="<?php echo $searchValue; ?>" class="form-control form-control-sm" placeholder="Enter Search Text">
                  </div>
                </div>
              </div>
              <!-- <a href="<?php echo getCurrentControllerPath('addeditdata'); ?>" class="btn btn-sm btn-primary pull-right">Add Content</a> -->
            </div>
            <div class="card-body">
              <div class="dt-responsive table-responsive">
                <div id="simpletable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row inner_content">
                    <div class="col-sm-12 col-md-3">
                      <div class="dataTables_length" id="simpletable_length">
                        <label>Show 
                          <select name="showLength" id="showLength" class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="2" <?php if($perpage == '2')echo 'selected="selected"'; ?>>2</option>
                            <option value="10" <?php if($perpage == '10')echo 'selected="selected"'; ?>>10</option>
                            <option value="25" <?php if($perpage == '25')echo 'selected="selected"'; ?>>25</option>
                            <option value="50" <?php if($perpage == '50')echo 'selected="selected"'; ?>>50</option>
                            <option value="100" <?php if($perpage == '100')echo 'selected="selected"'; ?>>100</option>
                            <option value="All" <?php if($perpage == 'All')echo 'selected="selected"'; ?>>All</option>
                          </select>
                          entries
                        </label>
                        <span id='delete' ><i class="fa fa-trash"  style="margin-left: 10px;color: white;"></i>Delete</span>
                          <!--<span><a href="<?php echo base_url()?>admin/export/summitusers_export" class="btn btn-success" style="margin-left: 70px;"> Export Excel</a></span>-->
                      </div>                        
                    </div>
                    <div class="col-sm-12 col-md-9">
                      <div class="row" style="margin:0px;">
                        <div class="col-md-3 col-sm-4 col-xs-4 search">
                          <label> Select Campaign</span></label>
                          <select class="form-control" name="campaign_name" id="campaign_name"> 
                            <option value="">Select Campaign</option>
                              <option  value="move_summit" <?php if($_GET['campaign_name']) { if($_GET['campaign_name'] == 'move_summit'){ echo "selected"; } } ?>>Move Summit</option>
                              <option value="healthzine_subscription" <?php if($_GET['campaign_name']) { if($_GET['campaign_name'] == 'healthzine_subscription'){ echo "selected"; } } ?>>Healthzine Subscription</option>
                              <option value="magazine_subscription" <?php if($_GET['campaign_name']) { if($_GET['campaign_name'] == 'magazine_subscription'){ echo "selected"; } } ?>>Magazine Subscription</option>
                              <option value="diabetes_newsletter" <?php if($_GET['campaign_name']) { if($_GET['campaign_name'] == 'diabetes_newsletter'){ echo "selected"; } } ?>>Diabetes Newsletter </option>
                          </select>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-4 search" >
                          <label>Date from</label>
                          <?php
                            if($_GET['s_date'] != ""){
                              $date = $_GET['s_date'];
                              $start_date = date("Y-m-d", strtotime($date));
                            }else{
                            $start_date = "";
                            } // Default to today's date if not provided 
                          ?>
                          <input class="form-control input-sm" type="date" name="s_date" value="<?php echo $start_date ?>" placeholder="Start Date">
                          <p id="from_date" style="display:none;color:red;"> Please enter From Date</p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-4 search" >
                          <label>Date to</label>
                          <?php
                            if($_GET['e_date'] != ""){
                              $date = $_GET['e_date'];
                              $get_date = date("Y-m-d", strtotime($date));
                            }else{
                            $get_date = "";
                            } // Default to today's date if not provided  
                          ?>
                          <input class="form-control input-sm" type="date" value="<?php  echo $get_date;  ?>" name="e_date"  max="<?php echo date("Y-m-d"); ?>"  placeholder="End Date">
                          <p id="to_date" style="display:none;color:red;"> Please enter To Date</p>
                        </div>
                        <div class="col-sm-4 col-md-3 px-0"> 
                          <div class="view_all_btn">
                            <button class="btn btn-success" id="#viewdata" onclick="change_url()">View All</button>
                            <button type="button" id="export" class="btn btn-success" onclick="submit_form();">Export in Excel</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="simpletable_info">
                          <thead>
                            <tr role="row">
                            <th width="6%"><input type="checkbox" id="ckbCheckAll"> Select All</th>
                              <th>Sr.No.</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Contact No.</th> 
                              <th>City</th>
                              <th>Campaign Name</th>
                              <th>Submission Date</th>
                              <th>Status</th>     
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if($ALLDATA <> ""): $i=$first; $j=0; foreach($ALLDATA as $ALLDATAINFO): 
                              if($j%2==0): $rowClass = 'odd'; else: $rowClass = 'even'; endif;
                            ?>
                            <tr role="row" class="<?php echo $rowClass; ?>" style="<?php echo $class; ?>">
                              <td><input type="checkbox" value="<?=$ALLDATAINFO['id']?>" class="checkBoxClass" id="<?=$ALLDATAINFO['id']?>"></td>
                              <td><?=$i++?></td>
                              <?php 
                              $campaign_name = str_replace('_', ' ', $ALLDATAINFO['campaign_name']);
                              ?>
                              <td><?=stripslashes(strip_tags($ALLDATAINFO['name']))?></td>
                              <td><?=stripslashes(strip_tags($ALLDATAINFO['email']))?></td>
                              <td><?=stripslashes(strip_tags($ALLDATAINFO['mobile']))?></td>
                              <td><?=stripslashes(strip_tags($ALLDATAINFO['city']))?></td>
                              <td><?=stripslashes(strip_tags(ucwords($campaign_name)))?></td>
                              <td><?=date('d M Y H:i',strtotime(stripslashes(strip_tags($ALLDATAINFO['created_date']))))?></td>
                              <td><?=showStatus($ALLDATAINFO['status'])?></td>
                              <td>
                                <div class="btn-group">
                                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                  <ul class="dropdown-menu" role="menu">                        
                                      <li><a href="<?php echo getCurrentControllerPath('deletedata/'.$ALLDATAINFO['id'])?>" onClick="return confirm('Want to delete!');"><i class="fas fa-trash"></i> Delete</a></li>
                                  </ul>
                                </div>
                              </td>
                            </tr>
                            <?php $j++; endforeach; else: ?>
                              <tr>
                                <td colspan="4" style="text-align:center;">No Data Available In Table</td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-5">
                      <div class="dataTables_info" role="status" aria-live="polite"><?php echo $noOfContent; ?></div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                      <div class="dataTables_paginate paging_simple_numbers">
                        <?php echo $PAGINATION; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- [ Main Content ] end -->
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" ></script>


<!--<script type="text/javascript">
$('#export').click(function(){

  var sdate = $("#s_date").val();
  var edate = $("#e_date").val();
  if(sdate == ""){
    document.getElementById('from_date').style.display = 'block';
    return false;
    //var kjsnfnfsnfnfksdaf 
  }else{
    document.getElementById('from_date').style.display = 'none';
  }
  if(edate == ""){
    document.getElementById('to_date').style.display = 'block';
    return false;
  }else{
    document.getElementById('to_date').style.display = 'none';
  }
});
</script>-->

<script>
  function change_url(){   
    var url = "<?=$forAction?>";
    $("#Data_Form").attr("action", url);
    $("#Data_Form").submit();
  }
  function submit_form(){
    //alert("form");
    //Data_Form

    var sdate = $("#s_date").val();
    //alert(sdate);
    var edate = $("#e_date").val();
    if(sdate == ""){
      document.getElementById('from_date').style.display = 'block';
      return false;
      //var kjsnfnfsnfnfksdaf 
    }else{
      document.getElementById('from_date').style.display = 'none';
    }
    if(edate == ""){
      document.getElementById('to_date').style.display = 'block';
      return false;
    }else{
      document.getElementById('to_date').style.display = 'none';
    }
    var url = "<?=base_url('admin/export/summitusers_export')?>";
    $("#Data_Form").attr("action", url);
    $("#Data_Form").submit();
    
  } 
</script>
<script type="text/javascript">
$('#viewdata').click(function(){

  var sdate = $("#s_date").val();
  var edate = $("#e_date").val();
  if(sdate == ""){
    document.getElementById('from_date').style.display = 'block';
    return false;
    //var kjsnfnfsnfnfksdaf 
  }else{
    document.getElementById('from_date').style.display = 'none';
  }
  if(edate == ""){
    document.getElementById('to_date').style.display = 'block';
    return false;
  }else{
    document.getElementById('to_date').style.display = 'none';
  }
});
</script>

<!-- Delete Records JS -->
<script type="text/javascript">
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });

    $('#delete').click(function(){

    var post_arr = [];

    $('input[type=checkbox]').each(function() {
      if ($(this).is(":checked")) {
        var postid = this.id;

        post_arr.push(postid);
        
      }
      
  });


  if(post_arr.length > 0){
      	var url= "<?php echo base_url('admin/adminsummitusers/deleterecords');?>";
        var isDelete = confirm("Do you really want to delete selected records?");
        if (isDelete == true) {
           // AJAX Request
           $.ajax({
              url: url,
              type: 'POST',
              data: { post_id: post_arr},
              success: function(response){
                
              	// alertMessageModelPopup('Record Deleted successfully','Success');
              	location.reload();
                // console.log(response);
                // alert(response);
              }
           });
        } 
    }else{
    	alert('Please select atleast one Record to delete.')
    } 
    });
  </script>