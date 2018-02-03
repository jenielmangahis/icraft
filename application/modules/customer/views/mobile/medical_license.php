<section class="container mobile-view-container">
    <div class="medical_license">
        <?= form_open_multipart('', array('class' => 'clearfix ajaxform med-lic', 'id' => '')) ?>    
        <h2>Do you already have a prescription/license to consume cannabis?</h2>
        <div class="radio_container clearfix">
            <label>
                <input type="radio" checked="checked" name="license" class="radio_license"> <span class="radio_box"> <span class="radio_bullet gradient"></span></span> <span class="radio_txt">Yes, I already have a prescription</span>
            </label>
            <label>
                <input type="radio" name="license" class="radio_txt_license"> <span class="radio_box"> <span class="radio_bullet gradient"></span></span> <span class="radio_txt">No, I don’t have a prescription</span>
            </label>
        </div>

        <label class="upload_container upload_license">
            <input type="file" class="dis-none" id="med_lic" name="prescription_image" onchange="medicalLicenseURL(this);">
            <img src="<?= $this->config->item('customerassets') ?>images/uploadimage.png" alt="" id="medical_lic_holder">
            <span>Upload Medical Licence's Front Image</span>
        </label>
        <label class="upload_container upload_license">
            <input type="file" class="dis-none" id="med_lic1" name="prescription_image_back" onchange="medicalLicenseURL1(this);">
            <img src="<?= $this->config->item('customerassets') ?>images/uploadimage.png" alt="" id="medical_lic_holder1">
            <span>Upload Medical Licence's Back Image</span>
        </label>
        <?= form_close() ?>
        <label class="upload_container upload_license">
            <button class="btn gradient change_pass medical_btn have_prescription">
                <span class="btn-txt">Next</span>
            </button>
        </label>
        <div class="dis-none txt_license">
            <p class="txt-bold">In order to use the InstaCraft services, you must have at least one prescription from a doctor.</p>
            <p class="txt-bold mt_20" >You can have a telephone consultation with a doctor from our network about your need for cannabis. If approved, prescriptions can be issued lectronically withing minutes. Start shopping with InstaCraft immediately!</p>
            <button class="btn gradient change_pass medical_btn get_prescription">
                <span class="btn-txt">Get Cannabis Prescription</span>
            </button>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('.radio_license').change(function () {
            if ($(this).is(":checked")) {
                $('.upload_license').show();
                $('.txt_license').hide();
            }
        })
        $('.radio_txt_license').change(function () {
            if ($(this).is(":checked")) {
                $('.upload_license').hide();
                $('.txt_license').show();
            }
        })

        $(document).on('click', '.get_prescription', function () {
            window.location = siteurl + "cus-new-prescription";
        });
    })
    $(document).on('click', '.have_prescription', function () {
        var allOk   =   true;
        if($('#med_lic').val() =='' || $('#med_lic').val() ==undefined || $('#med_lic').val() == siteurl+'images/uploadimage.png'){
            alert("upload medical licence's front image.");
            allOk   =   false;
        }
        if($('#med_lic1').val() =='' || $('#med_lic1').val() ==undefined || $('#med_lic1').val() == siteurl+'images/uploadimage.png'){
            alert("upload medical licence's back image.");
            allOk   =   false;
        }
        if(allOk){
            $('.med-lic').submit();
        }
    });

    function medicalLicenseURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#medical_lic_holder').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function medicalLicenseURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#medical_lic_holder1').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>