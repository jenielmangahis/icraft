<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">Add Customer</h3>
        <?php echo validation_errors(); ?>

        <?php if ($this->session->userdata('success') != "") { ?>
            <div class="success alert-info toBeHidden custom-success" role="alert">
                <?php
                echo $this->session->userdata('success');
                $this->session->unset_userdata('success');
                ?>
            </div>
        <?php } ?>

        <?php if ($this->session->userdata('error') != "") {
            ?>
            <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                <?php
                echo $this->session->userdata('error');
                $this->session->unset_userdata('error');
                ?>
            </div>
<?php } ?>
        <!------------------content start ------------------------------>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form class="form-horizontal" id="addDriver" name="addDriver" action="<?php echo base_url();?>save-customer" role="form" enctype='multipart/form-data' method="POST">
                <div class="form-body">
                    <h3 class="form-section">Customer Details</h3>
                    <div class="row">
                        <div class="col-md-3">
                        <input type='file' name="profile_pic" id="" onchange="customerImageURL(this);" />
                        <img id="blah" height="105px" width="105px" src="" alt="Customer image" />
                           
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                                </div>
                            </div>
                              <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Contact Number">
                                </div>
                                 
                            </div>
                        </div>
                        <!--/span-->
                        
                         <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="dob" id="date_timepicker_start" placeholder="Date of Birth">
                                </div>
                            </div>
                            <div class="form-group">
                               <div class="col-md-12">
                                   <select class="form-control" name="gender" id="gender">
                                       <option value="1">Male</option>   
                                       <option value="2">Female</option>
                                   </select>
                               </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                </div>
                            </div>
                             
                            
                        </div>
                        <!--/span-->
                        
                        
                    </div>
                   
             
                    
                    
                    
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green"><i class="fa fa-pencil"></i>Save</button>
                                    <button type="button" onclick="javascript:history.go(-1)" class="btn default">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
           
        </div>
          </form>
            <!-- END FORM-->       
        <!------------------content end---------------------------------->


    </div>
</div>
</div>

<?php echo $this->load->view('templates/footer'); ?>


<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>-->
<script type="text/javascript">
jQuery(document).ready(function () {
    //--- Start Date  
    jQuery('#date_timepicker_start').datetimepicker({
        format:'Y-m-d',
        value:'<?php echo date('Y-m-d'); ?>',
        mask :'',        
        timepicker:false
    });
    
});
function customerImageURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>


