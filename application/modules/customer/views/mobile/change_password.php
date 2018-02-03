<section class="container mobile-view-container">
    <div class="form-container">
        <?= form_open_multipart('', array('class' => 'clearfix ajaxform', 'id' => '')) ?>    
            <div class="alert alert-info wait-div " style="display:none;"> <strong>Please wait! </strong> Your action is in proccess... </div>
            <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
                <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
                <div class="jGrowl-notification ">
                    <div class="jGrowl-message ajax_message"></div>
                </div>
            </div>
            <label class="txt_input">
                <input type="Password" name="current_password" placeholder="Current Password">

            </label>
            <label class="txt_input">
                <input type="Password" name="new_password" placeholder="New Password">
            </label>
            <label class="txt_input">
                <input type="Password" name="confirm_password" placeholder="Confirm New Password">
            </label>

            <button class="btn gradient change_pass">
                <span class="btn-txt">Change Password</span>
            </button>
        <?= form_close();?>

    </div>
</section>
