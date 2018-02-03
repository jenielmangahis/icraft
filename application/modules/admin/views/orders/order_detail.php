<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<style>
    .closeIcon {
        float: right;
        font-size: 18px;
        font-weight: 700;
        line-height: 1;
        color: black;
        text-shadow: 0 1px 0 red;
        filter: alpha(opacity=20);
        opacity: .9;
        width: 12px;
        height: 12px;
    }

    .dsplyInBk { 
        display: inline-block;
    }
    .orderPop{
        margin: 5px;
        padding: 8px;
        color:white;
        font-weight: 600;
    }
    .colorWhtBold {
        color: #ffffff;
        font-weight: 900;
    }
    .bgSuccesss { 
        background: #a5aa6d;
    }
    .bgWarning { 
        background: #de5f5f;
    }
    .bgTraffic { 
        background: #de5f5f;
    }
    .bgInfo { 
        background: #f62648;
        color:white;
    }
    .top-act .form-group {
        float: left;
    }
    .top-act .form-group input.btn, .top-act .clear-search button{
        margin-left: 4px;
    }
    .btn.d-grey{
        background-color:#e4e3e3;
    }
    td.action i.fa.fa-user {
        color: #fff;
    }
    .selectSearch{
        display : inline-block;
        width : 100px;
        padding: 0px 3px !important;
        font-weight:bold;
    }
    .paginate{     padding-left: 40px; }

    .modal-header{

    }
    input.datetime{
        display: inline-block;
        width: 100px;
        padding-left: 10px;
        border-radius : 0px !important  ;
    }

    .apadMarZero{
        padding:0px;
        margin:0px;
    }

    table tr th {
        background: none;
        width: 30%;
        color: dimgrey;
        padding: 9px 5px !important;
        vertical-align: top !important;;
    }
    table tr td {
        word-break: break-all;
        vertical-align: middle !important;
    }

    div > img {
        width: auto;
        height : auto;
        max-height: 100%;
        max-width: 100%;
    }
    /*----------------- Main Dashboard fields css----------------*/


    /* fontawesome */
    [class*="fontawesome-"]:before {
        font-family: 'FontAwesome', sans-serif;
    }
    .left {
        float: left;
    }
    .clear {
        clear: both;
    }

    .buysblock { background: rgba(133, 62, 226, 0.79);}
    .commentsblock {  background: rgb(38,168,226);}
    .colorParrot {  background: rgba(105, 191, 52, 0.8);}
    .colorPink {  background: rgba(216, 106, 106, 0.8);}

    .colorBlog {  background: rgba(0, 62, 115, 0.75);}
    .colorFlower {  background: rgba(206, 18, 113, 0.82);}
    .colorReddish {  background: rgba(243, 0, 0, 0.77);}
    .table-scrollable > .table-bordered {font-size: 12px;}
    .metroblock {
        width: 240px;
        min-height: 115px;
        padding: 0em 1em 1em 1em;
        color: #fff;
        font-family: 'Open Sans', sans-serif;
        margin-left: 4px;
        margin-bottom: 4px;
    }

    .metroblock h1, .metroblock h2, .metroblock .icon {
        font-weight: 300;
        margin: 0;
        padding: 0;
    }
    .metroblock h1, .metroblock .icon {
        font-size: 4em;
        text-align: center;
    }
    .metroblock .icon {
        margin-right: .2em;
    }
    .metroblock .icon i {
        font-size: 36px;
    }
    h2{font-size:16px;}


    .error {
        border:1px solid red !important;
        box-shadow:2px 3px 3px 3px black;
        margin: 5px;
    }
    .xdsoft_datetimepicker{
        z-index:99999999;
    }

    div.radio{
        height: 19px;
    }
    
    .modal-backdrop{
        z-index: 0 !important;
    }
</style>

<div class="page-content-wrapper" style="width:100% !important;">
    <div class="page-content" style="padding: 5px 7px 10px 20px; position:fixed;">

        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE HEADER-->

        <!-- END PAGE HEADER-->

        <div class="clearfix">
        </div>      

        <!-- BEGIN PAGE CONTENT-->
        <div class="row" style="margin-left:222px;">
            <div class="col-md-12 ">
                <div class="portlet-body">
                    <div class="panel with-nav-tabs panel-danger" style=" min-height: 552px;">

                        <div class="panel-body padMarZero">

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
                            <?php
                            // -- First Time User / Verified / Non Verified User Logic
                            // echo $is_first_time;die;
                            $is_verified = $orderinfo['order_status'] != '6' ? '' : '';
                            $is_first_time_user = $is_verified == '0' ? '<span class="orderPop bgSuccesss">First Time User</span>' : '';
                            ?>
                            <div class="row-fluid top-act" style="padding-bottom: 32px;" >  
                                <form action='' id="searchData" method="post" style="padding: 1px;" >  
                                    <ol class="breadcrumb breadcrumb-arrow dsplyInBk" style="margin-bottom: 0px;    padding: 0px 0px;">
                                        <li><a href="<?php echo base_url(); ?>admin-dashboard" ><i class="glyphicon glyphicon-home"></i></a></li>
                                        <li><a href="<?php echo base_url(); ?>orders">Orders</a></li>
                                        <!-- <li ><a href="#">Add-Users</a></li> -->
                                        <li class="active"><span>Order Detail</span></li>
                                    </ol>

<!-- <input type="text" class="search-custom" style="width:32%;" value="<?php echo $this->input->post('searchText') != '' ? $this->input->post('searchText') : ''; ?>" name="searchText"  placeholder="Search by message">
    <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="start_button" type="button" ><i class="fa fa-refresh"></i></a>
    <button class="btn red reset p-xl-pad" id="submitform" type="submit" value="Submit"><i class="fa  fa-check"></i></button>
                                    -->
                                    <div class="dsplyInBk" style="margin-left:100px;"><?php echo $is_verified . $is_first_time_user ?></div>
                                </form>
                            </div>



                            <!-- BEGIN FORM-->
                            <div class="row" id="myData" style="">
                                <div class="col-md-12">
                                    <span class="help-block hide colorshade" id="user_id-error" style="padding: 5px;color:white;"></span>
                                    <form class="form-horizontal" id="addRestrictedArea" name="addRestrictedArea" action=""  style="" role="form" enctype='multipart/form-data' method="post">                         
                                        <div class="row">
                                            <div class="col-sm-7 col-xs-12">
                                                <div class="form-group">

                                                    <fieldset class="" style=" width:95%;display: inline-block;   padding: 0px 5px 5px 5px;border: 1px solid #78beff;">
                                                        <legend style="font-size:14px;margin-bottom: 5px;color:#666525;font-weight:bold;">  Customer Details  </legend>
                                                        <!-- Image -->
                                                        <div class="dsplyInBk" style="width:20%;vertical-align: top;">
                                                            <img  class="" src="<?php echo base_url(); ?>assets/admin/images/no_hotlinking.png" />
                                                        </div>
                                                        <!-- Information -->
                                                        <div class="dsplyInBk" style="width:79%;">
                                                            <table style="width:100%;font-size:12px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Customer Name </th>
                                                                        <td>: <?php echo $orderinfo['user_fname'] ? $orderinfo['user_fname'] : ''; ?> <a class="btn btn-primary btn-xs pull-right" id="prescription-view-btn" data-toggle="modal" data-target="#prescription-model">View Prescription</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email</th>
                                                                        <td>: <?php echo $orderinfo['user_email'] ? $orderinfo['user_email'] : ''; ?>m </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Contact Number </th>
                                                                        <td>: <?php echo $orderinfo['user_contact'] ? $orderinfo['user_contact'] : ''; ?> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Address </th>
                                                                        <td>: 
                                                                            <?php
                                                                            $address = '';
                                                                            if ($orderinfo['city'] != '') {
                                                                                $address .= ucfirst($orderinfo['city']);
                                                                            }
                                                                            if ($orderinfo['state'] != '') {
                                                                                $address != '' ? $address .= ', ' : $address .= '';
                                                                                $address .= ucfirst($orderinfo['state']);
                                                                            }
                                                                            if ($orderinfo['country'] != '') {
                                                                                $address != '' ? $address .= ', ' : $address .= '';
                                                                                $address .= ucfirst($orderinfo['country']);
                                                                            }
                                                                            ?>
                                                                            <?php echo $address; ?> 
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>  
                                                    </fieldset>
                                                    <fieldset class="" style=" width:95%;display: inline-block; margin-top:10px;  padding: 0px 5px 5px 5px;border: 1px solid #78beff;min-height: 140px;">
                                                        <legend style="font-size:14px;margin-bottom: 5px;color:#666525;font-weight:bold;">  Driver Details </legend>
                                                        <!-- Image -->
                                                        <div class="dsplyInBk" style="width:20%;vertical-align: top;">
                                                            <?php if (isset($orderinfo['did']) && $orderinfo['did'] != '') { ?>
                                                                <img  class="" src="<?php echo base_url(); ?>assets/admin/images/no_hotlinking.png" />
                                                            <?php } ?>
                                                        </div>
                                                        <!-- Information -->
                                                        <div class="dsplyInBk" style="width:79%;">
                                                            <table style="width:100%;font-size:12px;">
                                                                <tbody>
                                                                    <?php if (isset($orderinfo['did']) && $orderinfo['did'] != '') { ?>
                                                                        <tr>
                                                                            <th>Driver Name </th>
                                                                            <td>: <?php echo ucfirst($orderinfo['driver_fname'] . " " . $orderinfo['driver_lname']); ?>  <a class="btn btn-primary btn-xs pull-right assignDriver"><?php echo $orderinfo['did'] ? 'Assign Another Driver' : 'Assign Driver' ?></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Email</th>
                                                                            <td>: <?php echo $orderinfo['driver_email'] ? $orderinfo['driver_email'] : ''; ?> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Contact Number </th>
                                                                            <td>: <?php echo $orderinfo['driver_contact'] ? $orderinfo['driver_contact'] : ''; ?> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Start Location </th>
                                                                            <td >: <?php echo $orderinfo['driver_sloc'] ? $orderinfo['driver_sloc'] : ''; ?> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Vehicle No </th>
                                                                            <td >: <?php echo $orderinfo['driver_vehicleno'] ? $orderinfo['driver_vehicleno'] : ''; ?> </td>
                                                                        </tr>
                                                                        <!--
                                                                        <tr>
                                                                            <th>Max. Capacity </th>
                                                                            <td >: <?php echo $orderinfo['driver_sloc'] ? $orderinfo['driver_sloc'] : ''; ?> </td>
                                                                        </tr>
                                                                        -->
                                                                    <?php } else { ?>
                                                                        <tr>
                                                                            <td><a class="btn btn-primary btn-xs pull-right assignDriver"><?php echo $orderinfo['did'] ? 'Assign Another Driver' : 'Assign Driver' ?></a></td>
                                                                        </tr>

                                                                    <?php } ?>

                                                                </tbody>
                                                            </table>
                                                        </div>                                                  
                                                    </fieldset>
                                                </div>

                                                <!-- Order Detail Display -->

                                                <div class="form-group">
                                                    <fieldset class="" style=" width:95%;display: inline-block; margin-top:10px;  padding: 0px 5px 5px 5px;border: 1px solid #78beff;min-height: 140px;">
                                                        <legend style="font-size:14px;margin-bottom: 5px;color:#666525;font-weight:bold;">  Order Details </legend>
                                                        <div class="dsplyInBk" style="width:79%;">
                                                            <table style="width:100%;font-size:12px;">
                                                                <tbody>
                                                                    <?php if (isset($orderinfo['did']) && $orderinfo['did'] != '') { ?>
                                                                        <tr>
                                                                            <th>Order Id </th>
                                                                            <td>: <?php echo $orderinfo['oid']; ?></td>
                                                                            <th>Status </th>
                                                                            <td>: <?php echo returnOrderStatusMenu($orderinfo['order_status']); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Order Date</th>
                                                                            <td>: <?php echo $orderinfo['created_at']; ?> </td>
                                                                            <th>Order Time</th>
                                                                            <td>: <?php echo $orderinfo['order_time']; ?> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Order Type </th>
                                                                            <td>: <?php
                                                                                if ($orderinfo['order_type'] == '0') {
                                                                                    echo "Scheduled";
                                                                                } else if ($orderinfo['order_type'] == '1') {
                                                                                    echo "ASAP";
                                                                                } else {
                                                                                    echo "Pre-Order";
                                                                                }
                                                                                ?> </td>
                                                                            <th>Pick up </th>
                                                                             <td>: <?php echo ($isPickup==TRUE)? "": "Warehouse" ; ?> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Delivery Date </th>
                                                                            <td>: <?php echo $orderinfo['delivery_date']; ?> </td>
                                                                            <th>Delivery Time </th>
                                                                            <td>: <?php echo $orderinfo['delivery_time']; ?> </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>  
                                                    </fieldset>
                                                </div>  
                                                <div class="form-group">
                                                    <fieldset class="" style=" width:95%;display: inline-block; margin-top:10px;  padding: 0px 5px 5px 5px;border: 1px solid #78beff;min-height: 140px;">
                                                        <legend style="font-size:14px;margin-bottom: 5px;color:#666525;font-weight:bold;">  Order Item Details </legend>
                                                        <div class="dsplyInBk" style="width:79%;">
                                                            <table style="width:100%;font-size:12px;">
                                                                <tbody>
                                                                <th>Sr No</th>
                                                                <th>Product Name</th>
                                                                <th>Category</th>
                                                                <th>Quantity</th>
                                                                <th>Price</th>
                                                                <th>Total ($)</th>
                                                                <?php
                                                                $cnt=0;
                                                                $totalPrice = 0;
                                                                foreach ($orderItemInfo as $itemInfo) {
                                                                     ?>
                                                                <tr>
                                                                     <td><?php echo ++$cnt ?></td>
                                                                    <td><?php echo $itemInfo['item_name']; ?></td>
                                                                    <td><?php echo $itemInfo['category_name']; ?></td>
                                                                     <td><?php echo $itemInfo['order_qty']; ?></td>
                                                                    <td><?php echo $itemInfo['price_eigth']; ?></td>
                                                                    <td><?php echo round($itemInfo['price_eigth']*$itemInfo['order_qty']); ?></td>
                                                                </tr>
                                                                     <?php
                                                                     $totalPrice = $totalPrice + round($itemInfo['price_eigth']*$itemInfo['order_qty']);
                                                                }
                                                                ?>                                                            
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                         <div class="form-group">
                                                        Order Amount : <?php echo $totalPrice; ?><br/>
                                                        Coupon Applied :   <br/>
                                                            Coupon Benefit : <br/>
                                                            Payable Amount : <br/>
                                                         </div>
                                                    
                                              

                                                <div class="form-group">
                                                    <button type="submit" class="btn green" name="adddMessageBtn"><i class="fa fa-check"></i> Update </button>
                                                    <a type="button" href="<?php echo base_url(); ?>restricted-areas" class="btn default "><i class="fa fa-remove"></i> Cancel</a> 
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-xs-12">
                                                <div class="form-group">
                                                    <!--map div-->
                                                    <div class="col-sm-12 apadMarZero">
                                                        <input id="searchInput" class="controls mapAutoComplete" type="text" placeholder="Enter a location">
                                                        <div id="map" style="min-height:370px;"></div>
                                                    </div>
                                                    <?php if ( isset($distance_maps) ): ?>
                                                    <div class="col-sm-12 mapDistanceInfo no-padding">
                                                        <div class="list row">
                                                            <div class="col-sm-12">
                                                                <span class="bold">Origin:</span>
                                                                <span class="text"><?php echo array_shift($distance_maps['origin_addresses']) ?></span>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <span class="bold">Destination:</span>
                                                                <span class="text"><?php echo array_shift($distance_maps['destination_addresses']) ?></span>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <span class="bold">Distance:</span>
                                                                <span class="text"><?php echo $distance_maps['rows'][0]['elements'][0]['distance']['text'] ?></span>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <span class="bold">Duration:</span>
                                                                <span class="text"><?php echo $distance_maps['rows'][0]['elements'][0]['duration']['text'] ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--content end-->            
                                    </form>
                                </div>
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

<!-- Model for Assign Driver -->
<div class="modal fade in" id="assignDriverModal" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="">
        <div class="modal-content" id="assignDriverData">

            <div class="modal-header bgSuccesss" style="padding: 10px;">
                <a class="close" id="closeAssignDriver"></a>
                <h4 class="modal-title colorWhtBold">Assign Driver </h4>
            </div>
            <div class="modal-body" style="padding-bottom:0px;">
                <form id="assignOrderFrom" name="assignOrderFrom" action="" method="post" >
                    <table class="table table-striped" style="margin-bottom:0px;">
                        <tr>
                            <td style="font-size: 14px; color:#de5f5f;" width='30%'>Select Driver</td>
                            <td id="dlist" colspan="2"></td>

                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#de5f5f;" width='30%'>Delivery Type</td>
                            <td id="" colspan="2">
                                <input type="radio" id="asap" name="dtype" class="dtype" value="asap" /><label for="asap">ASAP</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="dtype" id="scheduled" name="dtype" value="scheduled"  /><label for="scheduled">Scheduled</label>
                                <span id="dtype-error" class="help-block hide"></span>
                            </td>

                        </tr>
                        <tr id="schDate" class="hide">
                            <td style="font-size: 14px; color:#de5f5f;" width='30%'>Delivery Date</td>
                            <td colspan="2">
                                <div style="width:80%;display: inline-block;">
                                    Schedule Date : <input class="form-control dsplyInBk" style="width:65%;" type="text" name="schedule_date" id="manufactur_date" placeholder="Choose Date" /> 
                                    <span id="sdate-error" class="help-block hide"></span>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#de5f5f;" width='30%'>Delivery Time</td>
                            <td colspan="2">
                                <div>
                                    <input class="form-control dsplyInBk" style="width:52%;" type="text" name="from_time" id="from_time" placeholder="Delivery Time" /> 
                                </div>        
                                <span id="time-error" class="help-block hide"></span>
                            </td>                            
                        </tr>
                        <input type="hidden" name="pickup_location_latlng" id="pickup_location_latlng">
                        <tr>
                            <td style="font-size: 18px; color:#de5f5f;" width=''>&nbsp;</td>
                            <td width="30%">&nbsp;</td>
                            <td id="">
                                <input type="hidden" id="oid" name="oid" value="<?php echo $orderinfo['oid']; ?>" name="oid" />
                                <button type="button" id="assignOrderBtn" class="btn green">Assign this order</button>
                                <a class="btn red"  id="closeAssignDriver">No</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="prescription-model" role="dialog">
    <div class="modal-dialog">


        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Prescription</h4>
            </div>
            <div id="action_mssage"></div>
            <div class="modal-body">

                <p><i class="glyphicon glyphicon-user"></i> <?php if (isset($personalDetail['first_name']) && isset($personalDetail['last_name'])) {
                            echo $personalDetail['first_name'] . " " . $personalDetail['last_name'];
                        } else {
                            echo"N/A";
                        } ?></p>
                <p><i class="glyphicon glyphicon-envelope"></i> <?php if (isset($personalDetail['email'])) {
                            echo $personalDetail['email'];
                        } else {
                            echo"N/A";
                        } ?></p>
<?php if (isset($prescription) && sizeOf($prescription) > 0) { ?>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-4">
                                <div class="thumbnail"> 
                                    <img src="<?php if (isset($prescription['prescription_front_image'])) {
        echo$prescription['prescription_front_image'];
    } else {
        echo 'N/A';
    } ?>" alt="Prescription Img" style="width:100%">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="thumbnail"> 
                                    <img src="<?php if (isset($prescription['prescription_back_image'])) {
                    echo $prescription['prescription_back_image'];
                } else {
                    echo 'N/A';
                } ?>" alt="Prescription Img" style="width:100%">
                                </div>
                            </div>
                        </div>  
                    </div>
<?php } else { ?>
                    <p> No Record Found </p>
<?php } ?>
            </div>
            <?php if (isset($prescription) && sizeOf($prescription) > 0) { ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"  id="pre_reject_btn" prescription-id="<?php echo $prescription[id] ?>" href="javascript::void;">Reject</button>
              
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
                <div id="reject_reason_div" style="display: none;"><textarea id="reject_reason" rows="5" cols="75" ></textarea>
                    <button type="button" class="btn btn-default"  id="pre_reject_submit_btn" prescription-id="<?php echo $prescription[id] ?>" href="javascript::void;">Submit</button>
                    <button type="button" class="btn btn-default"  id="pre_reject_cancel_btn" prescription-id="<?php echo $prescription[id] ?>" href="javascript::void;">Cancel</button>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>

<script>

    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features

        $(document).on("click", "#blockUser", function () {//enable disabled driver message popup
            var userId = $(this).attr('userId');//get driver Id
            var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php // echo $_GET['searchText'];   ?>';//write new url to deactivate for popup
            var url = 'activeDeactiveUser/' + status + '/' + userId;
            $('#writeDeactivateURL').attr("href", url);//write new generated url
            $('#block').show();//show popup
        });

        $(document).on("click", "#activeUser", function () {//enable activate driver message popup
            var userId = $(this).attr('userId');//get driver Id
            var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+driverId+'?searchText=<?php //echo $_GET['searchText'];   ?>'; //write new url to activate for popup
            var url = 'activeDeactiveUser/' + status + '/' + userId;
            $('#writeActivateURL').attr("href", url);//write new generated url
            $('#activate').show();//show popup
        });

        $(document).on("click", "#closePop", function () {//disable both popup
            $('#block').hide();//hide deactive driver popup
            $('#activate').hide();//hide deactive driver popup
        });
        //--- Delete User
        $(document).on("click", "#userDel", function () {//enable disabled driver message popup
            var xhref = $(this).attr('href');//get driver Id
            //var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=';//write new url to deactivate for popup
            //var url = 'activeDeactiveUser/'+status+'/'+userId
            $('#writeDeleteURL').attr("href", xhref);//write new generated url
            $('#deluser').show();//show popup
        });

        $(document).on("click", "#closePopForDel", function () {//disable both popup
            $('#deluser').hide();//hide deactive driver popup
            $('#ActivateDriver').hide();// hide activate driver popup
        });

        //--- Date Picker Date Range & Time Range 
        //--- Start Date  
        jQuery('#date_timepicker_start').datetimepicker({
            format: 'Y-m-d',
            mask: '',
            onShow: function (ct) {
                this.setOptions({
                    maxDate: jQuery('#date_timepicker_end').val() ? jQuery('#date_timepicker_end').val() : false
                })
            },
            timepicker: false
        });
        //--- End Date
        jQuery('#date_timepicker_end').datetimepicker({
            format: 'Y-m-d',
            value: '<?php echo date('Y-m-d'); ?>',
            mask: '',
            onShow: function (ct) {
                this.setOptions({
                    minDate: jQuery('#date_timepicker_start').val() ? jQuery('#date_timepicker_start').val() : false,
                })
            },
            maxDate: '+1970/01/01',
            timepicker: false
        });

        jQuery('#manufactur_date').datetimepicker({
            format: 'Y-m-d',
            mask: '',
            timepicker: false,
        });


        jQuery('#from_time').datetimepicker({
            format: 'H:i',
            mask: '',
            onShow: function (ct) {
                this.setOptions({
                    minDate: jQuery('#to_time').val() ? jQuery('#to_time').val() : false,
                })
            },
            datepicker: false,
        });

        jQuery('#to_time').datetimepicker({
            format: 'H:i',
            mask: '',
            onShow: function (ct) {
                this.setOptions({
                    minDate: jQuery('#from_time').val() ? jQuery('#from_time').val() : false,
                })
            },
            datepicker: false,
        });


    });
    
    $("#pre_reject_submit_btn").on("click", function () {
        var prescriptionId = $('#pre_reject_submit_btn').attr('prescription-id');
        var reason = $('#reject_reason').val();
        //alert(reason);
        if (reason == '') {
            alert('Please fill the reason');
            return false;
        }
        $.ajax({
            type: 'post',
            url: "<?php echo base_url(); ?>reject_prescription",
            data: {prescription_Id: prescriptionId,
                reject_reason: reason
            },

            success: function (response) {
                var res = JSON.parse(response);
               console.log(res);
                var html = "";
                if (res.result == "1") {
                    html += '<span>' + res.message + '</span>';
                    $('#action_mssage').html(html);
                    setTimeout(function () {
                        $('#prescription-model').modal('hide');
                    }, 2000);
                } else {

                }
                //console.log(html);
                //$('#reffered_user_tbody111').html(html);  
            }
        });
    });
    
    $("#pre_reject_btn").on("click", function () {
        $('#reject_reason_div').show();
       // $('#pre_verify_btn').hide();
        $(this).hide();
    });

    $("#pre_reject_cancel_btn").on("click", function () {
        $('#reject_reason_div').hide();
        $("#pre_reject_btn").show();
        //$('#pre_verify_btn').show();
    });
    
    var disableOnDelivered = $('#orderSatus option:selected').val();
    if(disableOnDelivered==6){
        $('#orderSatus').prop('disabled', true);
    }
    
    
</script>
<script type="text/javascript">
    var driverLat = "<?php echo $orderinfo['driver_slat'] ?>";
    var driverLan = "<?php echo $orderinfo['driver_slang'] ?>";
    var driverAdd = "<?php echo $orderinfo['driver_saddr'] ?>";
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxPoiZ1JSZYu_NqSqIGFcRRFEQnzo3yBA&libraries=places&callback=initMap" async defer></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/order-detail.js"  type="text/javascript" ></script>