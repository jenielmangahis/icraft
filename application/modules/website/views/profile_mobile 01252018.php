<?php include('templates/header-mobile.php')  ?>
<section class="main-body">
    <div style="width: 100%;position: absolute;height: 315px;">
        <div style="width: 30%;height: 315px;float: left;">
            <a href="<?php echo base_url() ?>prescriptions"><img class="img-back vertical-center" src="<?php echo base_url() ?>assets/img/arrow-back.png"/></a>
        </div>
        <div class="dp propage-upload">
            <div class="browse">
                <input type="file" name="profile_pic" id="file" class="inputfile" value="<?php echo $data['data']['profile_pic'];  ?>"  >
                <label for="file">
                    <img class="mobile-prescription-prof-img" src="<?php echo base_url(); ?>assets/img/attach-icon.png" />
                </label>
            </div>
        </div>
    </div>
    <div class="container-profile-mobile">
        <div style="width: 50%;margin: 0 auto;">
            <?php if($data['data']['profile_pic']){ ?>
                <img class="mobile-prescription-profile-def" src="<?php echo $data['data']['profile_pic'];  ?>" />      
            <?php }else{ ?>
                <img class="mobile-prescription-profile-def" src="<?php echo base_url(); ?>assets/images/prof.jpg" />
            <?php } ?>
            <br/>
            <h1 class="center txt-name">Rober Robin</h1>
        </div>
    </div>
    <div class="description-pr-details">
        <div style="width: 40%;float:left;">
            <h3 class="description-profile">Name</h3>
        </div>
        <div style="width: 60%;float:left;">
            <input class="description-input" type="text" name="first_name" value="<?php echo $data['data']['first_name']; ?>" />
        </div>
        <br style="clear:both;"><br/>
        <div style="width: 40%;float:left;">
            <h3 class="description-profile">Email</h3>
        </div>
        <div style="width: 60%;float:left;">
            <input class="description-input" type="text" name="email" value="<?php echo $data['data']['email']; ?>" />
        </div>
        <br style="clear:both;"><br/>
        <div style="width: 40%;float:left;">
            <h3 class="description-profile">Contact no.</h3>
        </div>
        <div style="width: 60%;float:left;">
             <input class="description-input" type="text" name="phone_number" value="<?php echo $data['data']['phone_number']; ?>" />
        </div>
        <br style="clear:both;"><br/>
        <div style="width: 40%;float:left;">
            <h3 class="description-profile">Location</h3>
        </div>
        <div style="width: 60%;float:left;">
             <input class="description-input" type="text" name="address" value="<?php echo $data['data']['address']; ?>" />
        </div>
        <br style="clear: both;"><br/>
        <h3 class="description-profile-black">professional information</h3>
        <br style="clear:both;"><br/>
        <div style="width: 40%;float:left;">
            <h3 class="description-profile">Experience</h3>
        </div>
        <div style="width: 60%;float:left;">
             <input class="description-input" type="text" name="experience" value="<?php echo $data['data']['experience']; ?>" />
        </div>
        <br style="clear:both;"><br/>
        <div style="width: 40%;float:left;">
            <h3 class="description-profile">License No</h3>
        </div>
        <div style="width: 60%;float:left;">
             <input class="description-input" type="text" name="license_number" value="<?php echo $data['data']['license_number']; ?>" />
        </div>
        <br style="clear:both;"><br/>
        <div style="width: 40%;float:left;">
            <h3 class="description-profile">Signature</h3>
        </div>
        <div style="width: 60%;float:left;">
             <img class="doc-img-mobile" src="<?php echo $data['data']['signature_or_document']; ?>" height="100px" />
        </div>        
        <br style="clear:both;"><br/>
        <div style="width: 100%;float:right;">
            <div class="dp propage-upload">
                <div class="browse-signature">
                    <input type="file" name="signature" id="file" class="inputfile" >
                    <label for="file">
                        <p><span class="icon-attached"></span>Attach Signature/Document</p>
                    </label>
                </div>
            </div>
        </div>   
        <br style="clear: both;"><br/>
        <div style="width: 50%;float:left;">
            <input type="submit" class="btn-insta-sub" name="save" value="Save">
        </div>
        <div style="width: 50%;float:left;">
             <a class="btn-insta-sub" >Cancel</a>
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
