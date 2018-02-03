<section class="container mobile-view-container">
    <div class="medical_license">
        <?= form_open_multipart('', array('class' => 'clearfix ajaxform proof', 'id' => '')) ?>    
        
        <label class="upload_container upload_license">
            <input type="file" class="dis-none" id="med_lic1" name="front_id_proof" onchange="medicalLicenseURL1(this);">
            <img src="<?= $this->config->item('customerassets') ?>images/uploadimage.png" alt="" id="medical_lic_holder1">
            <span>Upload Proof's Front Image</span>
            
        </label>
        
        <label class="upload_container upload_license">
            <input type="file" class="dis-none" id="med_lic2" name="back_id_proof" onchange="medicalLicenseURL2(this);">
            <img src="<?= $this->config->item('customerassets') ?>images/uploadimage.png" alt="" id="medical_lic_holder2">
            <span>Upload Proof's Back Image</span>
        </label>
        <?= form_close() ?>
        <label class="upload_container upload_license">
            <button class="btn gradient change_pass medical_btn have_prescription">
                <span class="btn-txt">Next</span>
            </button>
        </label>
    </div>
</section>

<script type="text/javascript">
    
    $(document).on('click', '.have_prescription', function () {
        var allOk   =   true;
        if($('#med_lic1').val() =='' || $('#med_lic1').val() ==undefined || $('#med_lic1').val() == siteurl+'images/uploadimage.png'){
            alert("Upload Proof's Front Image.");
            allOk   =   false;
        }
        if($('#med_lic2').val() =='' || $('#med_lic2').val() ==undefined || $('#med_lic2').val() == siteurl+'images/uploadimage.png'){
            alert("Upload Proof's Back Image.");
            allOk   =   false;
        }
        if(allOk){
            $('.proof').submit();
        }
    });
    
    function medicalLicenseURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#medical_lic_holder1').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function medicalLicenseURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#medical_lic_holder2').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>