
<!-- prescriptions uploaded by patient-->

<section class="container mobile-view-container">
    <?php foreach($allPrescription['my_prescriptions'] as $prescription) { ?>
        <div class="prescription_container <?php if(strtotime($prescription->expire_date) < strtotime(date('Y-m-d'))){ echo 'inactive';}?>">
            <div class="prescription_card pad_20">
                <h3>Prescription Date : <?=date('Y-m-d',strtotime($prescription->created_at))?></h3>
                <p>Doctor Name : <?=$prescription->first_name?> <?=$prescription->last_name?></p>
                <p>Valid Thru : <?=$prescription->expire_date?></p>
            </div>	

            <div class="prescription_card">
                <img src="<?= $prescription->prescription_front_image?>" alt="prescription card">
                <p class="gradient validity_card">Valid Thru- <?=$prescription->expire_date?></p>
            </div>
        </div>
    <?php }?>
</section>
<!-- prescriptions uploaded by doctor-->
<?php //print_r($allPrescription['doctor_prescriptions']);die;?>
<section class="container">
    <?php foreach($allPrescription['doctor_prescriptions'] as $prescription) { ?>
        <div class="prescription_container <?php if(strtotime($prescription->appointment_date) != strtotime(date('Y-m-d'))){ echo 'inactive';}?>">
            <div class="prescription_card pad_20">
                <h3>Prescription Date : <?=date('Y-m-d',strtotime($prescription->created_at))?></h3>
                <p>Doctor Name : <?=$prescription->first_name?> <?=$prescription->last_name?></p>
                <p>Valid Thru : <?=$prescription->appointment_date?></p>
            </div>	

            <div class="prescription_card">
                <!--<p data-value="<?=$prescription->id?>" id="download_prescription">DOWNLOAD PRESCRIPTION</p>-->
                <a href="<?= base_url()."pdf/prescription_".$prescription->id."pdf"?>" target="_blank">DOWNLOAD PRESCRIPTION</a>
            </div>
        </div>
    <?php }?>
</section>
