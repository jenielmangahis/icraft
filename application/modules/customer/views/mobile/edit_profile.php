<section class="container mobile-view-container">
    <div class="form-container profile_container">
        <?= form_open_multipart('cus-profile-edit', array('class' => 'clearfix ajaxform', 'id' => '')) ?>    
        <div class="alert alert-info wait-div " style="display:none;"> <strong>Please wait! </strong> Your action is in proccess... </div>
        <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
            <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
            <div class="jGrowl-notification ">
                <div class="jGrowl-message ajax_message"></div>
            </div>
        </div>
        <label class="user-img">
            <?php if($userRecord->profile_pic == '') {
                $profile_pic    =   $this->config->item('customerassets').'images/user.jpg';
            }else {
                $profile_pic    =   $userRecord->profile_pic;   
            }
            ?>
            <img src="<?= $profile_pic;?>" alt="user" id="cus_image_holder">
            <input type="file" name="profile_pic" class="dis-none" onchange="customerImageURL(this);">
            <i class="icon-photo-camera gradient"></i>
        </label>
        <label class="txt_input">
            <input type="text" name="email" placeholder="Email" value="<?=$userRecord->email?>" readonly>
        </label>
        <label class="txt_input">
            <input type="text" name="phone_number" placeholder="Phone Number" value="<?=$userRecord->phone_number?>">
        </label>
        <div class="half_input clearfix">
            <label class="txt_input left">
                <input type="text" name="first_name" placeholder="First Name" value="<?=$userRecord->first_name?>">
            </label>
            <label class="txt_input right">
                <input type="text" name="last_name" placeholder="Last Name" value="<?=$userRecord->last_name?>">
            </label>
        </div>
        <label class="txt_input right_ico">
            <input type="text" name="dob" id="dob" placeholder="Date of Birth" value="<?=$userRecord->dob?>" readonly="">
            <span class="input_ico icon-calendar"></span>
        </label>
        <select class="select_box" name="gender">
            <option value="">Select Gender</option>
            <option value="1" <?php if($userRecord->gender == '1'){?>selected <?php }?> >Male</option>
            <option value="2" <?php if($userRecord->gender == '2'){?>selected <?php }?>>Female</option>
            <option value="3" <?php if($userRecord->gender == '3'){?>selected <?php }?>>Other</option>
        </select>
        <label class="txt_input right_ico">
            <input type="text" name="location" placeholder="Location" value="<?=$userRecord->address?>">
            <span class="input_ico icon-location"></span>
        </label>

        <button class="btn gradient change_pass">
            <span class="btn-txt">Save</span>
        </button>
        <?= form_close() ?>

    </div>
</section>
<script>
    $('#dob').datepicker({
        dateFormat: 'yy-m-d',
        value: '<?php echo date('Y-m-d'); ?>',
        mask: '',
        timepicker: false,
        maxDate: new Date('2000-12-31')
        //autoSize:true,
        //changeMonth: true,
        //changeYear: true
    });

    function customerImageURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#cus_image_holder').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>