<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<?php
// echo "<pre>";print_r($personalDetail); 
if ($personalDetail['gender'] == '1') {
    $status = "Male";
} else if ($personalDetail['gender'] == '2') {
    $status = "Female";
} else if ($personalDetail['gender'] == '') {
    $status = "Not selected";
} else {
    $status = "Other";
}
//    echo "<pre>";
//    print_r($personalDetail);exit;
?>
<div class="page-content-wrapper">


    <div class="page-content" style="min-height:895px"> 
        <button  id="prescription-view-btn" type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#prescription-model">View Prescription</button>
        <h3 class="page-title page_mrg">View Customer Detail</h3>

        <div class="form-group margin-bottom-10">
            <div id="map"></div>
            <script>
                function initMap() {
                    var uluru = {lat: -25.363, lng: 131.044};
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 4,
                        center: uluru
                    });
                    var marker = new google.maps.Marker({
                        position: uluru,
                        map: map
                    });
                }
            </script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3QMmKo-HKVS6WZTwVUAIvrTL-Eq9W61c&callback=initMap">
            </script>

            <div class="col-md-12 padLeftZero">

                <fieldset class="customFieldset">

                    <legend style="font-size:13px;margin-bottom: 5px;"><h4>Personal Details</h4></legend>

                    <div class="form-group">
                        <div class="col-md-2 ">
                            <div class="box">

                                <img src="<?php echo base_url(); ?>assets/images/prof.jpg" width="150px" />

                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-md-5">
                            <span class="form-control">First name       : <b><?php echo $personalDetail['first_name']; ?></b></span>
                            <span class="form-control">Last name        : <b><?php echo $personalDetail['last_name']; ?></b></span>
                            <span class="form-control">Email Id         : <b><?php echo $personalDetail['email']; ?></b></span>
                            <span class="form-control">Contact number   : <b><?php echo $personalDetail['phone_number']; ?></b></span>
                        </div>
                        <div class="col-md-5">
                            <!--<span class="form-control">SSN : <b><?php // echo $personalDetail['ssn']; ?></b></span>-->
                            <span class="form-control">Gender : <b><?php echo $status; ?></b></span>
                            <span class="form-control">Date of Birth : <b><?php echo date("d-m-Y", strtotime($personalDetail['dob'])); ?></b></span>
                            <span class="form-control">Date of Birth : <b><?php echo $personalDetail['address']; ?></b></span>
                            <span class="form-control">Join Date        : <b><?php echo date("d-m-Y", strtotime($personalDetail['created_at'])); ?></b></span>

                        </div>

                    </div>

                </fieldset>
            </div>
        </div>

        <form action="<?php echo base_url(); ?>" method="post">   
            <input type="hidden" name="driverId" value="<?php echo $this->uri->segment('2'); ?>" />
            <div class="form-group  mar_top_10">
                <div class="col-md-12 ">
                    <div class="col-md-12">
                        <fieldset class="customFieldset">
                            <legend style="font-size:13px;margin-bottom: 5px;"><h4>Orders</h4></legend>
                            <div class="portlet-body flip-scroll table-scrollable" >
                                <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                    <thead class="flip-content">
                                        <tr>
                                            <td><b>S.No.</b></td>
                                            <td><b>OrderId</b></td>
                                            <td><b>Date & Time</b></td>
                                            <td><b>Location</b></td>
                                            <td><b>Delivery Type</b></td>
                                            <td><b>Delivery Date & Time</b></td>
                                            <td><b>Status</b></td>
                                            <td><b>Driver</b></td>
                                            <td><b>Amount</b></td>
                                            <td><b>Action</b></td>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (count($personalOrdersDetail) > 0) {
                                        foreach ($personalOrdersDetail as $index => $val) {
                                            ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo $val['order_id']; ?></td>
                                                <td><?php echo $val['created_at']; ?></td>
                                                <td><?php echo $val['drop_location']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($val['order_type'] == '0') {
                                                        echo "scheduled";
                                                    } else if ($val['order_type'] == '1') {
                                                        echo "asap";
                                                    } else {
                                                        echo "Pre-Order";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo date(date('d-m-Y', strtotime($val['delivered_date']))) . ' <br/> ' . $val['delivery_time'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($val['order_status'] == '0') {
                                                        echo "Un Signed";
                                                    } else if ($val['order_status'] == '1') {
                                                        echo "Assigned";
                                                    } else if ($val['order_status'] == '2') {
                                                        echo "In-Transit/Start";
                                                    } else if ($val['order_status'] == '3') {
                                                        echo "Hold";
                                                    } else if ($val['order_status'] == '4') {
                                                        echo "Reached";
                                                    } else if ($val['order_status'] == '5') {
                                                        echo "Returned";
                                                    } else if ($val['order_status'] == '6') {
                                                        echo "Delivered";
                                                    } else if ($val['order_status'] == '7') {
                                                        echo "Delayed";
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                ?>
                                                </td>-->
                                                <td><a href="#"><?php echo $val['driverFirstName'] . ' ' . $val['driverLastName']; ?></a></td>
                                                <td><?php echo $val['amount']; ?></td>
                                                <td><a href="<?php echo base_url() . 'order-detail/' . $val['order_id'] ?>">View Detail</a></td>
                                            </tr>
                                        <?php }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="10"><p class="align_center">No data found</p></td>

                                        </tr>
<?php } ?>

                                </table>
                            </div>
                        </fieldset>    
                    </div>
                </div>

                <!--        <div class="form-group padLeftZero">
                            <div class="col-md-12 padLeftZero">
                                <fieldset class="customFieldset col-md-12">
                                    <legend style="font-size:13px;margin-bottom: 5px;"><h4>Most ordered items</h4></legend>
                                        <div class="portlet-body flip-scroll table-scrollable" >
                                            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                                <thead class="flip-content">
                                                <tr>
                                                    <td><b>S.No.</b></td>
                                                    <td><b>Name & Description</b></td>
                                                    <td><b>Category</b></td>
                                                    <td><b>Total Units</b></td>
                                                    <td><b>Total Amount ($)</b></td>
                                                    <td><b>Action</b></td>
                                                </tr>
                                                </thead>
                <?php
                if (count($driverOrders) > 0) {
//                                   echo "<pre>"; print_r($driverOrders);exit;
                    foreach ($driverOrders as $index => $val) {
                        if ($val['order_status'] == '0') {
                            $stat = "Un-Assigned";
                        } else if ($val['order_status'] == '1') {
                            $stat = "Assigned";
                        } else if ($val['order_status'] == '2') {
                            $stat = "In-Transit";
                        } else if ($val['order_status'] == '3') {
                            $stat = "Hold";
                        } else if ($val['order_status'] == '4') {
                            $stat = "Reached";
                        } else if ($val['order_status'] == '5') {
                            $stat = "Returned";
                        } else if ($val['order_status'] == '6') {
                            $stat = "Delievered";
                        } else if ($val['order_status'] == '7') {
                            $stat = "Delayed";
                        } else {
                            $stat = "Not in the option";
                        }

                        if ($val['order_type'] == '0') {
                            $orderType = "Scheduled";
                        } else if ($val['order_type'] == '1') {
                            $orderType = "ASAP";
                        } else if ($val['order_type'] == '2') {
                            $orderType = "Pre-Order";
                        } else {
                            $orderType = "Not in the option";
                        }
                        ?>
                                                                <tr>
                                                                    <td><?php echo $index + 1; ?></td>
                                                                    <td><?php echo $val['order_id']; ?></td>
                                                                    <td><?php echo $val['first_name'] . ' ' . $val['last_name']; ?></td>
                                                                    <td><?php echo $stat; ?></td>
                                                                    <td><?php echo $orderType; ?></td>
                                                                    <td><?php echo $val['order_date']; ?></td>
                                                                    <td>Date: <?php echo $val['delivered_date']; ?> <br/>Time: <?php echo $val['delivery_time']; ?></td>
                                                                    <td>Date: <?php echo $val['delivered_date']; ?><br/> Time: <?php echo $val['delivered_time']; ?></td>
                                                                    <td><?php echo $val['delivered_date']; ?></td>
                                                                    <td><?php echo $val['drop_location']; ?></td>
                                                                    <td><a>View Details</a></td>
                                                                </tr>
                    <?php }
                } else {
                    ?>
                                                        <tr>
                                                            <td colspan="6"><p class="align_center">No data found</p></td>
                                                            
                                                        </tr>
<?php } ?>
                                            </table>
                                        </div>
                                </fieldset>    
                            </div>
                        </div>-->

                <div class="form-group padLeftZero">
                    <div class="col-md-12 padLeftZero">
                        <div class="form-group">
                            <div class="col-md-6">
                                <span class="form-control">Total Order made      : <b><?php echo count($personalOrdersDetail); ?></b></span>
                                <span class="form-control">Total Amount spent    : 
                                    <b>
                                        <?php
                                        $amount = 0;
                                        foreach ($personalOrdersDetail as $paid) {
                                            $amount += $paid['amount'];
                                        }
                                        echo $amount;
                                        ?>
                                    </b>
                                </span>
                                <span class="form-control">Reward point  : <b><?php echo $rewardPoint['total_point']; ?></b></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 " style="margin-top: 15px;">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">

                            <span class="">
<!--                                <a href="<?php echo base_url() . 'block-driver/' . $this->uri->segment('2') . '/' . $personalDetail['is_blocked']; ?>" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="" >View Redeemed Rewards</a>-->
                                <a customer-id="<?php echo $this->uri->segment('2'); ?>" href="javascript::void;" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="view_redeem_reward_btn"  data-toggle="modal" data-target="#redeem-reward-modal">View Redeemed Rewards</a>
                                <a customer-id="<?php echo $this->uri->segment('2'); ?>" href="javascript:;" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="view_reffered_users_btn" data-toggle="modal" data-target="#referred-user-modal">View Reffered Users</a>
                                <a customer-id="<?php echo $this->uri->segment('2'); ?>" href="javascript::void;" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="btn_send_coupon" data-toggle="modal" data-target="#send-coupon-modal">Send Coupon</a>
                                <a href="<?php echo base_url(); ?>customers" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="" >Close</a>
                                <a href="<?php echo base_url(); ?>" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="" >Save</a>

                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </form>   
    </div>
</div>

<!--Redeem Reward Modal -->
<div id="redeem-reward-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Redeem Rewards</h4>
            </div>
            <div class="modal-body">                        
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Date</th>
                            <th>Action</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody id="redeem_reward_tbody">

                    </tbody>
                </table>
                <p><span>Total Point</span> <span id="redeem_reward_totalpoint">0</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!--Redeem Reward Modal -->
<div id="send-coupon-modal" class="modal fade" role="dialog" style="display: none;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Coupons</h4>
            </div>
            <div class="modal-body" >                        
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Coupon Code</th>
                            <th>Sent On</th>
                            <th>Expiry</th>
                            <th>Used On</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="send_coupon_tbody">
                        <?php
                        if (count($couponDetails) == 0) {
                            ?>
                            <tr><td colspan="6">No Coupons in account</td> </tr>
                            <?php
                        } else {
                            $couponCnt = 0;
                            $status = '';
                            foreach ($couponDetails as $coupon) {

                                if (!empty($coupon['redeemed_on'])) {
                                    $status = 'Used';
                                } else if ($coupon['redeemed_on'] == NULL && strtotime($coupon['expiry']) < strtotime(date('Y-m-d'))) {
                                    $status = 'UnUsed';
                                } else {
                                    $status = 'Expired';
                                }
                                ?>
                            <tr>
                                <td><?php echo ++$couponCnt ?> </td>
                                <td><?php echo $coupon['coupon_code'] ?></td>
                                <td><?php echo $coupon['received_on'] ?></td>
                                <td><?php echo $coupon['expiry'] ?></td>
                                <td><?php echo $coupon['redeemed_on'] ?></td>
                                <td><?php echo $status ?></td>
                            </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <p><span>Send Coupon</span> <span id="send_coupon_select"><?php echo returnCouponDropDown(); ?></span> <button type="button" class="btn btn-default"  id="coupon_submit_btn"  href="javascript::void;">Submit</button></p>
            </div>
            <div id="coupon_action_mssage"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!--Redeem Reward Modal -->
<div id="referred-user-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Referral Users</h4>
            </div>
            <div class="modal-body"
                 <p> <span id="referral_code"></span></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Email</th>
                            <th>Join Date</th>
                            <th>Points Earned</th>
                        </tr>
                    </thead>
                    <tbody id="reffered_user_tbody111">

                    </tbody>
                </table>               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Prescription Modal -->
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
                    echo$prescription['prescription_back_image'];
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
                
<?php if ($prescription['is_approved'] == '0') { ?>
                    <button type="button" class="btn btn-default"  id="pre_verify_btn" prescription-id="<?php echo $prescription[id] ?>" href="javascript::void;" >Verify</button>
<?php } ?>
                <button type="button" class="btn btn-default"  id="pre_reject_btn" prescription-id="<?php echo $prescription[id] ?>" href="javascript::void;">Reject</button>
                <div id="reject_reason_div" style="display: none;"><textarea id="reject_reason" rows="5" cols="75" ></textarea>
                    <button type="button" class="btn btn-default"  id="pre_reject_submit_btn" prescription-id="<?php echo $prescription[id] ?>" href="javascript::void;">Submit</button>
                    <button type="button" class="btn btn-default"  id="pre_reject_cancel_btn" prescription-id="<?php echo $prescription[id] ?>" href="javascript::void;">Cancel</button>
                </div>
            </div>
             <?php } ?>
        </div>
    </div>
</div>




<script>
    $('.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        minTime: '0',
        maxTime: '11:00pm',
        defaultTime: '<?php echo isset($from) ? $from : "00:00am"; ?>',
        startTime: '12:00am',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $('.timepicker2').timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        minTime: '0',
        maxTime: '11:00pm',
        defaultTime: '<?php echo isset($to) ? $to : "00:00am"; ?>',
        startTime: '12:00am',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    /********************* GET REDEEM REWARD *****************************/
    $("#view_redeem_reward_btn").on("click", function () {
        var customerId = $('#view_redeem_reward_btn').attr('customer-id');
        $.ajax({
            url: "<?php echo base_url(); ?>customer-redeem-reward/" + customerId,
            success: function (response) {
                var res = JSON.parse(response);
                var html = "";
                var totalPoint = 0;
                if (res.result == "1") {
                    for (i in res.data) {
                        if (res.data[i].point_source == "0") {
                            var action = "Share on Facebook";
                        } else if (res.data[i].point_source == "1") {
                            var action = "Share on Twitter";
                        } else if (res.data[i].point_source == "2") {
                            var action = "Share on Instagram";
                        } else if (res.data[i].point_source == "3") {
                            var action = "by refferal code";
                        }

                        if (res.data[i].transaction_type == "1") {
                            var debit_credit = "+";
                            totalPoint = parseInt(totalPoint) + parseInt(res.data[i].point);
                        } else if (res.data[i].transaction_type == "2") {
                            totalPoint = parseInt(totalPoint) - parseInt(res.data[i].point);
                            var debit_credit = "-";
                        }

                        html += '<tr><td>' + (parseInt(i) + 1) + '</td><td>' + res.data[i].created_at + '</td><td>' + action + '</td><td>' + debit_credit + " " + res.data[i].point + ' Point</td></tr>';
                    }
                } else {
                    html += '<tr><td  colspan="4">' + res.message + '</td></tr>';
                }
                $('#redeem_reward_tbody').html(html);
                $('#redeem_reward_totalpoint').html(totalPoint);

            }
        });
    });

    $("#view_reffered_users_btn").on("click", function () {
        var customerId = $('#view_reffered_users_btn').attr('customer-id');

        $.ajax({
            url: "<?php echo base_url(); ?>customer-referred_user/" + customerId,
            success: function (response) {
                var res = JSON.parse(response);
                console.log(res);
                var html = "";
                if (res.result == "1") {
                    for (i in res.data) {
                        html += '<tr><td>' + (parseInt(i) + 1) + '</td><td>' + res.data[i].email + '</td><td>' + res.data[i].join_date + '</td><td>' + res.data[i].point_earned + ' Point</td></tr>';
                    }
                } else {
                    html += '<tr><td  colspan="4">' + res.message + '</td></tr>';
                }
                console.log(html);
                $('#reffered_user_tbody111').html(html);
            }
        });
    });

    $("#pre_verify_btn").on("click", function () {
        var prescriptionId = $('#pre_verify_btn').attr('prescription-id');

        $.ajax({
            url: "<?php echo base_url(); ?>verify_prescription/" + prescriptionId,
            success: function (response) {
                var res = JSON.parse(response);
                console.log(res);
                var html = "";
                if (res.result == "1") {
                    html += '<span class="form-control">' + res.message + '</span>';
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
        $('#pre_verify_btn').hide();
        $(this).hide();
    });

    $("#pre_reject_cancel_btn").on("click", function () {
        $('#reject_reason_div').hide();
        $("#pre_reject_btn").show();
        $('#pre_verify_btn').show();
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

    $("#btn_send_coupon").on("click", function () {

        $("#send-coupon-modal").show();

    });

    $("#coupon_submit_btn").on("click", function () {

        var customerId = $('#btn_send_coupon').attr('customer-id');
        var coupanId = $("#coupons option:selected").val();
        console.log(coupanId);
        if (coupanId == -1) {
            alert('Please select a coupon');
            $("#coupons option:selected").focus();
        }
        
        $.ajax({
            type: 'post',
            url: "<?php echo base_url();?>assign_coupon_to_user",
            data:{ coupon_id:coupanId,
                    user_id :customerId
                },
        
            success: function(response){ 
                var res = JSON.parse(response);
               // console.log(res);
                var html = "";
                if(res.result == "1"){
                  html += '<span>'+res.message+'</span>';
                    $('#coupon_action_mssage').html(html);    
                    setTimeout(function() {$('#send-coupon-modal').modal('hide');}, 2000);
                }else{
                   
                }
                //console.log(html);
                //$('#reffered_user_tbody111').html(html);  
            }
        });

    })

</script>








