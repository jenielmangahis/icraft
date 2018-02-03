<?php include('templates/header.php')  ?>
<script src="<?php echo base_url() ?>assets/js/dcalendar.picker.js"></script>
<link href="<?php echo base_url() ?>assets/css/dcalendar.picker.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
    .ap_save_btn {
    background: #8381ef;
    color: #fff;
    padding: 19px 88px;
    font-size: 20px;
    text-transform: uppercase;
    font-weight: bold;
    margin: 0 auto;
    display: table;
    letter-spacing: 2px;
    box-shadow: 0 0 61px 6px rgba(131, 129, 239, 0.61);
    border-radius: 42px;
}
</style>
<section class="main-body">
        <div class="ground-elements">
            <a href="<?php echo base_url() ?>appointments" class="action-back"><span class="icon-back"></span><span class="redi-txt">Back</span></a>
            <?php if($appointment_id != '' && $room != '') {?>
                <div class="profile-sec">
                    <iframe height="300" width="200" src='<?= $call_url?>'></iframe>
                </div>
            <?php }?>
            <div class="profile-sec">
                <div class="dp">
                    <?php if($client['profile_pic']){ ?>
                        <img src="<?php echo $client['profile_pic']; ?>" />      
                    <?php }else{ ?>
                        <img src="<?php echo base_url(); ?>assets/images/prof.jpg" />      
                    <?php } ?>
                           
                </div>
                
                <div class="pro-details">
                    <div class="pro-header">
                        <span class="cust-name"><?php echo ucfirst($client['first_name'].' '.$client['last_name']);  ?></span>
                        <span class="cust-id"><span class="icon-mail"><span class="id-txt"><?php echo $client['email'];  ?></span></span></span>
                        <div class="row">
                            <div class="ano right-an">
                                <label>Date of Birth</label>
                                <p><?php echo date("d-m-Y",strtotime($client['dob']));  ?></p>
                            </div>
                            <div class="ano right-an">
                                <label>Gender</label>
                                <p>
                                    <?php 
                                        if($client['gender'] == '1'){
                                            echo "Male";
                                        }else if($client['gender'] == '2'){
                                            echo "Female";
                                        }else{
                                            echo "Other";
                                        }   
                                    ?>
                                </p>
                            </div>

                            <div class="ano right-an">
                                <label>Appointment Date</label>
                                <p><?php echo date("d-m-Y",strtotime($client['appointment_date']));  ?></p>
                            </div>
                            <div class="ano right-an">
                                <label>Appointment Time</label>
                                <p><?php echo $client['appointment_time'];  ?></p>
                            </div><div class="ano right-an">
                                <label>Appointment Status</label>
                                <p>Confirmed</p>
                            </div>
                            <div class="ano right-an">
                                <label>Consultation For</label>
                                <p><?php echo $client['consultation_for'];  ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background: #fff;-webkit-box-shadow: 0 0px 51px 6px rgb(230, 230, 230);width: 98%;float: left;margin: 57px 1.5666666666%;padding-left: 50px;padding-right: 50px;padding-top: 50px;padding-bottom: 50px;-moz-box-shadow: 0 0px 51px 6px rgb(230, 230, 230);-ms-box-shadow: 0 0px 51px 6px rgb(230, 230, 230);-o-box-shadow: 0 0px 51px 6px rgb(230, 230, 230);">

                <div class="info-box">
                    <span class="left">
                        <i class="icon-info"></i><label>
                            <h3>Recommendation</h3>
                        </label>
                    </span>

                </div>
                <form action="<?php echo base_url(); ?>updatePrescriptionRecommendations" method="POST" >
                    <div class="note-u-recommend">
                        <input type="hidden" name="prescription_id" value="<?php echo $client['prescription_id']; ?>">    
                        <textarea placeholder="Write your recommendation here...." name="recommendations"><?php echo $client['recommendations']; ?></textarea>
                    </div>
                    <br style="clear: both;">              
                   
                    
                    <input type="hidden" name="appointmentId" value="<?php echo  $client['appointment_id']; ?>" />
                    <input type="hidden" name="userId" value="<?php echo $this->uri->segment('2'); ?>" />
                    <input type="submit" id="" class="ap_save_btn" value="Save"  />
                    
                    
                    </div>
                    
                </form>
           
          
            </div>

        </div>
    </section>
    <iframe name="videoFrame"></iframe>
    <div class="insta-pop" data-pop="re-appoint">
        <div class="inner-insta-pop">
        <h1>Reschedule Appointment</h1>
        <label class="pop-lab bob">Current Details</label>
        <ul class="pog details">
            <li>
                <h1><?php echo date("d-m-Y",strtotime($client['appointment_date']));  ?></h1>
                <p>Date</p>
            </li>
            <li>
                <h1><?php echo $client['appointment_time'];  ?></h1>
                <p>Time</p>
            </li>
            <li>
                <h1>
                    <?php 
                        if($client['status'] == '0'){ 
                            echo "Pending";                        
                        }elseif($client['status'] == '1'){
                            echo "Confirm";
                        }elseif($client['status'] == '2'){
                            echo "Re-schedule";
                        }elseif($client['status'] == '3'){
                            echo "Cancel";
                        }else{
                            
                        }
                    ?>
                    
                </h1>
                <p>Status</p>
            </li>
        
        </ul>
        <label class="pop-lab">Reschedule appointment</label>
        <ul class="pog reschedule">
            <li>
                <div class="datepiker">
                    <input class="form-control pickerDate" type="text" placeholder="MM/DD/YY" id="demo" >
                    <span class="btn-bk cal"></span>
                </div>
            </li>
            <li>
                <div class="datepiker from-date">
                    <input class="timepicker" type="text" placeholder="HH:MM" id="pickerTime" value="<?php echo $client['appointment_time'];  ?>">
                    <span class="btn-bk cal"></span>
                </div>
                
            </li>
        </ul>
        <label class="pop-lab">Resaon For reschedule the appointment</label>
        <textarea placeholder="Type here...." id="reschedulePopText"></textarea>
        <div class="btn-bg-grad">
            
            <a href="#" id="reschedulePop" data-attribute="cancel" class="btn-insta">Re-Schedule</a>
            <div class="alert alert-Success"  style="display:none">      
                Appointment cancelled successfully
            </div>
        </div>
        <ul>
            <li>
                <p></p>
            </li>
        </ul>
        <span class="close close_model"><i class="icon-cross"></i></span>
    </div>
        </div>
    <div class="insta-pop" data-pop="cancel">
        <h1>Cancel Appointment</h1>
        <label class="pop-lab">Resaon For reschedule the appointment</label>
        <textarea placeholder="Type here...." id="cancelReasonText"></textarea>
        <div class="btn-bg-grad">
            <a href="#" id="cancelAppointment" data-attribute="cancel" class="btn-insta">Cancel</a>
                
                
        </div>
        <div class="alert alert-Success"  style="display:none">      
            Appointment rescheduled successfully
        </div>
        <span class="close close_model"><i class="icon-cross"></i></span>
    </div>

    
<?php include('templates/footer.php')  ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
    $('#demo').dcalendarpicker({'format': 'yyyy-m-d'});
    //$('#calendar-demo').dcalendar();
    
    $('#confirmAppointment').click(function(){
        
       $.post( 
        "<?php echo base_url(); ?>confirmAppointment",{user_id:'<?php echo $client['id']; ?>'},
        function(data) {
           
           if(data ==1){
               $('#confirmAppointment').hide();
               $('#confirmedAppointmentStatus').show();
               $('#cancelAppointmentStatus').hide();
               $('#cancelAppointmentPop').show();
               

           }
        }
      );
    });
    
    $('#cancelAppointment').click(function(){
       var cancel_reason = $('#cancelReasonText').val(); 
       $.post( 
        "<?php echo base_url(); ?>cancelAppointment",{user_id:'<?php echo $client['id']; ?>',cancel_reason:cancel_reason},
        function(data) {
//            alert(data);return false;
            if(data ==1){
               $('#cancelAppointmentPop').hide();
               $('#cancelAppointmentStatus').show();
               $('#confirmedAppointmentStatus').hide();
               $('#confirmAppointment').show();               
              
                $('.alert-Success').show();
               setTimeout(function () {//remove pop up after 1.5 seconds
                    $('body').removeClass('overlaypop');
                    $('.insta-pop').removeClass('opend-pop');
                    $('.insta-pop').fadeOut();
                    $('.alert-Success').hide();
                }, 1500);
                
            }
           
        }
      );
    });
    
    
    $('#reschedulePop').click(function(){
       var reschedule_reason = $('#reschedulePopText').val(); 
       var timepicker = $('.timepicker').val(); 
       var pickerDate = $('.pickerDate').val(); 

       $.post( 
        "<?php echo base_url(); ?>rescheduleAppointment",{user_id:'<?php echo $client['id']; ?>',reschedule_reason:reschedule_reason, pickerDate: pickerDate,timepicker: timepicker},
        function(data) {
            if(data ==1){
                $('.alert-Success').show();
                setTimeout(function () {//remove pop up after 1.5 seconds
                     $('body').removeClass('overlaypop');
                     $('.insta-pop').removeClass('opend-pop');
                     $('.insta-pop').fadeOut();
                     $('.alert-Success').hide();
                 }, 1500);
                
            }
           
        }
      );
    });
    
    $('.timepicker').timepicker({
            timeFormat: 'h:mm',
            interval: 60,
            minTime: '0',
            maxTime: '11:00pm',
            defaultTime: '<?php echo $client['appointment_time'];  ?>',
            startTime: '12:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
    });
    
    $(document).ready(function(){
      // window.open("<?= $call_url?>"); 
        var appointment_id  =   '<?php echo $appointment_id?>';
        var room  =   '<?php echo $room?>';
        if(appointment_id != '' && room != ''){
            var left = 200;
            var top = 200;
            //window.open("<?= $call_url?>", 'Video call', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+500+', height='+500+', top='+top+', left='+left);
        }
    });
    
    
</script>