<section class="container mobile-view-container">
    <?php foreach($careGivers as $caregiver) {?>
    <div class="caregiver_container accordion">
        <div class="card_style">
            <h2><?=$caregiver->name?></h2>
            <div class="data_form">
                <div class="card_style clearfix">
                    <h3>SECTION 1: Qualifying Patient Information</h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Legal Name: <?=$userRecord->first_name?> <?=$userRecord->last_name?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Date of Birth: <?=$userRecord->dob?></span>
                                <span class="value"> </span>
                            </li>
                            <li>
                                <span class="label">Telephone Number: <?=$userRecord->phone_number?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">City: <?=$userRecord->city?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">State: <?=$userRecord->state?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Zip: <?=$userRecord->zip?></span>
                                <span class="value"></span>
                            </li>
                            <li class="full_width">
                                <span class="label">Home Address: <?=$userRecord->address?></span>
                                <span class="value"></span>
                            </li>
                        </ul>
                        <h4>Medical Provider Written Certification: </h4>
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Issued Date:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">   Expiration Date: </span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card_style clearfix">
                    <h3>SECTION 2: Cultivation Designation </h3>
                    <div class="data_form">
                        <p>___0____ # of plants I will cultivate</p>
                        <p>___6____# of plants my caregiver will cultivate </p>
                        <p>___0____# of plants my dispensary will cultivate</p>
                        <p> Total # (Not to exceed 6) ____6_____ </p>
                        <div class="clearfix check_box">
                            <label>
                                <input type="checkbox" name="" checked="">
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt"> Visiting qualifying patient (must be included as 1 of the 5 patients allowed per caregiver) </span>
                            </label>
                            <label>
                                <input type="checkbox" name="">
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt">Non cultivating caregiver</span>
                            </label>
                        </div>
                        <h4>Medical Provider Written Certification: </h4>
                    </div>
                </div>
                <div class="card_style clearfix">
                    <h3>SECTION 3A: Cultivating Caregiver Information </h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Legal Name: <?=$caregiver->name?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Telephone Number: <?=$caregiver->telephone_number?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">City: <?=$caregiver->city?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">State: <?=$caregiver->state?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Zip: <?=$caregiver->zip_code?></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">County: <?=$caregiver->country?></span>
                                <span class="value"></span>
                            </li>
                            <li class="full_width">
                                <span class="label">Mailing Address: <?=$caregiver->email?></span>
                                <span class="value"></span>
                            </li>
                        </ul>
                        <h4>Caregiver MMMP Registration # assigned to this patient: </h4>
                        <div class="clearfix check_box">
                            <label>
                                <input type="checkbox" name="">
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt">Primary Caregiver is not required to register: Specify exception:</span>
                            </label>
                        </div>
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Start Date:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">End Date:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Termination of Designation Date: </span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>
<!--                <div class="card_style clearfix">
                    <h3>SECTION 3B: Non Cultivating Caregiver Information</h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Legal Name:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Telephone Number:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">City:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">State:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Zip:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">County: </span>
                                <span class="value"></span>
                            </li>
                            <li class="full_width">
                                <span class="label">Mailing Address: </span>
                                <span class="value"></span>
                            </li>
                        </ul>
                        <h4>Caregiver MMMP Registration # assigned to this patient:  </h4>
                        <div class="clearfix check_box">
                            <label>
                                <input type="checkbox" name="">
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt">Primary Caregiver is not required to register: Specify exception: </span>
                            </label>
                        </div>
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Start Date:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">End Date:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Termination of Designation Date: </span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>-->
<!--                <div class="card_style clearfix">
                    <h3>SECTION 4: Dispensary Information</h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Name of Dispensary:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Telephone Number: </span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Name of Dispensary Representative: </span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Start Date:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">End Date:</span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Termination of Designation Date: </span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>-->
                <div class="card_style clearfix">
                    <h3>SECTION 5: Patient Rights and Responsibilities</h3>
                    <div class="data_form">
                        <ul class="with_bullets">
                            <li>My provider has certified that I have a condition that entitles me to participate in the Maine Medical Use of Marijuana Program until ___________________. I have provided you with a copy of my Maine Medical Use of Marijuana Program identification card/MMMP certification and my original designation card as proof that I am authorized to participate in the program. I have also provided you a copy of my Maine issued driver license or other Maine issued photo identification card as proof of my identity. </li>
                            <li>If I am visiting from another state, I have provided you with a copy of the medical use of marijuana certification issued by my state of ________________ as evidence that I live in a state that authorizes marijuana for medical purposes and have a debilitating condition authorized under Maine law. I have also provided you with a copy of my Maine provider certification and a copy of my photographic identification card or driver’s license from my home jurisdiction. As a visiting qualifying patient, I agree to abide by all terms and conditions of the Maine Medical Use of Marijuana Program. </li>
                        </ul>
                        <p>You are hereby authorized to share this caregiver designation form and any copies of documents that I am required to provide to a member of the law enforcement community in order to verify the services you are providing to me are authorized under Maine law.</p>
                        <p>I have the right to terminate this agreement at any time. This MMMP designation form and designation card is my property, and any authorized activity conveyed to you through this designation form terminates upon my notice. You must either dispose of the excess marijuana in your possession on my behalf, or replace me with another qualified patient. You will have 10 days from the date of notice to return this form to me. </p>
                        <p>In the event I terminate this agreement and you do not return this designation form to me, I authorize the Maine Department of Health and Human Services to demand the return of this designation form and card or take other action to enforce the Rules Governing the Maine Medical Use of Marijuana Program, which includes terminating the caregiver number that they assigned to you and that you have listed on this designation form. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    

    <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
        <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
        <div class="jGrowl-notification ">
            <div class="jGrowl-message ajax_message"></div>
        </div>
    </div>
    
    <form id="redirect_stripe" method="post" action="http://54.245.183.187/shaco/product_form.php" style="display: none">
        <input type="text" id="order_id" name="order_id" />
        <input type="text" id="payable_amount" name="payable_amount" />
        <input type="text" id="user_id" name="user_id" value="<?= $this->session->userdata('CUSTOMER-ID') ?>"/>
    </form>
    <button class="btn gradient change_pass submit_caregiver_final">
        <span class="btn-txt">NEXT</span>
    </button>
</section>
<script type="text/javascript">
    $(function () {
        $(document).on('click', '.accordion h3 , .accordion h2', function () {
            $(this).toggleClass('active').next('.data_form').stop().slideToggle();
        })
    });

    $(document).on('click', '.submit_caregiver_final', function () {
        var user_id =   '<?= $this->session->userdata('CUSTOMER-ID') ?>';
        $.ajax({
            type: 'POST',
            data: {user_id:user_id}, 
            url: siteurl + 'cus-caregivers-view',
            dataType: "json",
            beforeSend: function () {
                $('.wait-div').show();
            },
            success: function (response) {
                $('.wait-div').hide();
                $('#jGrowl').fadeIn(600);
                if (response.success)
                {
                    $('#jGrowl .jGrowl-notification').addClass('alert alert-success alert-dismissable').children('.ajax_message').html(response.success_message);

                $('#order_id').val(response.order_id);
                $('#payable_amount').val(response.payable_amount);
                $('#redirect_stripe').submit();
                } else
                {
                    $('#jGrowl .jGrowl-notification').addClass('alert alert-danger alert-dismissable').children('.ajax_message').html(response.error_message);
                }
                setTimeout(function ()
                {
                    $('#jGrowl').fadeOut(600);
                }, 7000);
            }
        });
    });
</script>