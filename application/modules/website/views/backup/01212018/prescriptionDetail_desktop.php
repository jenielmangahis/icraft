<?php include('templates/header.php')  ?>
<script src="<?php echo base_url() ?>assets/js/dcalendar.picker.js"></script>
<link href="<?php echo base_url() ?>assets/css/dcalendar.picker.css" rel="stylesheet" />

<section class="main-body">
        <div class="ground-elements">
            <a href="<?php echo base_url() ?>appointments" class="action-back"><span class="icon-back"></span><span class="redi-txt">Back</span></a>
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
                        <span class="cust-name"><?php echo ucfirst($client['first_name'].''.$client['last_name']);  ?></span>
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
            <div class="down-action" style="width: 100%;margin-left: 0px;margin-right: 0px;margin-top: 40px;margin-bottom: 40px;padding-left: 40px;padding-right: 40px;">
<!--                <div class="btn-bg-grad">
                    <?php if($client['status'] == '3'){ ?>
                        <a id="cancelAppointmentStatus" class="btn-insta-fade"  >Cancelled</a>
                        <a id="cancelAppointmentPop" data-attribute="cancel" class="btn-insta" style="display:none" >Cancel</a>
                    <?php }else{ ?>
                        <a id="cancelAppointmentPop" data-attribute="cancel" class="btn-insta" >Cancel</a>
                        <a id="cancelAppointmentStatus" class="btn-insta-fade" style="display:none;" >Cancelled</a>
                    <?php } ?>
                </div><div class="btn-bg-grad">
                          <a href="#" data-attribute="re-appoint" class="btn-insta">Reschedule</a>
                </div><div class="btn-bg-grad">
                    <?php if($client['status'] == '1'){ ?>
                        <a id="confirmedAppointmentStatus" class="btn-insta-fade" >Confirmed</a>   
                        <a id="confirmAppointment" class="btn-insta" style="display:none;" >Confirm</a>
                    <?php }else{ ?>
                        <a id="confirmAppointment" class="btn-insta" >Confirm</a>
                        <a id="confirmedAppointmentStatus" class="btn-insta-fade" style="display:none;" >Confirmed</a>
                    <?php } ?>
                </div>
                <div class="info-box">
                    <span class="left">
                        <i class="icon-info"></i><label>
                            The patient system allows you only a small number of reschedules per year. Rescheduling an appointment is inconvenient for
                            patients and should only be done in case of emergency.
                        </label>
                    </span>

                </div>-->
                <form action="<?php echo base_url(); ?>generatePdf" method="POST" >
                <div class="info-box note-u">
                    <textarea placeholder="Write your notes here...." name="notes"><?php echo $client['notes']; ?></textarea>
                </div>
                    <iframe src="<?php echo $client['prescription_front_image']; ?>" style="width:900px; height:10px;" frameborder="0"></iframe>
                <embed src="pdfFiles/interfaces.pdf" width="600" height="10" alt="pdf" pluginspage="<?php echo $client['prescriptions']; ?>">
<!--                <div class="down-action select-opt">
                <p class="top-note">
                    <strong>
                        Please read the following information carefully. Check off each box as you’ve read them. This page will go home
                        with you in your file, upon qualifications.
                    </strong>
                </p>
                <ul class="preception-detail">
                    <li><label class="head">Possession</label></li>
                    <li>
                        <span>
                            <input id="p1" type="checkbox" name="possesion1">
                            <label for="p1" class="side-label"></label>
                        </span>
                        <p> Patient may possess up to two and one half (2.5) ounces of prepared marijuna in a 15 day period.</p>
                    </li>
                    <li>
                        <span>
                            <input id="p2" type="checkbox"  name="possesion2">
                            <label for="p2" class="side-label"></label>
                        </span>
                        <p>No smoking in public.</p>
                    </li>
                    <li>
                        <span>
                            <input id="p3" type="checkbox"  name="possesion3">
                            <label for="p3" class="side-label"></label>
                        </span>
                        <p>No smoking in cars, or other motorized vehicles.</p>
                    </li>
                </ul>
                <ul class="preception-detail">
                    <li><label class="head">Caregivers</label></li>
                    <li>
                        <span>
                            <input id="c1" type="checkbox" name="caregivers1">
                            <label for="c1" class="side-label"></label>
                        </span>
                        <p>A caregiver is a person providing care for a qualifying patient.</p>
                    </li>
                    <li>
                        <span>
                            <input id="c2" type="checkbox" name="caregivers2">
                            <label for="c2" class="side-label"></label>
                        </span>
                        <p>Must be 21 years of age or older,  and can never have been convicted of a disqualifying dry offense.</p>
                    </li>
                    <li>
                        <span>
                            <input id="c3" type="checkbox" name="caregivers3">
                            <label for="c3" class="side-label"></label>
                        </span>
                        <p>
                            Patients may name one or two primary caregivers (only one person may be allowd to cultivate marijuna for a
                            patient, who is determined based solely on the qualifying patient’s preference.
                        </p>
                    </li>
                    <li>
                        <span>
                            <input id="c4" type="checkbox" name="caregivers4">
                            <label for="c4" class="side-label"></label>
                        </span>
                        <p>
                            Caregivers must register with the state unless the qualifying patient is a member of the household of that
                            primary caregivers.
                        </p>
                    </li>
                    <li>
                        <span>
                            <input id="c5" type="checkbox" name="caregivers5">
                            <label for="c5" class="side-label"></label>
                        </span>
                        <p>Assist no more than 5 patients at any one time with their medical use of marijuna.</p>
                    </li>
                </ul>
                <ul class="preception-detail">
                    <li><label class="head">State Licensed Dispensaries</label></li>
                    <li>
                        <span>
                            <input id="d1" type="checkbox" name="dispensaries1">
                            <label for="d1" class="side-label"></label>
                        </span>
                        <p>
                            A Dispensary is a business licensed by the state to produce medical marijuna and provide it to qualifying
                            patients.
                        </p>
                    </li>
                    <li>
                        <span>
                            <input id="d2" type="checkbox" name="dispensaries2">
                            <label for="d2" class="side-label"></label>
                        </span>
                        <p>A Dispensary can be appointed as  your primary caregiver.</p>
                    </li>
                </ul>
                <ul class="preception-detail">
                    <li><label class="head">Cultivation</label></li>
                    <li>
                        <span>
                            <input id="cu1" type="checkbox" name="cultivation1">
                            <label for="cu1" class="side-label"></label>
                        </span>
                        <p>Maine state law allows a patient (or their primary caregiver) home cultivation.</p>
                    </li>
                    <li>
                        <span>
                            <input id="cu2" type="checkbox" name="cultivation2">
                            <label for="cu2" class="side-label"></label>
                        </span>
                        <p>
                            A patient (or their primary caregiver) may possess no more than six mature marijuna plants at one time.
                        </p>
                    </li>
                    <li>
                        <span>
                            <input id="cu3" type="checkbox" name="cultivation3">
                            <label for="cu3" class="side-label"></label>
                        </span>
                        <p>

                            A patient who elects to cultivate marijuna plants must keep the plants in an enclosed, locked facility.
                        </p>
                    </li>
                    <li>
                        <span>
                            <input id="cu4" type="checkbox" name="cultivation4">
                            <label for="cu4" class="side-label"></label>
                        </span>
                        <p>
                            In addition to the marijuna plants otherwise authorized under this paragraph, aprimary caregiver may have
                            harvested marijuna plants in varying stages of processing in order to ensure the primary caregiver is able to
                            meet the needs of the primary’s caregiver qualifying patients. As a guideline: 6 mature plants/ 12 in
                            vegetative state.
                        </p>
                    </li>
                </ul>
                
                <input type="hidden" name="userId" value="<?php echo $this->uri->segment('2'); ?>" />
                <input type="submit" id="" class="" value="Download"  />
                
                
            </div>-->
                
            </form>
            
            <div class="noifications" style="margin-bottom: 65px;">
                <h1>Which Cannabinoids are best for your symptoms?</h1>
                <img src="<?php echo base_url() ?>assets/images/table.jpg" />
            </div>
            </div>

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