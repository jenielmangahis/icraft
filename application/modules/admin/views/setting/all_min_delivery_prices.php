<div class="page-content-wrapper" style="width:100% !important;">
    <div class="page-content" style="padding: 5px 7px 10px 20px; position:fixed;">

        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title setheading">
            Admin Setting 
        </h3>

        <!-- END PAGE HEADER-->

        <div class="clearfix">
        </div>

        <!-- BEGIN PAGE CONTENT-->


        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet-body">
                    <div class="panel with-nav-tabs panel-danger">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li><a href="<?php echo base_url(); ?>manage-users">Manage Users</a></li>
                                <li><a href="<?php echo base_url(); ?>manage-products">Manage Product Input</a></li>
                                <li><a href="<?php echo base_url(); ?>manage-warehouses" data-toggle="tab">Manage Warehouse</a></li>
                                <li><a href="<?php echo base_url(); ?>restricted-areas">Restricted Area</a></li>
                                <li class="active"><a href="<?php echo base_url(); ?>minimum-delivery-prices">Minimum Delivery Prices</a></li>
                                <li><a href="<?php echo base_url(); ?>taxes">Taxes </a></li>
                                <!--
                                <li class="dropdown">
                                    <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#tab4danger" data-toggle="tab">Danger 4</a></li>
                                        <li><a href="#tab5danger" data-toggle="tab">Danger 5</a></li>
                                    </ul>
                                </li>
                                -->
                            </ul>
                        </div>
                        <div class="panel-body padMarZero">
                            <div class="tab-content ">
                                <div class="tab-pane fade in active o" id="manageUsers">

                                    <?php echo validation_errors(); ?>

                                    <?php if ($this->session->userdata('SuccessMsg') != "") { ?>
                                        <div class="success alert-info toBeHidden custom-success" role="alert">
                                            <?php
                                            echo $this->session->userdata('SuccessMsg');
                                            $this->session->unset_userdata('SuccessMsg');
                                            ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ($this->session->userdata('errorMsg') != "") {
                                        ?>
                                        <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                                            <?php
                                            echo $this->session->userdata('errorMsg');
                                            $this->session->unset_userdata('errorMsg');
                                            ?>
                                        </div>

<?php } ?>

                                    <div class="row-fluid top-act">  

                                        <form action='' id="searchData" method="post" >  
                                            <ol class="breadcrumb breadcrumb-arrow">
                                                <li><a href="<?php echo base_url(); ?>admin-dashboard" ><i class="glyphicon glyphicon-home"></i></a></li>
                                                <!-- <li><a href="manage-users">Manage Users</a></li> -->
                                                <!-- <li ><a href="#">Add-Users</a></li> -->
                                                <li class="active"><span>Minimum Delivery Prices</span></li>
                                            </ol>
                                          <!-- <input type="text" class="search-custom" style="width:32%;" value="<?php echo $this->input->post('searchText') != '' ? $this->input->post('searchText') : ''; ?>" name="searchText"  placeholder="Search by message">
                                                <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="start_button" type="button" ><i class="fa fa-refresh"></i></a>
                                                <button class="btn red reset p-xl-pad" id="submitform" type="submit" value="Submit"><i class="fa  fa-check"></i></button>
                                          
                                        <div class="pull-right">
                                            <a class="btn red reset p-xl-pad" href="add-warehouse" id="add_warehouse"><i class="fa fa-plus" style="color:white;"></i> Add Ware House</a>
                                        </div>
                                            -->
                                        </form>
                                    </div>

                                    <div class="row row_mrg" id="myData">
                                        <div class="col-md-12">
                                            <span class="help colorParrot " id="upRowId" style="padding: 5px;color:white;display:none;"></span>
                                            <div class="portlet-body flip-scroll table-scrollable">
                                                <table class="table table-bordered table-striped table-condensed table-hover" >
                                                    <thead class="flip-content">
                                                        <tr>
                                                            <th width="50px"> S No.</th>
                                                            <th width="150px"> Name </th>
                                                            <th width="180px"> Rate($) </th>
                                                            <th width="120px"> Status </th>
                                                            <th width="120px"> Last Updated Date </th>
                                                            <th width="120px"> Last Updated Rate </th>
                                                            <th class="numeric" style="width:100px;"> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    if (count($result) > 0) {
                                                        $i = 0;
                                                        
                                                        if ( isset($_GET['page']) )
                                                        {
                                                            if ($_GET['page'] == '') {
                                                                $i = 0;
                                                            } else {
                                                                $i = ($_GET['page'] - 1 ) * RECORDS_PERPAGE;
                                                            }
                                                        }

                                                        foreach ($result as $key => $list) {
                                                            $cdate = new DateTime($list['created_at']);
                                                            $udate = new DateTime($list['updated_at']);

                                                            $lastUpDate = $list['last_rate'] == '0' ? '<i style="color:red;">Not Yet</i>' : $udate->format('Y-M-d H:i:s');
                                                            $lastUpRate = $list['last_rate'] == '0' ? '<i style="color:red;">Not Yet</i>' : (float) $list['last_rate'];

                                                            $actBtnTxt = $list['active'] == 1 ? '<i class="fa fa-toggle-off" style="color:#b72c12;" aria-hidden="true"></i>' : '<i class="fa fa-toggle-on" style="color:#1474bd;" aria-hidden="true"></i>';
                                                            $actTitle = $list['active'] == 1 ? 'Active' : 'Inactive';
                                                            $actBtnTitle = $list['active'] == 1 ? 'Activate' : 'Inactivate';
                                                            $actBtnId = $list['active'] == 1 ? 'whDeactivator' : 'whActivator';
                                                            ?>          
                                                            <tbody>
                                                                <tr id="row<?php echo $list['id'] ?>">
                                                                    <td> <?php echo $i + 1; ?></td>
                                                                    <td class="numeric"><div id="mdpName_<?php echo $list['id'] ?>" class="form-control notEditadble" style="width:90%;display: inline-block; background: none;word-wrap: break-word;"><?php echo $list['name'] ? ucfirst($list['name']) : ''; ?></div><input id="oldName_<?php echo $list['id']; ?>" name="oldName_<?php echo $list['id']; ?>" type="hidden" val="<?php echo $list['name'] ? ucfirst($list['name']) : ''; ?>" /></td>
                                                                    <td class="numeric"><div id="mdpRate<?php echo $list['id'] ?>" class="form-control bindnum notEditadble" style="width:90%;display: inline-block; background: none;word-wrap: break-word;" ><?php echo $list['rate']; ?></div><input id="oldRate_<?php echo $list['id']; ?>" name="oldRate_<?php echo $list['id']; ?>" type="hidden" val="<?php echo $list['rate'] ? ucfirst($list['rate']) : ''; ?>" /></td>
                                                                    <td class="numeric"><b title=""><?php echo ucfirst($actTitle); ?></b></td>
                                                                    <td class="numeric"><b <div id="mdpOldRate<?php echo $list['id'] ?>" title=""><?php echo $lastUpRate; ?></td>
                                                                                <td class="numeric"><b title=""><?php echo $lastUpDate; ?></b></td>
                                                                                <td class="action">
                                                                                    <span class="no_wrap" ><a title="Make this <?php echo $actBtnTitle; ?>" id ="mdpBtnE<?php echo $list['id'] ?>" href="<?php echo base_url(); ?>change-minimum-delivery-status/<?php echo $list['id']; ?>" class="btn btn-default btn-xs"> <?php echo $actBtnTxt; ?></a></span>
                                                                                    <span class="no_wrap" ><a title="View/Edit" id ="viewWarehouse" class="btn btn-default btn-xs editbtn"><i class="fa fa-pencil-square-o" style="color:#036891;"></i></a></span>
                                                                                    <!-- <span class="no_wrap" ><button title="Delete" id ="whDel" href="delete-warehouse/<?php echo $list['warehouse_id']; ?>" class="btn btn-default btn-xs"> <i class="fa fa-trash-o" style="color:red;"></i> </button></span> -->
                                                                                </td>
                                                                                </tr>
                                                                                </tbody>
                                                                                <?php
                                                                                $i++;
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <tbody>
                                                                                <tr><td class="numeric editable" colspan="7" style="text-align: center"> <i><b>No Delivery Price Table Found</b></i> </td>
                                                                                </tr>
                                                                            </tbody>
<?php } ?>
                                                                        </table>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="manageProductInput">Danger 2</div>
                                                                    <div class="tab-pane fade" id="manageWarehouses">Danger 3</div>
                                                                    <div class="tab-pane fade" id="restrictedAreas">Restricted Area </div>
                                                                    <div class="tab-pane fade" id="minDeliveryPrices">Minimum Delivery Prices</div>
                                                                    <div class="tab-pane fade" id="taxes">Taxes</div>
                                                                    <div class="tab-pane fade" id="tab4danger">Danger 4</div>
                                                                    <div class="tab-pane fade" id="tab5danger">Danger 5</div>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    </div>

                                                                    </div>
                                                                    </div>


                                                                    <!-- Model for Block User -->
                                                                    <div class="modal fade in" id="block" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
                                                                        <div class="">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header  bg bg-primary">
                                                                                    <a class="close" id="closePop"></a>
                                                                                    <h4 class="modal-title">Alert Message</h4>
                                                                                </div>
                                                                                <div class="modal-body">Are you sure you want to block the user? </div>
                                                                                <div class="modal-footer">
                                                                                    <a href="" id="writeDeactivateURL"  class="btn green">Yes</a>
                                                                                    <a class="btn red"  id="closePop">No</a>

                                                                                </div>
                                                                            </div>
                                                                            <!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                    </div>

                                                                    <!-- Model for Activate User -->
                                                                    <div class="modal fade in" id="activate" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
                                                                        <div class="">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header  bg bg-primary">
                                                                                    <a class="close" id="closePop"></a>
                                                                                    <h4 class="modal-title">Alert Message</h4>
                                                                                </div>
                                                                                <div class="modal-body">Are you sure you want to activate the user again? </div>
                                                                                <div class="modal-footer">
                                                                                    <a href="" id="writeActivateURL" class="btn green">Yes</a>
                                                                                    <a class="btn red" id="closePop">No</a>

                                                                                </div>
                                                                            </div>
                                                                            <!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                    </div>

                                                                    <!-- Model for Delete User -->
                                                                    <div class="modal fade in" id="delwarehouse" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
                                                                        <div class="">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header  bg bg-primary">
                                                                                    <a class="close" id="closePopForDel"></a>
                                                                                    <h4 class="modal-title">Alert Message</h4>
                                                                                </div>
                                                                                <div class="modal-body">Are you sure you want to delete the user? </div>
                                                                                <div class="modal-footer">
                                                                                    <a href="" id="writeDeleteURL"  class="btn green">Yes</a>
                                                                                    <a class="btn red"  id="closePopForDel">No</a>

                                                                                </div>
                                                                            </div>
                                                                            <!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                    </div>


                                                                    <script src="<?php echo base_url(); ?>assets/admin/pages/scripts/minimum-delivery-prices.js"  type="text/javascript" ></script>
                                                                    <script>
                                                                        jQuery(document).ready(function () {
                                                                            Metronic.init(); // init metronic core components
                                                                            Layout.init(); // init current layout
                                                                            QuickSidebar.init(); // init quick sidebar
                                                                            Demo.init(); // init demo features

                                                                            $(document).on("click", "#whDeactivator", function () {//enable disabled driver message popup
                                                                                var xhref = $(this).attr('href');//get driver Id
                                                                                //var userId = $(this).attr('userId');//get driver Id
                                                                                //var status = $(this).attr('status');//get driver status
                                                                                //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php // echo $_GET['searchText'];  ?>';//write new url to deactivate for popup

                                                                                $('#writeDeactivateURL').attr("href", xhref);//write new generated url
                                                                                $('#block').show();//show popup
                                                                            });

                                                                            $(document).on("click", "#whActivator", function () {//enable activate driver message popup
                                                                                var xhref = $(this).attr('href');//get driver Id
                                                                                //var userId = $(this).attr('userId');//get driver Id
                                                                                //var status = $(this).attr('status');//get driver status
                                                                                //var url = 'activeDeactiveDriver/'+status+'/'+driverId+'?searchText=<?php //echo $_GET['searchText'];  ?>'; //write new url to activate for popup
                                                                                //var url = 'change-family-status/'+status+'/'+userId;
                                                                                $('#writeActivateURL').attr("href", xhref);//write new generated url
                                                                                $('#activate').show();//show popup
                                                                            });

                                                                            $(document).on("click", "#closePop", function () {//disable both popup
                                                                                $('#block').hide();//hide deactive driver popup
                                                                                $('#activate').hide();//hide deactive driver popup
                                                                            });
                                                                            //--- Delete User
                                                                            $(document).on("click", "#whDel", function () {//enable disabled driver message popup
                                                                                var xhref = $(this).attr('href');//get driver Id
                                                                                //var status = $(this).attr('status');//get driver status
                                                                                //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=';//write new url to deactivate for popup
                                                                                //var url = 'activeDeactiveUser/'+status+'/'+userId
                                                                                $('#writeDeleteURL').attr("href", xhref);//write new generated url
                                                                                $('#delwarehouse').show();//show popup
                                                                            });

                                                                            $(document).on("click", "#closePopForDel", function () {//disable both popup
                                                                                $('#delwarehouse').hide();//hide deactive driver popup
                                                                                $('#ActivateDriver').hide();// hide activate driver popup
                                                                            });


                                                                        });



                                                                    </script>