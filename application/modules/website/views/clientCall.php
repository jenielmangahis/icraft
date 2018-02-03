<?php include('templates/header.php')  ?>
<script src="<?php echo base_url() ?>assets/js/dcalendar.picker.js"></script>
<link href="<?php echo base_url() ?>assets/css/dcalendar.picker.css" rel="stylesheet" />
<section class="main-body">
        <div class="ground-elements">
            <a href="#" class="action-back"><span class="icon-back"></span><span class="redi-txt">Back</span></a>
            <div class="profile-sec no-shadow">
                <div class="dp dev-dp">
                    <h1>Personal Details</h1>
                    <?php // echo "<pre>"; print_r($client); ?>    
                    <div class="main-details">
                        <div class="custom-row">
                            <label>Customer Name</label>
                            <p><?php echo $client['first_name'];  ?></p>
                        </div>
                        <div class="custom-row">
                            <label>Email ID</label>
                            <p><?php echo $client['email'];  ?></p>
                        </div>
                        <div class="custom-row">
                            <label>Date of birth</label>
                            <p><?php echo date("d-m-Y",strtotime($client['dob']));  ?></p>
                        </div>
                        <div class="custom-row">
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
                        <div class="custom-row">
                            <label>Appointment Date</label>
                            <p><?php echo $client['appointment_time'];  ?></p>
                        </div>
                        <div class="custom-row">
                            <label>Consultation For</label>
                            <p><?php echo $client['consultation_for']; ?></p>
                        </div>  
                    </div>     
                </div>
                <div class="pro-details vid-dev-page">
                    <p style="padding:200px 0; text-align:center;">video plugin here</p>
                </div>
                <div class="note-u">
                    <textarea placeholder="Write your notes here...."></textarea>


                </div>
            </div>
            

        </div>
    </section>
    <div class="insta-pop" data-pop="re-appoint">
        <h1>Reschedule Appointment</h1>
        <label class="pop-lab bob">Currenr Details</label>
        <ul class="pog details">
            <li>
                <h1>1 august 2017</h1>
                <p>Date</p>
            </li>
            <li>
                <h1>12:00 AM</h1>
                <p>Time</p>
            </li>
            <li>
                <h1>Pending</h1>
                <p>Status</p>
            </li>
        
        </ul>
        <label class="pop-lab">Reschedule appointment</label>
        <ul class="pog reschedule">
            <li>
                <div class="datepiker"><input class="form-control" id="demo" type="text" placeholder="MM/DD/YY"><span class="btn-bk cal"></span></div>
            </li>
            <li>
                <div class="datepiker"><input class="form-control" id="demo" type="text" placeholder="MM/DD/YY"><span class="btn-bk cal"></span></div>
            </li>
        </ul>
        <label class="pop-lab">Resaon For reschedule the appointment</label>
        <textarea placeholder="Type here...."></textarea>
        <div class="btn-bg-grad">
            <a href="#" data-attribute="cancel" class="btn-insta">Submit</a>
        </div>
        <ul>
            <li>
                <p></p>
            </li>
        </ul>
        <span class="close close_model"><i class="icon-cross"></i></span>
    </div>
    <div class="insta-pop" data-pop="cancel">
        <h1>Cancel Appointment</h1>
        <label class="pop-lab">Resaon For reschedule the appointment</label>
        <textarea placeholder="Type here...."></textarea>
        <div class="btn-bg-grad">
            <a href="#" data-attribute="cancel" class="btn-insta">Cancel</a>
        </div>

        <span class="close close_model"><i class="icon-cross"></i></span>
    </div>
<?php include('templates/footer.php')  ?>
<script>
    $('#demo').dcalendarpicker();
    $('#calendar-demo').dcalendar();
</script>