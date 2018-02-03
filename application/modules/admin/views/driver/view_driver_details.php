<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<?php // echo "<pre>";print_r($driverInventory); exit;
    if($personalDetail['gender'] == '1' ){
        $status = "Male";
    }else if($personalDetail['gender'] == '2' ){
        $status = "Female";
    }else{
        $status = "Other";
    } 
    
?>
<div class="page-content-wrapper">

    
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">View Driver</h3>

        <div class="form-group padLeftZero">
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
                    <legend style="font-size:13px;margin-bottom: 5px;">Driver Details</legend>
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
                            <span class="form-control">Contact number   : <b><?php echo $personalDetail['contact_number']; ?></b></span>
                        </div>
                        <div class="col-md-5">
                            <span class="form-control">SSN : <b><?php echo $personalDetail['ssn']; ?></b></span>
                            <span class="form-control">Driving License Number : <b><?php echo $personalDetail['license_number']; ?></b></span>
                            <span class="form-control">Gender : <b><?php echo $status; ?></b></span>
                            <span class="form-control">Hourly Pay Rate : <b><?php echo $personalDetail['hourly_pay_rate']; ?></b></span>
                            <span class="form-control">Date of Birth : <b><?php echo $personalDetail['date_of_birth']; ?></b></span>
                        </div>
                        
                    </div>
                    
                </fieldset>
            </div>
        </div>
        <form action="<?php echo base_url(); ?>drivercompletedata" method="post">   
            <input type="hidden" name="driverId" value="<?php echo $this->uri->segment('2'); ?>" />
        <div class="form-group padLeftZero">
            <div class="col-md-12 padLeftZero">
                <div class="col-md-6">
                <fieldset class="customFieldset">
                    <legend style="font-size:13px;margin-bottom: 5px;">Vehicle Details</legend>
                    <div class="col-md-9">
                        <div>
                            <span class="form-control">Make       : <b><?php echo $personalDetail['first_name']; ?></b></span>
                            <span class="form-control">Model        : <b><?php echo $personalDetail['last_name']; ?></b></span>
                            <span class="form-control">Color         : <b><?php echo $personalDetail['email']; ?></b></span>
                            <span class="form-control">Registration Number   : <b><?php echo $personalDetail['contact_number']; ?></b></span>
                            <span class="form-control">Capacity   : <b><?php echo $personalDetail['contact_number']; ?></b></span>
                        </div>
                    </div>    
                    <div class="col-md-3">
                        <div class="box">
                            <img src="<?php echo base_url(); ?>assets/images/prof.jpg" width="100px" />
                        </div>
                    </div>    
                </fieldset>
                </div>
                <?php //print_r($allProduct); ?>
                <div class="col-md-6">
                <fieldset class="customFieldset">
                    <legend style="font-size:13px;margin-bottom: 5px;">Mandatory Inventory</legend>
                        <div class="portlet-body flip-scroll table-scrollable" >
                            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                <thead class="flip-content">
                                <tr>
                                    <td><b>S.No.</b></td>
                                    <td><b>Product</b></td>
                                    <td><b>Category</b></td>
                                    <td><b>Quantity</b></td>
                                    <td><b>Pickup</b></td>
                                </tr>
                                </thead>
                                <?php 
                                  if(count($mandatoryInventory)>0){
                                   //echo "<pre>"; print_r($mandatoryInventory);exit;
                                  foreach($mandatoryInventory as $index => $val){ ?>
                                <tr>
                                    <td><?php echo $index+1; ?></td>
                                    <td><?php echo $val['item_name'];  ?></td>
                                    <td><?php echo $val['cat_name'];  ?></td>
                                    <td><?php echo $val['quantity'];  ?></td>
                                    <td><?php echo $val['name'];  ?></td>
                                </tr>
                                  <?php }}else{ ?>
                                <tr>
                                    <td colspan="5"><p class="align_center">No data found</p></td>
                                    
                                </tr>
                                  <?php } ?>
                                <tr>
                                    <td colspan="4">
                                        
                                    </td>
                                    <td colspan="1">
                                        <a href="<?php echo base_url().'manageInventory/'.$this->uri->segment('2'); ?>" style="margin-left: 5px;" class="btn red reset p-xl-pad red " id="start_button" >Manage Inventory</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                </fieldset>    
            </div>
        </div>
        
        <div class="form-group padLeftZero">
            <div class="col-md-12 padLeftZero">
                <fieldset class="customFieldset col-md-12">
                    <legend style="font-size:13px;margin-bottom: 5px;">ORDERS</legend>
                        <div class="portlet-body flip-scroll table-scrollable" >
                            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                <thead class="flip-content">
                                <tr>
                                    <td><b>S.No.</b></td>
                                    <td><b>Order Id</b></td>
                                    <td><b>Customer Name</b></td>
                                    <td><b>Delivery Type</b></td>
                                    <td><b>Status</b></td>
                                    <td><b>Order Date & Time</b></td>
                                    <td><b>Expected Delivery Date & Time</b></td>
                                    <td><b>Actual Delivery Date & Time</b></td>
                                    <td><b>Total Delivery Delayed Time</b></td>
                                    <td><b>Address</b></td>
                                    <!--<td><b>Action</b></td>-->
                                </tr>
                                </thead>
                                <?php 
                                  
                                  if(count($driverOrders)>0){
//                                   echo "<pre>"; print_r($driverOrders);exit;
                                    foreach($driverOrders as $index => $val){ 
                                        if($val['order_status'] == '0'){
                                          $stat = "Un-Assigned";
                                        }else if($val['order_status'] == '1'){
                                            $stat = "Assigned";
                                        }else if($val['order_status'] == '2'){
                                            $stat = "In-Transit";
                                        }else if($val['order_status'] == '3'){
                                            $stat = "Hold";
                                        }else if($val['order_status'] == '4'){
                                            $stat = "Reached";
                                        }else if($val['order_status'] == '5'){
                                            $stat = "Returned";
                                        }else if($val['order_status'] == '6'){
                                            $stat = "Delievered";
                                        }else if($val['order_status'] == '7'){
                                            $stat = "Delayed";
                                        }else{
                                            $stat = "Not in the option";
                                        }  
                                        
                                        if($val['order_type'] == '0'){
                                            $orderType = "Scheduled";
                                        }else if($val['order_type'] == '1'){
                                            $orderType = "ASAP";
                                        }else if($val['order_type'] == '2'){
                                            $orderType = "Pre-Order";
                                        }else{
                                            $orderType = "Not in the option";
                                        } 
                                    ?>
                                <tr>
                                    <td><?php echo $index+1; ?></td>
                                    <td><?php echo $val['order_id'];  ?></td>
                                    <td><?php echo $val['first_name'].' '.$val['last_name'];  ?></td>
                                    <td><?php echo $stat;  ?></td>
                                    <td><?php echo $orderType;  ?></td>
                                    <td><?php echo $val['order_date'];  ?></td>
                                    <td>Date: <?php echo $val['delivered_date'];  ?> <br/>Time: <?php echo $val['delivery_time'];  ?></td>
                                    <td>Date: <?php echo $val['delivered_date'];  ?><br/> Time: <?php echo $val['delivered_time'];  ?></td>
                                    <td><?php echo $val['delivered_date'];  ?></td>
                                    <td><?php echo $val['drop_location'];  ?></td>
                                    <!--<td><a>View Details</a></td>-->
                                </tr>
                                    <?php }}else{ ?>
                                <tr>
                                    <td colspan="13"><p class="align_center">No data found</p></td>
                                    
                                </tr>
                                  <?php } ?>
                            </table>
                        </div>
                </fieldset>    
            </div>
        </div>
        
        <div class="form-group padLeftZero">
            <div class="col-md-12  padLeftZero">
                <fieldset class="customFieldset col-md-12">
                    <legend style="font-size:13px;margin-bottom: 5px;">SHIFT MANAGEMENT</legend>
                    <div class="col-md-12 top_15 padLeftZero">
                        <div class="col-md-2"> 
                            <span><b>Working Days</b></span>
                        </div>
                        <div class="col-md-6 checckbox_list" >
                            
                                 <label class="checkbox clearfix">
                                     <input id="mon" type="checkbox" name="mon" <?php if(isset($driverAvailability['mon']) && $driverAvailability['mon'] == '1'){echo "checked";} ?> >
                                   
                                <span class="box_line"> </span>
                            <span class="checkbox_txt">Mon</span> 
                        </label>
                                <label class="checkbox clearfix">
                                    <input id="tue" class="form-control" type="checkbox" name="tue" <?php if(isset($driverAvailability['tue']) && $driverAvailability['tue']=='1'){echo "checked";} ?>>
                                    
                               <span class="box_line"> </span>
                            <span class="checkbox_txt">Tue</span> 
                        </label>
                                 <label class="checkbox clearfix">
                                    <input id="wed" type="checkbox" name="wed" <?php if(isset($driverAvailability['wed']) && $driverAvailability['wed']=='1'){echo "checked";} ?>>
                                    
                                <span class="box_line"> </span>
                            <span class="checkbox_txt">Wed</span> 
                        </label>
                                 <label class="checkbox clearfix">
                                    <input id="thu" type="checkbox" name="thu" <?php if(isset($driverAvailability['thu']) && $driverAvailability['thu']=='1'){echo "checked";} ?>>
                                    
                                <span class="box_line"> </span>
                            <span class="checkbox_txt">Thu</span> 
                        </label>
                                 <label class="checkbox clearfix">
                                    <input id="fri" type="checkbox" name="fri" <?php if(isset($driverAvailability['fri']) && $driverAvailability['fri']=='1'){echo "checked";} ?>>
                                    
                                <span class="box_line"> </span>
                            <span class="checkbox_txt">Fri</span> 
                        </label>
                                 <label class="checkbox clearfix">
                                    <input id="sat" type="checkbox" name="sat" <?php if(isset($driverAvailability['sat']) && $driverAvailability['sat']=='1'){echo "checked";} ?>>
                                    
                                <span class="box_line"> </span>
                            <span class="checkbox_txt">Sat</span> 
                        </label>
                                 <label class="checkbox clearfix">
                                    <input id="sun" type="checkbox" name="sun" <?php if(isset($driverAvailability['sun']) && $driverAvailability['sun']=='1'){echo "checked";} ?>>
                                    
                                <span class="box_line"> </span>
                            <span class="checkbox_txt">Sun</span> 
                        </label>
                            
                        </div>
                        <div class="col-md-2"> 
                            <span><b>Starting Location</b></span>
                        </div>
                        <div class="col-md-2"> 
                            <span>Warehouse 1</span>
                        </div>
                    </div>
                    <div class="col-md-12 padLeftZero">
                        <div class="time-select col-md-12" style="margin: 10px 0">
                            <div class="row">
                            <span class="from-date col-md-4">
                                <input type="text" placeholder="00:00" name="fromTime" class="timepicker form-control" value="<?php echo $driverAvailability['from_time']; ?>">
                            </span>
                            <strong class="col-md-1 center">to</strong>
                            <span class="from-date col-md-4">
                                <input type="text" placeholder="00:00" name="toTime" class="timepicker2 form-control" value="<?php echo $driverAvailability['to_time']; ?>">
                            </span>
                            </div>
                        </div>
                    
                    </div><br/><br/>
                    
                    
                    
                    
                        <div class="portlet-body flip-scroll table-scrollable" >
                            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                <thead class="flip-content">
                                <tr>
                                    <td><b>S.No.</b></td>
                                    <td><b>Date</b></td>
                                    <td><b>Day</b></td>
                                    <td><b>Deliveries</b></td>
                                    <td><b>Shift Hours</b></td>
                                    <td><b>Distance Traveled (KM)</b></td>
                                    <td><b>Breaks Taken</b></td>
                                    <td><b>Action</b></td>
                                </tr>
                                </thead>
                                <?php 
                                  
                                  if(count($driverStatistics)>0){
//                                   echo "<pre>"; print_r($driverStatistics);exit;
                                    foreach($driverStatistics as $index => $val){
                                    ?>
                                <tr>
                                    <td><?php echo $index+1; ?></td>
                                    <td><?php echo date("d-m-Y",strtotime($val['date']));  ?></td>
                                    <td><?php echo date("D",strtotime($val['date']));  ?></td>
                                    <td><?php echo $val['total'];  ?></td>
                                    <td>
                                        <?php 
                                            $start = date_create($val['start_time']);
                                            $end = date_create($val['end_time']);

                                            echo $start->format('H:m').'<br>';
                                            echo $end->format('H:m').'<br>';

                                            $diff = date_diff($end,$start);
                                            echo $diff->format("%h Hours");
                                        ?>
                                    </td>
                                    <td><?php echo $val['distance_in_km'];  ?></td>
                                    <td><?php if($val['break_taken'] !=''){echo $val['break_taken']; }else{ echo "0"; }  ?></td>
                                    
                                    <td><a href="<?php echo base_url().'view-shift-detailed-page/'.$this->uri->segment('2').'/'.$val['date'] ?>">View Details</a></td>
                                </tr>
                                    <?php }}else{ ?>
                                <tr>
                                    <td colspan="13"><p class="align_center">No data found</p></td>
                                    
                                </tr>
                                  <?php } ?>
                            </table>
                        </div>
                </fieldset>    
            </div>
        </div>
        
        <div class="form-group padLeftZero">
            <div class="col-md-12 padLeftZero">
                <span><b>Weekly Statistics:</b></span>
                <span>Average Customer Rating</span>
                <span><b>*****</b></span>
                <span><a href="<?php echo base_url(); ?>customer-reviews/<?php echo $this->uri->segment('2'); ?>">View Reviews</a></span>
            </div>
                
        </div>
        <div class="form-group padLeftZero">
            <div class="col-md-12 padLeftZero">
                <div class="form-group">
                        <div class="col-md-3">
                            <span class="form-control">Total Distance: <b>
                                <?php 
                                if($driverWeekStatistics['distance_in_km']){
                                    echo round($driverWeekStatistics['distance_in_km'],2);
                                }else{ 
                                    echo"N/A";
                                } 
                                ?> km
                                </b>
                            </span>
                            <span class="form-control">Total Time :<b>
                                <?php
                                    if($driverWeekStatistics['total_shift_clock_time']){
                                        echo $driverWeekStatistics['total_shift_clock_time'];
                                    }else{ 
                                        echo"N/A";
                                    } 
                                ?>
                                </b>
                            </span>
                            <span class="form-control">Total Delivery :<b>
                                   <?php
                                    if($driverWeekStatistics['total_delivered_order']){
                                        echo $driverWeekStatistics['total_delivered_order'];
                                    }else{ 
                                        echo"N/A";
                                    } 
                                ?>
                                </b>
                            </span>
                            <span class="form-control">Payable   : <b>
                                <?php
                                if($driverWeekStatistics['total_payable_amount']){
                                    echo $driverWeekStatistics['total_payable_amount'];
                                }else{ 
                                    echo"N/A";
                                } 
                                ?>
                                </b>
                            </span>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <span class="form-control">Avg. time delivery       : <b>
                                    
                                    <?php
                                    if($driverWeekStatistics['total_shift_clock_time'] && $driverWeekStatistics['count_shift_clock_time']){
                                        echo average_time($driverWeekStatistics['total_shift_clock_time'], $driverWeekStatistics['count_shift_clock_time'], $rounding = 0);
                                    }else{ 
                                        echo"N/A";
                                    } 
                                ?>
                                </b>
                            </span>
                            <span class="form-control">Total breaks taken        : <b>
                                   <?php
                                if($driverWeekStatistics['total_break_taken']){
                                    echo $driverWeekStatistics['total_break_taken'];
                                }else{ 
                                    echo"N/A";
                                } 
                                ?>
                                </b>
                            </span>
                            <span class="form-control">Total breaks time         : <b>
                               <?php
                                if($driverWeekStatistics['total_break_time_taken']){
                                    echo $driverWeekStatistics['total_break_time_taken'];
                                }else{ 
                                    echo"N/A";
                                } 
                                ?>
                                </b>
                            </span>
                        </div>
                        <div class="col-md-5">
                            <span class="form-control">Avg. stop time : <b>
                                <?php
                                 if($driverWeekStatistics['total_break_time_taken'] && $driverWeekStatistics['total_break_taken']){
                                     echo average_time($driverWeekStatistics['total_break_time_taken'], $driverWeekStatistics['total_break_taken'], $rounding = 0);
                                }else{ 
                                    echo"N/A";
                                } 
                                ?>
                                </b></span>
                            <span class="form-control">% Deliver on time : <b>95%</b></span>
                            <span class="form-control">%Active time/Not on break : <b>92% | C Grade</b></span>
                            
                        </div>
                        
                    </div>
            </div>
            <div class="col-md-12 mar_top_10">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    
                    <span class="">
                        <?php if($personalDetail['is_blocked']=='0'){ ?>
                            <a href="<?php echo base_url().'block-driver/'.$this->uri->segment('2').'/'.$personalDetail['is_blocked']; ?>" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="" >Block</a>
                        <?php }else{ ?>
                            <a href="<?php echo base_url().'block-driver/'.$this->uri->segment('2').'/'.$personalDetail['is_blocked']; ?>" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="" >UnBlock</a>
                        <?php } ?>
                        
                        <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="" >Cancel</a>
                        <input type="submit" class="btn red reset p-xl-pad red" value="Save" />
                    </span>
                </div>
            </div>
            
        </div>
         
        
    </div>
            </form>   
</div>
</div>
<script>
$('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '0',
            maxTime: '11:00pm',
            startTime: '12:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        
        $('.timepicker2').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '0',
            maxTime: '11:00pm'
            startTime: '12:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
                </script>








