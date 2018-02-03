<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
        <?php echo validation_errors();?>
	<form class="login-form" id="forgotPassword" action="<?php echo base_url()?>forgot_password" method="post">
		<h3 class="form-title">Change Password</h3>
                <?php if ($this->session->userdata('SuccessMsg') != "") {  ?>
                    <div class="success alert-info toBeHidden" role="alert">
                        <?php echo $this->session->userdata('SuccessMsg');
                            $this->session->unset_userdata('SuccessMsg');
                        ?>
                    </div>
                <?php }
                        if ($this->session->userdata('errorMsg') != "") { 
                        ?>
                        <div class="alert alert-danger toBeHidden" role="alert"> 
                            <?php echo $this->session->userdata('errorMsg');
                                $this->session->unset_userdata('errorMsg');
                            ?>
                        </div>
                 <?php  } ?>
		<div class="form-group">
			<label class="control-label">New Password</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" id="new_password" placeholder="New Password" name="new_password"/>
		</div>
		<div class="form-group">
			<label class="control-label">Re-enter Password</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" id="confirm_password" placeholder="Confirm Password" name="confirm_password"/>
		</div>
		<div class="form-actions log_btn">
                    <input type="hidden" name="userEmail" value="<?php echo base64_decode(trim($this->input->get('email'))); ?>" />
			<button type="submit" class="btn btn-success uppercase" name="submit" value="Save">Save</button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
</div>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script>
    jQuery.validator.setDefaults({
        debug: false,
        success: "valid"
    });

          $("#forgotPassword").validate({
            rules: {

                new_password: {
                    required: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            }
        });
</script>