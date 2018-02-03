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
                                        <li><a href="#manageProducts" data-toggle="tab" >Manage Product Input</a></li>
                                        <li><a href="<?php echo base_url();?>manage-warehouses">Manage Warehouse</a></li> 
                                        <li ><a href="<?php echo base_url();?>restricted-areas">Restricted Area</a></li>
                                        <li><a href="<?php echo base_url(); ?>minimum-delivery-prices">Minimum Delivery Prices</a></li>
                                        <li class="active"><a href="<?php echo base_url(); ?>taxes">Taxes </a></li>
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
       
                                        <?php if ($this->session->userdata('SuccessMsg') != "") {  ?>
                                                    <div class="success alert-info toBeHidden custom-success" role="alert">
                                                        <?php echo $this->session->userdata('SuccessMsg');
                                                            $this->session->unset_userdata('SuccessMsg');
                                                        ?>
                                                    </div>
                                        <?php } ?>

                                        <?php if ($this->session->userdata('errorMsg') != "") { 
                                                ?>
                                                <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                                                    <?php echo $this->session->userdata('errorMsg');
                                                        $this->session->unset_userdata('errorMsg');
                                                    ?>
                                                </div>

                                        <?php } ?>
                                        
                                        <div class="row-fluid top-act" >  
                                            
                                            <form action='' id="searchData" method="post" >  
                                                <ol class="breadcrumb breadcrumb-arrow">
                                                    <li><a href="<?php echo base_url(); ?>admin-dashboard" ><i class="glyphicon glyphicon-home"></i></a></li>
                                                    <!-- <li ><a href="#">Add-Users</a></li> -->
                                                    <li><a href="<?php echo base_url(); ?>manage-products">Manage Taxex</a></li>
                                                    <li class="active"><span>Add Tax Details</span></li>
                                                </ol>
                                              <!-- <input type="text" class="search-custom" style="width:32%;" value="<?php echo $this->input->post('searchText')!= '' ? $this->input->post('searchText'):'';?>" name="searchText"  placeholder="Search by message">
                                                    <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="start_button" type="button" ><i class="fa fa-refresh"></i></a>
                                                    <button class="btn red reset p-xl-pad" id="submitform" type="submit" value="Submit"><i class="fa  fa-check"></i></button>
                                              -->
                                            </form>
                                        </div>



                                        <!-- BEGIN FORM-->
                                        <div class="row row_mrg" id="myData">
                                            <div class="col-md-12">
                                            <form class="form-horizontal" id="addTax" name="addTax" action=""  role="form" enctype='multipart/form-data' method="post">
                                                        <div class="col-md-4 ">
                                                            <h3>&nbsp;</h3>
                                                            <div class="form-group padLeftZero">
                                                                <label for="taxname">Tax Name </label>
                                                                <input type="text" id="taxname" name="tax_name" class="form-control" placeholder="Tax Name " style="width:90%;display: inline-block;" value="" >
                                                                <span><i id="fmailychk" class=""></i></span>
                                                                <span id="taxname-error" class="help-block hide"></span>
                                                            </div>
                                                            <div class="form-group padLeftZero">
                                                                <label for="taxtype">Tax Type </label>
                                                                <select name="tax_type" class="form-control">
                                                                    <option>-Select-</option>
                                                                    <option value="percent">Percent</option>
                                                                    <option value="amount">Amount</option>                                                                       
                                                                </select>
                                                                
                                                                <span><i id="fmailychk" class=""></i></span>
                                                                <span id="taxtype-error" class="help-block hide"></span>
                                                            </div>
                                                             <div class="form-group padLeftZero">
                                                                <label for="amtvalue">Amount value</label>
                                                                <input type="text" id="amt_value" name="amt_value" class="form-control" placeholder="Amount value" style="width:90%;display: inline-block;" value="" >
                                                                <span><i id="fmailychk" class=""></i></span>
                                                                <span id="amtvalue-error" class="help-block hide"></span>
                                                            </div>
                                                            <div class="form-group padLeftZero">
                                                                <button type="submit" class="btn green" name="addTaxBtn"><i class="fa fa-check"></i> Add Tax </button>
                                                                <a type="button" href="taxes" class="btn default "><i class="fa fa-remove"></i> Cancel</a> 
                                                            </div>

                                                        </div>
                                                        <div class="col-md-8 padLeftZero">
                                                            
                                                        </div>
                                                <!------------------content end---------------------------------->            
                                            </form>
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
<div class="modal fade in" id="block" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
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
<div class="modal fade in" id="activate" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
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
<div class="modal fade in" id="deluser" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
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

<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/add-product-family.js"  type="text/javascript" ></script>
<script>
jQuery(document).ready(function () {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features

    $(document).on("click","#blockUser",function() {//enable disabled driver message popup
        var userId = $(this).attr('userId');//get driver Id
        var status = $(this).attr('status');//get driver status
        //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php// echo $_GET['searchText']; ?>';//write new url to deactivate for popup
        var url = 'activeDeactiveUser/'+status+'/'+userId;
        $('#writeDeactivateURL').attr("href", url);//write new generated url
        $('#block').show();//show popup
    });

    $(document).on("click","#activeUser",function() {//enable activate driver message popup
        var userId = $(this).attr('userId');//get driver Id
        var status = $(this).attr('status');//get driver status
        //var url = 'activeDeactiveDriver/'+status+'/'+driverId+'?searchText=<?php //echo $_GET['searchText']; ?>'; //write new url to activate for popup
        var url = 'activeDeactiveUser/'+status+'/'+userId;
        $('#writeActivateURL').attr("href", url);//write new generated url
        $('#activate').show();//show popup
    });

    $(document).on("click","#closePop",function() {//disable both popup
        $('#block').hide();//hide deactive driver popup
        $('#activate').hide();//hide deactive driver popup
    });
    //--- Delete User
    $(document).on("click","#userDel",function() {//enable disabled driver message popup
        var xhref = $(this).attr('href');//get driver Id
        //var status = $(this).attr('status');//get driver status
        //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=';//write new url to deactivate for popup
        //var url = 'activeDeactiveUser/'+status+'/'+userId
        $('#writeDeleteURL').attr("href", xhref);//write new generated url
        $('#deluser').show();//show popup
    });

    $(document).on("click","#closePopForDel",function() {//disable both popup
        $('#deluser').hide();//hide deactive driver popup
        $('#ActivateDriver').hide();// hide activate driver popup
    });

    
});
</script>