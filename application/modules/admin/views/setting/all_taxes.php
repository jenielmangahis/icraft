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
                                <li><a href="manage-users">Manage Users</a></li>
                                <li><a href="<?php echo base_url(); ?>manage-products">Manage Product Input</a></li>
                                <li><a href="<?php echo base_url(); ?>manage-warehouses" >Manage Warehouse</a></li>
                                <li><a href="<?php echo base_url(); ?>restricted-areas">Restricted Area</a></li>
                                <li><a href="<?php echo base_url(); ?>minimum-delivery-prices" >Minimum Delivery Prices</a></li>
                                <li class="active"><a href="#taxes" data-toggle="tab">Taxes </a></li>
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
                                                <li class="active"><span>Manage Taxes</span></li>
                                            </ol>
                                          <!-- <input type="text" class="search-custom" style="width:32%;" value="<?php echo $this->input->post('searchText') != '' ? $this->input->post('searchText') : ''; ?>" name="searchText"  placeholder="Search by message">
                                                <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="start_button" type="button" ><i class="fa fa-refresh"></i></a>
                                                <button class="btn red reset p-xl-pad" id="submitform" type="submit" value="Submit"><i class="fa  fa-check"></i></button>
                                            -->
                                            <div class="pull-right">
                                                <a class="btn red reset p-xl-pad" href="<?php echo base_url(); ?>add-tax" id="add_tax"><i class="fa fa-plus" style="color:white;"></i> Add New Tax</a>
                                            </div>

                                        </form>
                                    </div>



                                    <div class="row row_mrg" id="myData">
                                        <div class="col-md-12">
                                            <div class="portlet-body flip-scroll table-scrollable">
                                               
                                                <table class="table table-bordered table-striped table-condensed table-hover" id="taxTable">
                                                    <thead class="flip-content">
                                                        <tr>
                                                            <th width="50px"> S No.</th>
                                                            <th style="width:250px;"> Tax Name </th>
                                                            <th style="width:250px;"> Tax Type </th>
                                                            <th style="width:250px;"> Amount/Percentage </th>
                                                            <th style="width:100px;"> Status </th>

                                                            <th class="numeric" style="width:100px;"> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    if (count($result) > 0) {

                                                        foreach ($result as $key => $list) {

                                                            $actBtnTxt = $list['is_active'] == '1' ? '<i class="fa fa-ban" aria-hidden="true" style="color:red;"></i>' : '<i class="fa fa-check" aria-hidden="true" style="color:#6565b2;"></i>';
                                                            $actTitle = $list['is_active'] == '1' ? 'Active' : 'Inactive';
                                                            $actBtnTitle = $list['is_active'] == '1' ? 'Inactivate' : 'Activate';
                                                            $actBtnId = $list['is_active'] == '1' ? 'taxDeactivator' : 'taxActivator';
                                                            ?>
                                                            <tr id="row">
                                                                <td> <?php echo $i + 1; ?></td>
                                                                <td class="numeric editable"><b title=""><?php echo ucfirst($list['tax_name']); ?></b></td>
                                                                <td class="numeric editable"><b title=""><?php echo $list['tax_type']; ?></b></td>
                                                                <td class="numeric editable"><b title=""><?php echo $list['amt_value']; ?></b></td>
                                                                <td class="numeric editable"><b title=""><?php echo $actTitle; ?></b></td>
                                                                <td class="action">
                                                                    <span class="no_wrap" ><button title="<?php echo $actBtnTitle; ?> this tax" id ="<?php echo $actBtnId; ?>" href="<?php echo base_url(); ?>change-tax-status/<?php echo $list['id']; ?>" class="btn btn-default btn-xs"> <?php echo $actBtnTxt; ?></button></span>
                                                                    <span class="no_wrap" ><a title="View/Edit" id ="viewItem" href="<?php echo base_url(); ?>view-tax/<?php echo $list['id']; ?>" class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" style="color:#036891;"></i> </a></span>
                                                                    <span class="no_wrap" ><button title="Delete" id ="taxDel" href="<?php echo base_url(); ?>delete-tax/<?php echo $list['id']; ?>" class="btn btn-default btn-xs"> <i class="fa fa-trash-o" style="color:red;"></i> </button></span>
                                                                </td>
                                                            </tr>                                
                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tbody>
                                                            <tr><td class="numeric editable" colspan="7" style="text-align: center"> <i><b>No Record Found</b></i> </td>
                                                            </tr>
                                                        </tbody>
                                                    <?php } ?>
                                                </table> 
                                                
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




<!-- Model for Activate User -->
<div class="modal fade in" id="activate" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="">
        <div class="modal-content">
            <div class="modal-header  bg bg-primary">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to change the status? </div>
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
<div class="modal fade in" id="deltax" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="">
        <div class="modal-content">
            <div class="modal-header  bg bg-primary">
                <a class="close" id="closePopForDel"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to delete the tax? </div>
            <div class="modal-footer">
                <a href="" id="writeDeleteURL"  class="btn green">Yes</a>
                <a class="btn red"  id="closePopForDel">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Model for Block User -->
<div class="modal fade in" id="block" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="">
        <div class="modal-content">
            <div class="modal-header  bg bg-primary">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to change the status? </div>
            <div class="modal-footer">
                <a href="" id="writeDeactivateURL"  class="btn green">Yes</a>
                <a class="btn red"  id="closePop">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>

    


    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features

        $(document).on("click", "#taxDeactivator", function () {//enable disabled driver message popup
            var xhref = $(this).attr('href');//get driver Id
            //var userId = $(this).attr('userId');//get driver Id
            //var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php // echo $_GET['searchText'];   ?>';//write new url to deactivate for popup

            $('#writeDeactivateURL').attr("href", xhref);//write new generated url
            $('#block').show();//show popup
        });

        $(document).on("click", "#taxActivator", function () {//enable activate driver message popup
            var xhref = $(this).attr('href');//get driver Id
            //var userId = $(this).attr('userId');//get driver Id
            //var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+driverId+'?searchText=<?php //echo $_GET['searchText'];   ?>'; //write new url to activate for popup
            //var url = 'change-family-status/'+status+'/'+userId;
            $('#writeActivateURL').attr("href", xhref);//write new generated url
            $('#activate').show();//show popup
        });

        $(document).on("click", "#closePop", function () {//disable both popup
            $('#block').hide();//hide deactive driver popup
            $('#activate').hide();//hide deactive driver popup
        });
        //--- Delete User
        $(document).on("click", "#taxDel", function () {//enable disabled driver message popup
            var xhref = $(this).attr('href');//get driver Id
            //var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=';//write new url to deactivate for popup
            //var url = 'activeDeactiveUser/'+status+'/'+userId
            $('#writeDeleteURL').attr("href", xhref);//write new generated url
            $('#deltax').show();//show popup
        });

        $(document).on("click", "#closePopForDel", function () {//disable both popup
            $('#deltax').hide();//hide deactive driver popup
            $('#ActivateDriver').hide();// hide activate driver popup
        });
    });
    
   


    
    
</script>