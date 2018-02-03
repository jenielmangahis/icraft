<?php include('templates/header.php')  ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
   <section class="main-body">
        <div class="ground-elements">
            <ul class="dashbord-items">
                <li><span class="rel-val">17</span><p>Upcoming Appointments</p></li>
                <li><span class="rel-val">15</span><p>Preceptions Issued</p></li>
                <li><span class="rel-val">03</span><p>Appointments Completed</p></li>
                <li class="gap-left"><span class="rel-val">15</span><p>Appointments Cancelled</p></li>
                <li><span class="rel-val">12</span><p>Total Appointments</p></li>
            </ul>
            
            <?php
              
              $checkAvail = checkDoctorStatus($this->session->userdata('doctor_id'));
              $checked = $checkAvail['availablity'];
              
                if($checked == '1'){
                    $checked = "checked";//Available
                }else{
                    $checked = "";//Not available
                }
                
                $dashboradChecks = checkDoctorDashBoardAvail($this->session->userdata('doctor_id'));
//                echo "<pre>";
//                print_r($dashboradChecks);
                if($dashboradChecks['from_time']){
                    $from = $dashboradChecks['from_time'];
                }else{
                    $from = '';
                }
                
                if($dashboradChecks['to_time']){
                    $to = $dashboradChecks['to_time'];
                }else{
                    $to = '';
                }
            ?>
            <form action="<?php echo base_url(); ?>updateDaysAndTime" method="post">
                <div class="availability">
                    
                <h3>Availability</h3>
                    <input type="text" id="textbox1" value="" />
                    <div class="avl">
                        <span class="status"><strong>Available</strong>
                            <span class="switch"><input id="aval" type="checkbox" class="checker" value="true" name="onoffswitch" <?php echo $checked; ?>  >
                                <label for="aval" class="side-label avali"></label>
                            </span>
                        </span>
                    </div>
                    <br style="clear: both;">
                    <ul class="unstyled centered">
                        <li>
                            <input id="mon" type="checkbox" name="mon" <?php if($dashboradChecks['mon']=='1'){echo "checked";} ?> >
                            <label for="mon" class="side-label"><span class="week-day">Mon</span></label>
                        </li>
                        <li>
                            <input id="tue" type="checkbox" name="tue" <?php if($dashboradChecks['tue']=='1'){echo "checked";} ?>>
                            <label for="tue" class="side-label"><span class="week-day">Tue</span></label>
                        </li>
                        <li>
                            <input id="wed" type="checkbox" name="wed" <?php if($dashboradChecks['wed']=='1'){echo "checked";} ?>>
                            <label for="wed" class="side-label"><span class="week-day">Wed</span></label>
                        </li>
                        <li>
                            <input id="thu" type="checkbox" name="thu" <?php if($dashboradChecks['thu']=='1'){echo "checked";} ?>>
                            <label for="thu" class="side-label"><span class="week-day">Thur</span></label>
                        </li>
                        <li>
                            <input id="fri" type="checkbox" name="fri" <?php if($dashboradChecks['fri']=='1'){echo "checked";} ?>>
                            <label for="fri" class="side-label"><span class="week-day">Fri</span></label>
                        </li>
                        <li>
                            <input id="sat" type="checkbox" name="sat" <?php if($dashboradChecks['sat']=='1'){echo "checked";} ?>>
                            <label for="sat" class="side-label"><span class="week-day">Sat</span></label>
                        </li>
                        <li>
                            <input id="sun" type="checkbox" name="sun" <?php if($dashboradChecks['sun']=='1'){echo "checked";} ?>>
                            <label for="sun" class="side-label"><span class="week-day">Sun</span></label>
                        </li>
                    </ul>
                    <div class="time-duration">
                        <h3>Time Duration</h3>
                        <div class="time-select">
                            <span class="from-date">
                                <input type="text" placeholder="00:00" name="fromTime" class="timepicker" value="<?php if($dashboradChecks['from_time']){echo $dashboradChecks['from_time'];}  ?>" />
                            </span>
                            <strong>to</strong>
                            <span class="from-date">
                                <input type="text" placeholder="00:00" name="toTime" class="timepicker2" value="<?php if($dashboradChecks['to_time']){echo $dashboradChecks['to_time'];}  ?>" />
                            </span>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="btn-bg-grad">
                    <!--<a href="#" class="btn-insta">Login</a>-->
                    <input type="submit" class="btn-insta-sub" name="save"  value="Save" />
                </div>
<!--                <a href="#" class="btn-insta save right">Save</a>-->
            </form>
        </div>
       
    </section>
<?php include('templates/footer.php')  ?>
<script>
    $(document).ready(function() {
        $("#aval:checkbox").change(function() {
            var Availablity;
            if($('#aval').is(':checked')){
                Availablity = '0';
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>updateStatus",
                    data: {availablity: Availablity},
                    success: function (data) {
                        console.log(data);
                        return false;
                    }
                });
            }else{
                Availablity = '1';
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>updateStatus",
                    data: {availablity: Availablity},
                    success: function (data) {
                        console.log(data);
                        return false;
                    }
                });
            }
        });    
        
        $('.timepicker').timepicker({
            timeFormat: 'h:mm',
            interval: 60,
            //minTime: '0',
            //maxTime: '11:00pm',
            defaultTime: '<?php echo $from;?>',
            startTime: '12:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        
        $('.timepicker2').timepicker({
            timeFormat: 'h:mm',
            interval: 60,
            //minTime: '0',
            //maxTime: '11:00pm',
            defaultTime: '<?php echo $to; ?>',
            startTime: '12:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        

    });
</script>