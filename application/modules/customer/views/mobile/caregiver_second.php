<link rel="stylesheet" href="<?= $this->config->item('customerassets') ?>css/signature-pad.css">
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>
<section class="container mobile-view-container">
    <div class="checkout_container">
        <p class="fs_15"><b>Section 5:</b> Patient Rights &nbsp; Responsibilities</p>
        <div class="signature">
            <h2>Patient Name</h2>
            <span class="date_signature"><?= date('Y-m-d')?></span>
            <div class="signature-view">
                
                <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad--body">
                        <canvas></canvas>
                    </div>
                    <div class="signature-pad--footer">
                        <div class="description">Sign above</div>

                        <div class="signature-pad--actions">
                            <div class="d-felx align-items-center justify-content-start flex-nowrap px-2">
                                <button type="button" class="btn col rounded-0 mb-2" data-action="clear">Clear</button>
                                <button type="button" class="btn col rounded-0 mb-2" data-action="change-color" style="display: none">Change color</button>
                                <button type="button" class="btn col rounded-0" data-action="undo">Undo</button>
                            </div>
                            <div>
                                <button type="button" class="button save save_png" data-action="save-png" style="display: none">Save as PNG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="input_container">
            My provider has certified that I have a condition that entitles me to participate in the Maine Medical Use of Marijuana Program until
            <input type="text" name="" disabled="">. I have provided you witha copy of my Maine Medical Use of Marijuana Program identification card/MMMP certificationand my original designation cardas proof that I am authorized to participate in the program. I have also provided you a copy of my Maine issued driver license or other Maine issued photo identification card as proof of my identity.
        </div>
        <div class="input_container">
            If I am visiting from another state, I have provided you with a copy of the medical use of marijuana certification issued by my state of
            <input type="text" name="" disabled=""> as evidence that I live in a state that authorizes marijuana for medical purposes and have a debilitating condition authorized under Maine law. I have also provided you with a copy of my Maine provider certification and a copy of my photographic identification card or driver’s license frommy home jurisdiction. As a visiting qualifying patient, I agree to abide by all terms and conditions of the Maine Medical Use of Marijuana Program.
        </div>
        <p>You are hereby authorized to share this caregiver designation form and any copies of documents that I am required to provide to a member of the law enforcement community in order toverify the services you are providing to me are authorized under Maine law.</p>

        <p>I have the right to terminate this agreement at anytime. This MMMP designation formand designation cardis my property, and any authorized activity conveyed to you through this designation form terminates upon my notice. You must either dispose of the excess marijuana in your possession on my behalf, or replace me with another qualified patient. You will have 10 days from the date of notice to return this form to me.</p>

        <p>In the event I terminate this agreement and you do not return this designation form to me, I authorize the Maine Department of Health and Human Services to demand the return of this designation formand cardor take other action to enforce the Rules Governing the Maine Medical Use of Marijuana Program, which includes terminating the caregiver number that they assigned to you and that you have listed on this designation form.</p>
        
        <form id="myAwesomeForm" method="post" action="" style="display: none">
            <input type="text" id="filename" name="filename" />  Filename 
        </form>

        <button class="btn gradient change_pass submit_caregiver_second">
            <span class="btn-txt">NEXT</span>
        </button>

    </div>
</section>

<script src="<?= $this->config->item('customerassets') ?>js/signature_pad.js"></script>
<script src="<?= $this->config->item('customerassets') ?>js/app.js"></script>
<script>
    $(document).on('click', '.submit_caregiver_second', function () {
        $('.save_png').click();
    });
</script>