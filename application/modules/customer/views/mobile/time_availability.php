<section class="container">
    <div class="availability_container">
        <p class="txt-bold">Select the date and time of your appointment to receive a medical marijuana prescription.</p>

        <h2>Availability</h2>

        <div class="date_container">
            <i class="left_angle previous_date"></i>
            <span class="selected_date" ><input type="text" id="datepicker" name="selected_date" value="<?=$this->session->userdata('selectedTime')?>"></span>

            <i class="right_angle next_date"></i>
        </div>
        <ul class="time_slot clearfix">
            <?php
            $selectedTime   =   $this->session->userdata('selectedTime');
            $increment = 900;

            for($hours=8; $hours<20; $hours++){ // the interval for hours is '1'
                $hour = $hours;
                $minute = 0;
                for($mins=0; $mins<=45; $mins+=15){ // the interval for mins is '30'
                   $hour      =    str_pad($hours,2,'0',STR_PAD_LEFT);
                   $minute    =    str_pad($mins,2,'0',STR_PAD_LEFT);
                   if($minute < 45){   
            ?>
                
                <li class="set_time <?php if($selectedTime == $hour.':'.$minute) {?>active<?php }?>" data-value="<?=$hour?>:<?=$minute?>"> <?=$hour?>:<?=$minute?>- <?=$hour?>:<?=$minute+15?></li>
            <?php } else { ?>
                <li class="set_time <?php if($selectedTime == $hour.':'.$minute) {?>active<?php }?>" data-value="<?=$hour?>:<?=$minute?>"><?=$hour?>:<?=$minute?>- <?=$hour+1?>:00</li>
            <?php }}}?>
            
        </ul>
        <button class="btn gradient change_pass medical_btn make_appointment">
            <span class="btn-txt">Make Appointment</span>
        </button>
    </div>
</section>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
<script type="text/javascript">
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'yy-mm-dd', changeYear: true}).datepicker("setDate", new Date());
        $('.next_date').click(function () {
            var updatedDate = $('#datepicker').datepicker('getDate', '+1d');
            updatedDate.setDate(updatedDate.getDate() + 1);
            $('#datepicker').datepicker('setDate', updatedDate);
            if($('.set_time').hasClass('active')){
                checkForDoctorAvailability();
            }
        });
        $('.previous_date').click(function () {
            var updatedDate = $('#datepicker').datepicker('getDate', '-1d');
            updatedDate.setDate(updatedDate.getDate() - 1);
            $('#datepicker').datepicker('setDate', updatedDate);
            if($('.set_time').hasClass('active')){
                checkForDoctorAvailability();
            }
        })
    });
    
    $(document).on('click','.set_time',function(){
        $('.set_time').removeClass('active');
        $(this).addClass('active');
        checkForDoctorAvailability();
    });
    
    $(document).on('click','.make_appointment',function(){
        var selectedTime   =   $('.active').attr('data-value');
        var selectedDate   =   $('#datepicker').val();
        
        if(selectedTime == '' || selectedTime == undefined){
            alert('please select suitable time slot');
            return false;
        }
        $.ajax({
           type:'POST',
           data: {selectedTime:selectedTime,selectedDate:selectedDate},
           url:siteurl+'save-selected-time',
           success:function(){
               //window.location.href =   'cus-prescription-payment';
               window.location.href =   'http://54.245.183.187/shaco/stripe_form.php';
           }
        }); 
    });
    
    function checkForDoctorAvailability(){
        var selectedTime   =   $('.set_time.active').attr('data-value');
        var selectedDate   =   $('#datepicker').val();
        $.ajax({
           type:'POST',
           data: {selectedTime:selectedTime,selectedDate:selectedDate},
           url:siteurl+'check-for-doctor',
           success:function(docId){
                if(docId == '' || docId == 'null'){
                    $('.set_time').removeClass('active');
                    alert('Doctor not available on selected slot. Please select another slot.');
                    return false;
                }
           }
        });
    }
</script>