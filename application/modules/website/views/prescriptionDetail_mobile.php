<?php include('templates/header-mobile.php')  ?>

<section class="main-body">
    <div class="container-profile-mobile-client" style="height: 190px;">
        <div style="width: 12.33%;height: 190px;float: left;">
            <a href="<?php echo base_url() ?>prescriptions"><img class="img-back-appointment" style="top: 39%;-webkit-transform: translateY(-43%);-ms-transform: translateY(-43%);transform: translateY(-43%);" src="<?php echo base_url() ?>assets/img/arrow-back.png"/></a>
        </div>
        <div style="width: 36.33%;float: left;">
            <?php if($client['profile_pic']){ ?>
                <img class="mobile-appointment-prof-img" style="position: relative;top: 28px;" src="<?php echo $client['profile_pic']; ?>" />      
            <?php }else{ ?>
                <img class="mobile-appointment-prof-img" style="position: relative;top: 28px;" src="<?php echo base_url(); ?>assets/images/prof.jpg" />      
            <?php } ?>
        </div>
        <div style="width: 49.33%;float:left;padding-top: 50px;">
            <h1 class="center appointment-txt-mobile"><?php echo ucfirst($client['first_name'].' '.$client['last_name']);  ?></h1>
            <span class="center appointment-txt-mobile-small" style="word-wrap: break-word;"><img src="<?php echo base_url() ?>assets/img/letter-icon.png" style="margin-right:2px;width: 18px;position: relative;top: 2px;" /><?php echo $client['email'];  ?></span>
        </div>
    </div>
    <div class="gray-area">
        <div style="width: 60%;float:left">
            <h3 style="position: relative;right: 16px;">Patient Details</h3>
        </div>
        <div style="width: 40%;float:right;position: relative;bottom: 18px;">
            <img class="mobile-appointment-prof-img" style="width: 25px;" src="<?php echo base_url(); ?>assets/img/arrow-down.png" />  
        </div>
    </div>
    <div class="description-pr-details">
        <h2 style="font-weight: lighter;">Please read the following information carefully. Check off each box as you’ve read them. This page will go gome with you in your profile, upon qualifications.</h2>
        <br/>
        <h3>POSSESSION</h3><br/>

        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q1" type="checkbox" name="q1" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q1" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">Patient may possess up to two and one half (2.5) ounces of prepared marijuna in a 15 day period.</p>
            </div>
        </div>
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q2" type="checkbox" name="q2" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q2" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">No smoking in public.</p>
            </div>
        </div>        
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q3" type="checkbox" name="q3" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q3" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">No smoking in cars, or other motorized vehicles.</p>
            </div>
        </div>     
        <br style="clear: both;" /><br/>
        <h3>CAREGIVERS</h3>
        <br style="clear: both;" />
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q4" type="checkbox" name="q4" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q4" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">A caregiver is a person providing care for a qualifying patient.</p>
            </div>
        </div>     
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q5" type="checkbox" name="q5" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q5" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">Must be 21 years of age, and can never have been convicted of a disqualifying dry offense.</p>
            </div>
        </div>     
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q6" type="checkbox" name="q6" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q6" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">Assist no more than 5 patients at any one time with their medical use of marijuana.</p>
            </div>
        </div>   
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q7" type="checkbox" name="q7" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q7" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">Patients may name one or two primary caregivers (only one person may be allowed to cultivate marijuana for a patient, who is determined solely on qualifying patient’s preference).</p>
            </div>
        </div> 
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q8" type="checkbox" name="q8" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q8" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">Caregivers must register with the state unless the qualifying patient is a member of the household of that primary caregivers.</p>
            </div>
        </div> 
        <br style="clear: both;" /><br/>
        <h3>STATE LICENSED DISPENSARIES</h3>
        <br style="clear: both;" />
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q9" type="checkbox" name="q9" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q9" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">A dispensary can be appointed as your primary caregiver.</p>
            </div>
        </div>     
        <br style="clear: both;" /><Br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q10" type="checkbox" name="q10" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q10" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">A dispensary is a business licensed by the sate to produce medical marijuana and provide to qualifying patients.</p>
            </div>
        </div>   
        <br style="clear: both;" /><br/>
        <h3>CULTIVATION</h3>
        <br style="clear: both;" />
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q11" type="checkbox" name="q11" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q11" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">Maine state law allows a patient (or their primary caregiver) home cultivation..</p>
            </div>
        </div>     
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q12" type="checkbox" name="q12" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q12" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">A patient (or their primary caregiver) may posses no more than six mature marijuana plants at one time.</p>
            </div>
        </div>   
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q13" type="checkbox" name="q13" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q13" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">A patient who elects to cultivate marijuana plants must keep the plants in an enclosed, locked facility.</p>
            </div>
        </div>   
        <br style="clear: both;" /><br/>
        <div>
            <div style="width:10%; float:left;">
                <input class="hide-chk" id="q114" type="checkbox" name="q114" <?php if(isset($schedules['mon'])){echo "checked";} ?> >
                <label for="q14" class="side-label-box-pres"><span class="week-day"></span></label>

            </div>
            <div style="width:90%; float:left;">
                <p class="prescription-detail">In addition to the marijuana plants otherwise authorized under this paragraph, a primary caregiver may have harvested marijuana plants in varying stages of processing in order to ensure the primary caregiver is able to meet the needs of the primary’s caregiver qualifying patients. As a guideline: 6 mature plants/12 in vegetative state.</p>
            </div>
        </div>   
        <br style="clear: both;" /><br/>
        <h3>WHICH CANNABINOIDS ARE BEST FOR YOUR SYMPTOMS?</h3>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Relieves Pain</h3>
            <span class="pr-type">Analgensic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="red-symbol symbol">THC</span>
                <span class="blue-symbol symbol">CBD</span>
                <span class="lime-symbol symbol">CBN</span>
                <span class="purple-symbol symbol">CBC</span>
                <span class="orange-symbol symbol">CBG<span style="font-size: 10px;">A</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Supresses appetite / <br/> Helps with weight loss</h3>
            <span class="pr-type">Anorectic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="yellow-symbol symbol">THC<span style="font-size: 10px;">V</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Kills or slows bacteria growth</h3>
            <span class="pr-type">Antibacterial</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
                <span class="orange-symbol symbol">CBG</span>
                <span class="magenta-symbol symbol">CBC<span style="font-size: 10px;">A</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Reduces blood sugar levels</h3>
            <span class="pr-type">Anti-diabetic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Reduces vomiting and nauseas</h3>
            <span class="pr-type">Anti-emetic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="red-symbol symbol">CBD</span>
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Reduces seizures and convulsion</h3>
            <span class="pr-type">Anti-epileptic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
                <span class="yellow-symbol symbol">THC<span style="font-size: 10px;">V</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Treats fungal infection</h3>
            <span class="pr-type">Antifungal</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="magenta-symbol symbol">CBC<span style="font-size: 10px;">A</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Reduces inflammation</h3>
            <span class="pr-type">Anti-inflammatory</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
                <span class="orange-symbol symbol">CBG</span>
                <span class="purple-symbol symbol">CBC</span>
                <span class="orange-symbol symbol">CBG<span style="font-size: 10px;">A</span></span>
                <span class="green-symbol symbol">CGC<span style="font-size: 10px;">A</span></span>
                <span class="teal-symbol symbol">THC<span style="font-size: 10px;">A</span></span><br/><br/>
                <span class="pale-green-symbol symbol">CBD<span style="font-size: 10px;">A</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Aids sleep</h3>
            <span class="pr-type">Anti-insomnia</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="lime-symbol symbol">CBN</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Reduces risk of artery blockage</h3>
            <span class="pr-type">Anti-ischemic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Inahibits cell growth in tumor/cancer cells</h3>
            <span class="pr-type">Anti-profilerative</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
                <span class="orange-symbol symbol">CBG</span>
                <span class="purple-symbol symbol">CBC</span>
                <span class="teal-symbol symbol">THC<span style="font-size: 10px;">A</span></span>
                <span class="pale-green-symbol symbol">CBD<span style="font-size: 10px;">A</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Treats psoriasis</h3>
            <span class="pr-type">Anti-psoriatic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Tranquilizing, used to manage psychosis    </h3>
            <span class="pr-type">Anti-psychotic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Supresses muscle spasms</h3>
            <span class="pr-type">Anti-spasmodic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="red-symbol symbol">THC</span>
                <span class="blue-symbol symbol">CBD</span>
                <span class="lime-symbol symbol">CBN</span>
                <span class="teal-symbol symbol">THC<span style="font-size: 10px;">A</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Relieves anxiety</h3>
            <span class="pr-type">Anxiotic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Simulates appetite</h3>
            <span class="pr-type">Appetite stimulant</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="red-symbol symbol">THC</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Promotes bone growth</h3>
            <span class="pr-type">Bone stimulant</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
                <span class="orange-symbol symbol">CBG</span>
                <span class="purple-symbol symbol">CBC</span>
                <span class="yellow-symbol symbol">THC<span style="font-size: 10px;">V</span></span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Reduces function in the immune system</h3>
            <span class="pr-type">Immunosuppressive</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Reduces contractions in the small intestines</h3>
            <span class="pr-type">Intestinal Anti-prokinetic</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        <br style="clear: both;" />
        <div class="container-symbol">
            <h3 style="font-size: 18px;">Protects nervous system degeneration</h3>
            <span class="pr-type">Neuroprotective</span><br/>
            <div style="width:100%;margin-top: 5px;position: relative;right: 6px;">
                <span class="blue-symbol symbol">CBD</span>
            </div>
        </div>
        
    </div>

</section>
<?php include('templates/footer.php')  ?>
