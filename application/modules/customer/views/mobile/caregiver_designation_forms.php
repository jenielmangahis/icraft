<section class="container mobile-view-container">
    <div class="caregiver_container accordion">
        <div class="card_style">
            <h2><?php echo "Caregiver Form" ?></h2>
            <div class="data_form">

                <div class="card_style clearfix">
                    <h3>SECTION 1: Qualifying Patient Information </h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Legal Name: <input type="text" id="legal_name" name="legal_name" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Date of Birth: <input type="text" id="birthday" name="birthday"  /></span>
                                <span class="value"> </span>
                            </li>
                            <li>
                                <span class="label">Telephone Number: <input type="text" id="telephone" name="telephone" /></span>
                                <span class="value"></span>
                            </li>
                            <li class="full_width">
                                <span class="label">Home Address: <input type="text" id="address" name="address" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">City: <input type="text" id="city" name="city" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">State: <input type="text" id="state" name="state" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Zip: <input type="text" id="zip" name="zip" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Country: <input type="text" id="country" name="country" /></span>
                                <span class="value"></span>
                            </li>
                        </ul>
                        <h4>Medical Provider Written Certification: </h4>
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Issued Date: <input type="text" id="date_issued"></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">   Expiration Date: <input type="text" id="expiration_date" name="expiration_date" /> </span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card_style clearfix">
                    <h3>SECTION 2: Cultivation Designation </h3>
                    <div class="data_form">
                        <p><input type="text" id="number_of_plants" name="number_of_plants" /> # of plants I will cultivate</p>
                        <p><input type="text" id="number_of_plants_caregiver_cultivate" name="number_of_plants_caregiver_cultivate" /># of plants my caregiver will cultivate </p>
                        <p><input type="text" id="number_of_plants_dispensary" name="number_of_plants_dispensary" /># of plants my dispensary will cultivate</p>
                        <p> Total # (Not to exceed 6) <input type="text" id="total_not_exceed_6" name="total_not_exceed_6" /> </p>
                        <div class="clearfix check_box">
                            <label>
                                <input type="checkbox" name="section_2_checkbox_visit_qualifying_patient" id="section_2_checkbox_visit_qualifying_patient" checked="">
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt"> Visiting qualifying patient (must be included as 1 of the 5 patients allowed per caregiver) </span>
                            </label>
                            <label>
                                <input type="checkbox" id="section_2_checkbox_cultivate_caregiver" name="section_2_checkbox_cultivate_caregiver">
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt">Non cultivating caregiver</span>
                            </label>
                        </div>
                        <h4>A patient may designate either a primary caregiver or a dispensary to cultivate</h4>
                        <p> For questions regarding this program, please contact the following: </p>
                        <p> Department of Health and Human Services </p>
                        <p> Maine Center for Disease Control and Prevention </p>
                        <p> Maine Medical Use of Marijuana Program </p>  
                        <p> 286 Water Street </p>
                        <p> 11 State House Station </p>
                        <p> Augusta, ME 04333-0011 </p>
                        <p> Tel: (207) 287-8016   Fax: (207) 287-2671   TTY Users: Dial 711 (Maine Relay)</p>
                        <p> Email: dhhs.mmmp@maine.gov </p>
                        <p> Website: www.mainepublichealth.gov/mmm </p>
                    </div>
                </div>


                <div class="card_style clearfix">
                    <h3>SECTION 3A: Cultivating Caregiver Information </h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Legal Name: <input type="text" id="sec_3a_legal_name" name="sec_3a_legal_name"/></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Telephone Number: <input type="text" id="sec_3a_telephone" name="sec_3a_telephone" /></span>
                                <span class="value"></span>
                            </li>
                             <li class="full_width">
                                <span class="label">Mailing Address: <input type="text" id="sec_3a_mailing_add" name="sec_3a_mailing_add" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">City: <input type="text" id="sec_3a_city" name="sec_3a_city" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">State: <input type="text" id="sec_3a_state" name="sec_3a_state" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Zip: <input type="text" id="sec_3a_zip" name="sec_3a_zip" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">County: <input type="text" id="sec_3a_country" name="sec_3a_country" /></span>
                                <span class="value"></span>
                            </li>
                           
                        </ul>
                        <h4>Caregiver MMMP Registration # assigned to this patient: </h4>
                        <div class="clearfix check_box">
                            <label>
                                <input type="checkbox" name="sec_3a_primary_caregiver" id="sec_3a_primary_caregiver" >
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt">Primary Caregiver is not required to register: Specify exception:</span>
                            </label>
                        </div>
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Start Date: <input type="text" id="sec_3a_start_date" name="sec_3a_start_date" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">End Date: <input type="text" id="sec_3a_end_date" name="sec_3a_end_date" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Termination of Designation Date: <input type="text" id="sec_3a_termination_date" name="sec_3a_termination_date" /></span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card_style clearfix">
                    <h3>SECTION 3B: Non Cultivating Caregiver Information </h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Legal Name: <input type="text" id="sec_3b_legal_name" name="sec_3b_legal_name"/></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Telephone Number: <input type="text" id="sec_3b_telephone" name="sec_3b_telephone" /></span>
                                <span class="value"></span>
                            </li>
                             <li class="full_width">
                                <span class="label">Mailing Address: <input type="text" id="sec_3b_mailing_add" name="sec_3b_mailing_add" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">City: <input type="text" id="sec_3b_city" name="sec_3b_city" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">State: <input type="text" id="sec_3b_state" name="sec_3b_state" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Zip: <input type="text" id="sec_3b_zip" name="sec_3b_zip" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">County: <input type="text" id="sec_3b_country" name="sec_3b_country" /></span>
                                <span class="value"></span>
                            </li>
                           
                        </ul>
                        <h4>Caregiver MMMP Registration # assigned to this patient: </h4>
                        <div class="clearfix check_box">
                            <label>
                                <input type="checkbox" name="sec_3b_primary_caregiver" id="sec_3b_primary_caregiver" >
                                <span class="tick_container"><i class="icon-checked"></i></span>
                                <span class="txt">Primary Caregiver is not required to register: Specify exception:</span>
                            </label>
                        </div>
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Start Date: <input type="text" id="sec_3b_start_date" name="sec_3b_start_date" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">End Date: <input type="text" id="sec_3b_end_date" name="sec_3b_end_date" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Termination of Designation Date: <input type="text" id="sec_3b_termination_date" name="sec_3b_termination_date" /></span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>


                 <div class="card_style clearfix">
                    <h3>SECTION 4: Dispensary Information </h3>
                    <div class="data_form">
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Name of Dispensary: <input type="text" id="sec_4_name_dispensary" name="sec_4_name_dispensary"/></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Physical Address: <input type="text" id="sec_4_physical_address" name="sec_4_physical_address" /></span>
                                <span class="value"></span>
                            </li>
                             <li class="full_width">
                                <span class="label">Telephone Number: <input type="text" id="sec_4_telephone" name="sec_4_telephone" /></span>
                                <span class="value"></span>
                            </li>
                            
                        </ul>
                        <h4>Name of Dispensary Representative: </h4>
                        <div class="clearfix check_box">
                            <label>
                                <span class="txt"><input type="text" id="sec_4_name_dispensary_rep"></span>
                            </label>
                        </div>
                        <ul class="opposite_detail">
                            <li>
                                <span class="label">Start Date: <input type="text" id="sec_4_start_date" name="sec_4_start_date" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">End Date: <input type="text" id="sec_4_end_date" name="sec_4_end_date" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Termination of Designation Date: <input type="text" id="sec_4_termination_date" name="sec_4_termination_date" /></span>
                                <span class="value"></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card_style clearfix">
                    <h3>SECTION 5: Patient Rights and Responsibilities</h3>
                    <div class="data_form">
                        <ul class="with_bullets">
                            <li>My provider has certified that I have a condition that entitles me to participate in the Maine Medical Use of Marijuana Program until <input type="text" id="sec_5_program_date" name="sec_5_program_date" />. I have provided you with a copy of my Maine Medical Use of Marijuana Program identification card/MMMP certification and my original designation card as proof that I am authorized to participate in the program. I have also provided you a copy of my Maine issued driver license or other Maine issued photo identification card as proof of my identity. </li>
                            <li>If I am visiting from another state, I have provided you with a copy of the medical use of marijuana certification issued by my state of <input type="text" id="sec_5_state" name="sec_5_state" /> as evidence that I live in a state that authorizes marijuana for medical purposes and have a debilitating condition authorized under Maine law. I have also provided you with a copy of my Maine provider certification and a copy of my photographic identification card or driver’s license from my home jurisdiction. As a visiting qualifying patient, I agree to abide by all terms and conditions of the Maine Medical Use of Marijuana Program. </li>
                        </ul>
                        <p>You are hereby authorized to share this caregiver designation form and any copies of documents that I am required to provide to a member of the law enforcement community in order to verify the services you are providing to me are authorized under Maine law.</p>
                        <p>I have the right to terminate this agreement at any time. This MMMP designation form and designation card is my property, and any authorized activity conveyed to you through this designation form terminates upon my notice. You must either dispose of the excess marijuana in your possession on my behalf, or replace me with another qualified patient. You will have 10 days from the date of notice to return this form to me. </p>
                        <p>In the event I terminate this agreement and you do not return this designation form to me, I authorize the Maine Department of Health and Human Services to demand the return of this designation form and card or take other action to enforce the Rules Governing the Maine Medical Use of Marijuana Program, which includes terminating the caregiver number that they assigned to you and that you have listed on this designation form. </p>
                    </div>

                    <ul class="opposite_detail">
                             <li>
                                <span class="label">Print name of patient/guardian : <input type="text" id="sec_5_printed_patient_guardian" name="sec_5_printed_patient_guardian" /></span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Signature of patient/guardian : <input type="text" id="sec_5_signature_patient_guardian" name="sec_5_signature_patient_guardian" /> </span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Date: <input type="text" id="sec_5_date_patient_guardian" name="sec_5_date_patient_guardian" /> </span>
                                <span class="value"></span>
                            </li>
                            <li>
                                <span class="label">Print name of designee: <input type="text" id="sec_5_printed_designee" name="sec_5_printed_designee" /></span>
                                <span class="value"></span>
                            </li>
                             <li>
                                <span class="label">Signature of designee: <input type="text" id="sec_5_signature_designee" name="sec_5_signature_designee" /></span>
                                <span class="value"></span>
                            </li>
                             <li>
                                <span class="label">Date: <input type="text" id="sec_5_date_designee" name="sec_5_date_designee" /></span>
                                <span class="value"></span>
                            </li>
                             <li>
                                <span class="label">Numeric identification assigned by the designee: <input type="text" id="sec_5_numeric_assigned_designee" name="sec_5_numeric_assigned_designee" /></span>
                                <span class="value"></span>
                            </li>

                        </ul> 
                </div>
            </div>
        </div>
    </div>
    
    

    <div id="jGrowl" class="top-right jGrowl col-md-12"  style="display: none;">
        <button class="close" aria-hidden="true" data-dismiss="alert" style="padding:10px;" type="button">&times;</button>
        <div class="jGrowl-notification ">
            <div class="jGrowl-message ajax_message"></div>
        </div>
    </div>
    
 
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