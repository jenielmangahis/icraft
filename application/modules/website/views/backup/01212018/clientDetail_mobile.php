<?php include('templates/header-mobile.php')  ?>
<script src="<?php echo base_url() ?>assets/js/dcalendar.picker.js"></script>
<link href="<?php echo base_url() ?>assets/css/dcalendar.picker.css" rel="stylesheet" />

<section class="main-body">
    <div class="container-profile-mobile-client" style="height: 190px;">
        <div style="width: 12.33%;height: 190px;float: left;">
            <a href="<?php echo base_url() ?>cancelAppointmentStatus"><img class="img-back-appointment" style="top: 39%;-webkit-transform: translateY(-43%);-ms-transform: translateY(-43%);transform: translateY(-43%);" src="<?php echo base_url() ?>assets/img/arrow-back.png"/></a>
        </div>
        <div style="width: 36.33%;float: left;">
            <?php if($client['profile_pic']){ ?>
                <img class="mobile-appointment-prof-img" style="position: relative;top: 28px;" src="<?php echo $client['profile_pic']; ?>" />      
            <?php }else{ ?>
                <img class="mobile-appointment-prof-img" style="position: relative;top: 28px;" src="<?php echo base_url(); ?>assets/images/prof.jpg" />      
            <?php } ?>
        </div>
        <div style="width: 49.33%;float:left;padding-top: 50px;">
            <h1 class="center appointment-txt-mobile"><?php echo ucfirst($client['first_name'].' '.$client['last_name']);  ?></h1>
            <span class="center appointment-txt-mobile-small" style="word-wrap: break-word;"><img src="<?php echo base_url() ?>assets/img/letter-icon.png" style="margin-right:2px;width: 18px;position: relative;top: 2px;" /><?php echo $client['email'];  ?></span>
        </div>
    </div>
    <br style="clear: both;">
    <div class="description-ap-details" style="width: 50%; float:left;">
        <h3>Date of Birth</h3>
        <h2><?php echo date("d-m-Y",strtotime($client['dob']));  ?></h2>
        <br/>
        <h3>Gender</h3>
        <h2>
            <?php 
                if($client['gender'] == '1'){
                    echo "Male";
                }else if($client['gender'] == '2'){
                    echo "Female";
                }else{
                    echo "Other";
                }   
            ?>
        </h2>
        <br/>
        <h3>Schedule</h3>
        <h2><?php echo date("d-m-Y",strtotime($client['appointment_date'])).', '.$client['appointment_time'];  ?></h2>
        <br/>
        <h3>Consultation</h3>
        <h2><?php echo $client['consultation_for'];  ?></h2>
        <br/>
        <h3>Status</h3>
        <h2>Confirmed</h2>
    </div>
    <div class="description-ap-details" style="width: 50%; float:left;text-align: center;">
        <?php if($client['status'] == '3'){ ?>
            <a id="cancelAppointmentStatus" class="btn-insta-fade purple-button-mobile"  >Cancelled</a>
            <a id="cancelAppointmentPop" data-attribute="cancel" class="purple-button-mobile" style="display:none" >Cancel</a>
        <?php }else{ ?>
            <a id="cancelAppointmentPop" data-attribute="cancel" class="purple-button-mobile" >Cancel</a>
            <a id="cancelAppointmentStatus" class="btn-insta-fade purple-button-mobile" style="display:none;" >Cancelled</a>
        <?php } ?>

        <br/><br/><br/>
        <a href="#" data-attribute="re-appoint" class="purple-button-mobile">Reschedule</a>
        <br/><br/><br/>
        <?php if($client['status'] == '1'){ ?>
            <a id="confirmedAppointmentStatus" class="purple-button-mobile">Confirmed</a>   
            <a id="confirmAppointment" class="purple-button-mobile" style="display:none;" >Confirm</a>
        <?php }else{ ?>
            <a id="confirmAppointment" class="purple-button-mobile" >Confirm</a>
            <a id="confirmedAppointmentStatus" class="purple-button-mobile" style="display:none;" >Confirmed</a>
        <?php } ?>
    </div>
    <br style="clear: both;">
    <a href="<?php echo base_url().'recommendation/'.$client['id']; ?>" class="green-button-mobile" style="margin-left: 25px;">Call Page</a>
    <br style="clear: both;"><br/>
    <div style="width: 100%;padding-left: 30px;padding-right: 30px;">
        <span style="text-align: justify;"><img src="<?php echo base_url() ?>assets/img/info-icon.png" style="width: 16px;position: relative;top: 3px;right: 5px;"/>The patient system allows you only small number of reschedules per year. Rescheduling an appointmentis inconvenient for patients and should only be done in cases of emergency.</span>
    </div>

    <iframe name="videoFrame"></iframe>
    <div class="insta-pop" data-pop="re-appoint">
        <div class="inner-insta-pop">
        <h1>Reschedule Appointment</h1>
        <div class="content-modal">
            <label class="pop-lab bob">Current Details</label>
            <br style="clear: both;" /><br/>
            <span class="color-purple modal-default-text caps">Appointment Date</span>
            <span class="modal-default-text"><?php echo date("d-m-Y",strtotime($client['appointment_date'])).', '.$client['appointment_time'];  ?></span>
            <br style="clear:both;">
            <span class="color-purple modal-default-text caps">Status</span>
            <label class="pop-lab bob">                    
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
            </label>
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
            <label class="pop-lab" style="text-transform: uppercase;">Reason For rescheduling the appointment</label>
            <textarea placeholder="Type here...." id="reschedulePopText"></textarea>
            <div class="btn-bg-grad">
                
                <a href="#" id="cancelAppointment" data-attribute="cancel" class="btn-insta-sub" style="display: block;text-align: center;padding-left: 38px !important;padding-right: 38px !important;padding-top: 8px !important;padding-bottom: 8px !important;">Re-Schedule</a>
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
        </div>
    <div class="insta-pop" data-pop="cancel">
        <h1>Cancel Appointment</h1>
        <div class="content-modal">
            <label class="pop-lab" style="text-transform: uppercase;">Reason For cancellation of the appointment</label>
            <textarea placeholder="Type here...." id="cancelReasonText"></textarea>
            <div class="btn-bg-grad">
                <a href="#" id="cancelAppointment" data-attribute="cancel" class="btn-insta-sub" style="display: block;text-align: center;padding-left: 38px !important;padding-right: 38px !important;padding-top: 8px !important;padding-bottom: 8px !important;">Cancel</a>
            </div>
            <div class="alert alert-Success"  style="display:none">      
                Appointment rescheduled successfully
            </div>
            <span class="close close_model"><i class="icon-cross"></i></span>
        </div>
    </div>

</section>
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