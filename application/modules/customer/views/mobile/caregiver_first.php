<section class="container mobile-view-container">
    <div class="caregiver-details">
        <p><b>Section 1:</b> Qualifying Patient Information</p>
        <div class="form-container">
            <?= form_open_multipart('cus-caregiver-step1', array('class' => 'clearfix ajaxform', 'id' => '')) ?>    
                <div class="alert alert-info wait-div " style="display:none;"> <strong>Please wait! </strong> Your action is in proccess... </div>
                <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
                    <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
                    <div class="jGrowl-notification ">
                        <div class="jGrowl-message ajax_message"></div>
                    </div>
                </div>
                <label class="txt_input">
                    <input type="text" name="full_name" placeholder="full name on your ID" value="<?= $userDetail->first_name ?> <?= $userDetail->last_name ?>" required="">
                </label>
                <label class="txt_input right_ico">
                    <input type="text" name="dob" id="dob" placeholder="Date of Birth" value="<?= $userDetail->dob ?>" required="">
                    <!--<span class="input_ico icon-calendar"></span>-->
                </label>
                <label class="txt_input">
                    <input type="text" name="phone_number" placeholder="Telephone Number" value="<?= $userDetail->phone_number ?>" required="">
                </label>
                <label class="txt_input">
                    <input type="text" name="home_address" placeholder="Home Address" value="" required="">
                    <!--<textarea name="home_address" placeholder="Home Address" rows="5" required=""></textarea>-->
                </label>
                <div class="half_input clearfix">
                    <label class="txt_input left">
                        <input type="text" name="city" placeholder="City" value="" required="">
                    </label>
                    <label class="txt_input right">
                        <input type="text" name="state" placeholder="State" value="" required="">
                    </label>
                </div>
                <div class="half_input clearfix">
                    <label class="txt_input left">
                        <input type="number" min="0" name="zip" placeholder="ZIP" value="" maxlength="6" onKeyDown="if(this.value.length==6) return false;" required="">
                    </label>
<!--                    <label class="txt_input right">
                        <input type="text" name="country" placeholder="Country" value="" required="">
                    </label>-->
                </div>
<!--                <label class="txt_input">
                    <input type="text" name="medical_certification" placeholder="Medical Provider Written Certification" value="" required="">
                </label>-->
                <!--                <div class="half_input clearfix">
                                    <label class="txt_input right_ico left">
                                        <input type="text" name="" placeholder="Issued Date">
                                        <span class="input_ico icon-calendar"></span>
                                    </label>
                                    <label class="txt_input right_ico right">
                                        <input type="text" name="" placeholder="Expiration Date">
                                        <span class="input_ico icon-calendar"></span>
                                    </label>
                                </div>-->
                <div class="half_input clearfix">
                </div>

                <button class="btn gradient change_pass">
                    <span class="btn-txt">Next</span>
                </button>
            <?= form_close();?>

        </div>
    </div>
</section>
<script>
    $('#dob').datepicker({
        dateFormat: 'yy-m-d',
        defaultDate: '1980-01-01',
        mask: '',
        timepicker: false,
        //autoSize:true,
        //changeMonth: true,
        //changeYear: true
    });
    $('input').on('keydown', function(event) {
        alert(event.keyCode)
    })
</script>