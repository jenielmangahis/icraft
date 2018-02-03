<section class="container">
    <div class="home_screen">
        <div class="profile_overview">
            <?php
            if ($userRecord->profile_pic == '') {
                $profile_pic = $this->config->item('customerassets') . 'images/user.jpg';
            } else {
                $profile_pic = $userRecord->profile_pic;
            }
            ?>
            <div class="profile_img">
                <img src="<?= $profile_pic ?>" alt="user">
            </div>
            <div class="user_info">
                <h2 class="user_name"><?= $userRecord->first_name ?> <?= $userRecord->last_name ?></h2>
                <p><b>Rewards Points:</b> <?= $userRecord->total_point ? $userRecord->total_point : 0 ?> </p>
                <p><?= $userRecord->email ?></p>
            </div>
        </div>
        <div class="profile_status">
            <h4>Profile Completion <span class="right">34</span></h4>
            <div class="bar_slider">
                <div class="fill_slider gradient" style="width: 34%">
                    <span class="slider_bullet"></span>
                </div>
            </div>
            <p>Earn reward points by completing your profile.</p>
        </div>
        <?php
            if ($upcomingAppointment->status == '0')
                $status = 'Pending';
            if ($upcomingAppointment->status == '1')
                $status = 'Confirm';
            if ($upcomingAppointment->status == '2')
                $status = 'Rescheduled';
            if ($upcomingAppointment->status == '3')
                $status = 'Cancel';
        ?>
        <div id="upcoming_appointment" style="display: <?php if(sizeof($upcomingAppointment) > 0) {?>block<?php } else {?>none<?php }?>">
            <p class="help_txt">Upcoming Appointment</p>
            <div class="appointment_card gradient">
                <h3 id="time_to_appointment">10 minutes to appointment</h3>
                <p><b>Date: </b> <span id="appointment_date"> <?=$upcomingAppointment->appointment_date?></span></p>
                <div class="half_input clearfix">
                    <p class="left"><b>Time: </b><span id="appointment_time"> <?=$upcomingAppointment->appointment_time?></span></p>	
                    <p class="right"><b>Status: </b><span id="status"> <?=$status?></span></p>
                </div>
                <form id="form_for_video_call" method="post" action="cus-video-consultation">            
                    <div class="card_buttons clearfix">
                        <a href="javascript:;" id="make_video_call" data-appointmentId="<?=$upcomingAppointment->appointment_id?>">Call Now</a>
                        <input type="hidden" name="appointment_id" id="appointment_id_video" value="<?=$upcomingAppointment->appointment_id?>">
                        <a href="javascript:;">View Details</a>
                    </div>
                </form>     
            </div>
        </div>
        
        <p class="help_txt">Recommended Products</p>
        <div class="product_list">
            <div class="product_card clearfix">
                <div class="product_detail clearfix green">
                    <div class="pro_img left"><img src="<?= $this->config->item('customerassets') ?>images/pro.jpg" alt="product"></div>					
                    <div class="product_info right">
                        <h3>Product Name</h3>
                        <p><b>Price:</b> $200</p>
                        <p class="about">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  </p>
                    </div>
                </div>
                <div class="card_buttons clearfix">
                    <a href="javascript:;" class="add_to_cart">Add to Cart</a>
                    <a href="javascript:;" class="add_to_cart">More Info</a>					
                </div>
            </div>
        </div>

    </div> 
    <button class="btn gradient change_pass get_cannabis_now">
        <span class="btn-txt">Get Cannabis Now</span>
    </button>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        if ($('.profile_img img').width() > $('.profile_img img').height()) {
            $('.profile_img').addClass('vertical');
        } else {
            $('.profile_img').addClass('horizontal');
        }
    });
</script>