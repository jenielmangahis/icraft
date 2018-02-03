<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <title>Instacraft</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url() ?>assets/css/instastyle.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/developer.css" rel="stylesheet" />
    
 <script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>
     
    
</head>
<body>
    <header>
        <p class="title">Partner Doctor Platform</p>        
    </header>
  
<section class="main-body">
    <div class="info-box note-u">
        <textarea placeholder="Write your notes here....">
            <?php
            if (isset($_POST['notes'])) {
                echo$_POST['notes'];
            }
            ?>
        </textarea>
                </div>
<div class="down-action select-opt">
                <p class="top-note">
                    <strong>
                        Please read the following information carefully. Check off each box as you’ve read them. This page will go home
                        with you in your file, upon qualifications.
                    </strong>
                </p>
                <ul class="preception-detail">
                    <li><label class="head">Possession</label></li>
                    <li>
                        <span>
                            <?php if($_POST['possesion1'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p> Patient may possess up to two and one half (2.5) ounces of prepared marijuna in a 15 day period.</p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['possesion2'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>No smoking in public.</p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['possesion3'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>No smoking in cars, or other motorized vehicles.</p>
                    </li>
                </ul>
                <ul class="preception-detail">
                    <li><label class="head">Caregivers</label></li>
                    <li>
                        <span>
                            <?php if($_POST['caregivers1'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                            
                        </span>
                        <p>A caregiver is a person providing care for a qualifying patient.</p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['caregivers2'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>Must be 21 years of age or older,  and can never have been convicted of a disqualifying dry offense.</p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['caregivers3'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>
                            Patients may name one or two primary caregivers (only one person may be allowd to cultivate marijuna for a
                            patient, who is determined based solely on the qualifying patient’s preference.
                        </p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['caregivers4'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>
                            Caregivers must register with the state unless the qualifying patient is a member of the household of that
                            primary caregivers.
                        </p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['caregivers5'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>Assist no more than 5 patients at any one time with their medical use of marijuna.</p>
                    </li>
                </ul>
                <ul class="preception-detail">
                    <li><label class="head">State Licensed Dispensaries</label></li>
                    <li>
                        <span>
                            
                            <?php if($_POST['dispensaries1'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>
                            A Dispensary is a business licensed by the state to produce medical marijuna and provide it to qualifying
                            patients.
                        </p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['dispensaries2'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>A Dispensary can be appointed as  your primary caregiver.</p>
                    </li>
                </ul>
                <ul class="preception-detail">
                    <li><label class="head">Cultivation</label></li>
                    <li>
                        <span>
                            <?php if($_POST['cultivation1'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                            
                        </span>
                        <p>Maine state law allows a patient (or their primary caregiver) home cultivation.</p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['cultivation2'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>
                            A patient (or their primary caregiver) may possess no more than six mature marijuna plants at one time.
                        </p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['cultivation3'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>

                            A patient who elects to cultivate marijuna plants must keep the plants in an enclosed, locked facility.
                        </p>
                    </li>
                    <li>
                        <span>
                            <?php if($_POST['cultivation4'] == 'on'){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/checked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/unchecked.png" width="22px" class="set-pdf-checkboxes" />
                            <?php } ?>
                        </span>
                        <p>
                            In addition to the marijuna plants otherwise authorized under this paragraph, aprimary caregiver may have
                            harvested marijuna plants in varying stages of processing in order to ensure the primary caregiver is able to
                            meet the needs of the primary’s caregiver qualifying patients. As a guideline: 6 mature plants/ 12 in
                            vegetative state.
                        </p>
                    </li>
                </ul>
            </div>
</section>
<?php // exit; ?>