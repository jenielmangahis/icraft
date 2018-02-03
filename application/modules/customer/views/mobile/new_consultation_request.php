<section class="container mobile-view-container">
    <div class="alert alert-container alert-danger alert-error" style="display:none">
        <div class="alert-content">
            <div class="alert-body">
                <p class="alert-text">Due to regulations, this service is not available to people under age 18.</p>
            </div>
        </div>
    </div>
    <div class="form-container">
        <label class="txt_input right_ico">
            <input type="text" name="dob_med" id="dob_med" placeholder="Date of Birth" onchange="CalculateDiff()" value="" readonly="">
            <span class="input_ico icon-calendar"></span>
        </label>
    </div>
    <div class="new_consultation">
        <h2>Please select the conditions for which you are seeking a consultation.</h2>
        <?php if (sizeof($allConsultationsTypes) > 0) {
            $selectedConsultations = explode(',', $this->session->userdata('selectedConsultations')); ?>
            <ul class="clearfix diseases">
                <?php
                foreach ($allConsultationsTypes as $type) {
                    if ($type->is_other == '0') {
                        ?>
                        <li>
                            <label>
                                <input type="checkbox" name="prescription" value="<?= $type->id ?>" <?php if (in_array($type->id, $selectedConsultations)) { ?>checked="checked"<?php } ?>>
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt"><?= $type->name ?></span>
                            </label>
                        </li>
                    <?php
                    }
                }
                ?>
                <li class="clear_left other_box <?php if (sizeof($selectedConsultations) > 0) { ?>activated<?php } ?>">
                    <label>
                        <input type="checkbox" name="other_prescription_main" class="others">
                        <span class="tick_container"><i class="icon-checked"></i></span>
                        <span class="txt">Others</span>
                    </label>
                    <?php
                    foreach ($allConsultationsTypes as $type) {
                        if ($type->is_other == '1') {
                            ?>

                            <ul class="clearfix diseases mt_20">

                                <li>
                                    <label>
                                        <input type="checkbox" name="prescription" value="<?= $type->id ?>" <?php if (in_array($type->id, $selectedConsultations)) { ?>checked="checked"<?php } ?>>
                                        <span class="tick_container"><i class="icon-checked"></i></span>
                                        <span class="txt"><?= $type->name ?></span>
                                    </label>
                                </li>
                            </ul>
                        <?php
                        }
                    }
                    ?>
                </li>
            </ul>
<?php } ?>
        <textarea placeholder="Please Specify the other conditions…" name="other_reason" id="other_reason"></textarea>
        <button class="btn gradient change_pass proceed_consultation" data-attribute="appointment-question">
            <span class="btn-txt proceed_consultation" >Submit</span>
        </button>
    </div>
</section>
<script type="text/javascript">
    $(function () {
        $('.proceed_consultation').prop("disabled",true);
        $('.others').change(function () {
            if ($(this).is(':checked')) {
                $(this).parents('li.other_box').addClass('activated')
            } else {
                $(this).parents('li.other_box').removeClass('activated')
            }
        })
    });
    var dt  =   '<?=date('Y-m-d')?>';
    
    $('#dob_med').datepicker({
        dateFormat: 'yy-m-d',
        value: new Date(),
        mask: '',
        timepicker: false,
        //changeYear: true,
        //maxDate: new Date('2000-12-31')
        maxDate: "-0",
    });
    function CalculateDiff() {

        if ($("#dob_med").val() != '') {

            var From_date = new Date($("#dob_med").val());
            var To_date = new Date();
            var diff_date = To_date - From_date;

            var years = Math.floor(diff_date / 31536000000);
            if(years < 18){
                $('.alert-container').show();
                $('.proceed_consultation').prop("disabled",true);
            }else{
                $('.alert-container').hide();
                $('.proceed_consultation').prop("disabled",false);
            }
        } else {
            alert("Please select dates");
            return false;
        }
    }


</script>