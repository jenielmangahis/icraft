<?php include('templates/header-mobile.php')  ?>
<script src="<?php echo base_url() ?>assets/js/dcalendar.picker.js"></script>
<link href="<?php echo base_url() ?>assets/css/dcalendar.picker.css" rel="stylesheet" />

<section class="main-body">
    <div style="width: 100%;position: absolute;height: 315px;">
        <div style="width: 30%;height: 315px;float: left;">
            <a href="<?php echo base_url() ?>prescriptions"><img class="img-back vertical-center" src="<?php echo base_url() ?>assets/img/arrow-back.png"/></a>
        </div>
        <div style="width: 40%;height: 315px;float: left;">
            <a href="#"><img class="call-icon" src="<?php echo base_url() ?>assets/img/call-icon.png"/></a>
        </div>
    </div>
    <div class="container-profile-mobile">
        <div style="width: 50%;margin: 0 auto;">
            <?php if($client['profile_pic']){ ?>
                <img class="mobile-prescription-prof-img" src="<?php echo $client['profile_pic']; ?>" />      
            <?php }else{ ?>
                <img class="mobile-prescription-prof-img" src="<?php echo base_url(); ?>assets/images/prof.jpg" />
            <?php } ?>
            <br/>
            <h1 class="center txt-name">Rober Robin</h1>
        </div>
    </div>
    <div class="description-pr-details">
        <h3>Email</h3>
        <h2><?php echo $client['email'];  ?></h2>
        <br/>
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
        <h3>Appointment Schedule</h3>
        <h2><?php echo date("d-m-Y",strtotime($client['appointment_date']));  ?><?php echo ','.$client['appointment_time'];  ?></h2>
        <br/>
        <h3>Consultation for</h3>
        <h2><?php echo $client['consultation_for'];  ?></h2>
        <form action="<?php echo base_url(); ?>generatePdf" method="POST" style="position: relative;bottom: 15px;">
            <div class="info-box note-u">
                <textarea placeholder="Write your notes here...." name="notes"><?php echo $client['notes']; ?></textarea>
            </div>
            <iframe src="<?php echo $client['prescription_front_image']; ?>" style="width:100px; height:100px;" frameborder="0"></iframe>
            <embed src="pdfFiles/interfaces.pdf" width="100" height="100" alt="pdf" pluginspage="<?php echo $client['prescriptions']; ?>">
        </form>
    </div>
</section>
<!--    <div class="insta-pop" data-pop="re-appoint">
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
    </div>-->


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
    
    
    
    
</script>