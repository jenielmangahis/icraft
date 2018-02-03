<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">Add Driver</h3>
        <?php echo validation_errors(); ?>

        <?php if ($this->session->userdata('SuccessMsg') != "") { ?>
            <div class="success alert-info toBeHidden custom-success" role="alert">
                <?php
                echo $this->session->userdata('SuccessMsg');
                $this->session->unset_userdata('SuccessMsg');
                ?>
            </div>
        <?php } ?>

        <?php if ($this->session->userdata('errorMsg') != "") {
            ?>
            <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                <?php
                echo $this->session->userdata('errorMsg');
                $this->session->unset_userdata('errorMsg');
                ?>
            </div>
<?php } ?>
        <!------------------content start ------------------------------>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form class="form-horizontal" id="addDriver" name="addDriver" action="<?php echo base_url();?>save-drivers" role="form" enctype='multipart/form-data' method="POST">
                <div class="form-body">
                    <h3 class="form-section">Driver Details</h3>
                    <div class="row">
                        <div class="col-md-3">
                        <input type='file' name="driver_image" id="driver_image" onchange="DriverImageURL(this);" />
                        <img id="blah" height="105px" width="105px" src="" alt="Driver image" />
                           
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
                               <input type="text" class="form-control" name="ssn" id="ssn" placeholder="SSN">
                                </div>
                            </div>
                              <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="driving_license" id="driving_license" placeholder="Driving License Number">
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
                               <input type="text" class="form-control" name="hourly_pay" id="hourly_pay" placeholder="Hourly Pay Rate">
                                </div>
                                 
                            </div>
                        </div>
                        <!--/span-->
                        
                        
                    </div>
                   
                   
                    <!--/row-->
                    <h3 class="form-section">Vehicle Details</h3>
                    <div class="row">
                        <div class="col-md-3">
                       
                        <input type='file' name="vehicle_image" id="vehicle_image" onchange="VehicleImageURL(this);" />
                        <img id="vehicleimage" height="105px" width="105px" src="" alt="Vehicle image" />
                       
                            
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" name="make" id="make" class="form-control" placeholder="Make">
                                </div>
                            </div>
                              <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="model" id="model" placeholder="Model">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="color" id="color" placeholder="Color">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control" name="registration_number" id="registration_number" placeholder="Registration Number">
                                </div>
                                 
                            </div>
                             <div class="form-group">
                                <div class="col-md-12">
                               <input type="text" class="form-control datetime" name="manufactur_date" id="manufactur_date" placeholder="Manufacture Date">
                                </div>
                                 
                            </div>
                        </div>
                        <!--/span-->
                        
                         <!--/span-->
                        <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-md-12">
                               <div class="col-md-6">    
                               <input type="text" class="form-control" name="document1" id="document1" placeholder="Document Name">
                               </div>
                                    
                              <div class="col-md-6">
                               <input type='file' name="document_image1" />
                              </div>
                            </div>
                        </div>
                        <!--/span-->
                        
                       </div>
                   
                         <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-md-12">
                               <div class="col-md-6">    
                               <input type="text" class="form-control" name="document2" id="document2" placeholder="Document Name">
                               </div>
                                    
                              <div class="col-md-6">
                               <input type='file' name="document_image2" id="document_image22" />
                              </div>
                            </div>
                        </div>
                        <!--/span-->
                        
                       </div>
                   
                         <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-md-12">
                               <div class="col-md-6">    
                               <input type="text" class="form-control" name="document3" id="document3" placeholder="Document Name">
                               </div>
                                    
                              <div class="col-md-6">
                               <input type='file' name="document_image3" id="document_image3" />
                              </div>
                            </div>
                        </div>
                        <!--/span-->
                        
                       </div>
                   
                </div>
                    
                  <!--/row-->
                    <h3 class="form-section">Shift Management</h3>
                    <div class="row">
                       
                        <!--/span-->
                        <div class="col-md-12">
                        <div class="col-md-2">
                           Working Days: 
                        </div>
                         <div class="col-md-10">
                         <div class="form-group">   
                          <input type="checkbox" name="sunday" id="sunday" /> Sunday 
                          <input type="checkbox" name="monday" id="monday" /> Monday
                          <input type="checkbox" name="tuseday" id="tuseday" /> Tuseday 
                          <input type="checkbox" name="wednesday" id="wednesday" /> Wednesday
                          <input type="checkbox" name="thursday" id="thursday" /> Thursday
                          <input type="checkbox" name="friday" id="friday" /> Friday
                          <input type="checkbox" name="saturday" id="saturday" /> Saturday
                         </div>
                         </div>
                        </div>
                        <!--/span-->
                        
                        <div class="col-md-12 margin-top-20">
                        <div class="col-md-2">
                           WOrking Time: 
                        </div>
                         <div class="col-md-10">
                           <div class="col-md-5">
                          <input class="form-control" type="text" name="from_time" id="from_time" placeholder="Start Time" /> 
                           </div>
                             <div class="col-md-5">
                          <input class="form-control" type="text" name="to_time" id="to_time" placeholder="End Time" /> 
                             </div>
                           
                         </div>
                         
                        </div>
                        
                        
                        <div class="col-md-12 margin-top-20 margin-bottom-25">
                         
                             <div class="col-md-2">
                              Starting Location:   
                             </div>
                          
                             <div class="col-md-6">
                                 <select class="form-control" name="warehouse" id="warehouse">
                                      <option value="">Select Location</option>
                                       <?php foreach($warehouses as $warehouses){ ?>
                                        <option value="<?php echo $warehouses['id']; ?>"><?php echo $warehouses['name']; ?></option>   
                                       <?php } ?>
                                       
                                </select>
                             </div>
                             
                         
                        </div>
                        
                        
                        
                        
                        
                        </div>   
                    
                    
                    
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green"><i class="fa fa-pencil"></i>Save</button>
                                    <button type="button" class="btn default">Cancel</button>
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




<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>-->
<script>
function DriverImageURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function VehicleImageURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#vehicleimage')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>
<script>
     jQuery(document).ready(function () {
        jQuery('#manufactur_date').datetimepicker({
            format:'Y-m-d',
            mask :'',
            timepicker:false,
        });
        
        
        jQuery('#from_time').datetimepicker({
            format:'H:i',
            mask :'',
            datepicker:false,
        });
        
         jQuery('#to_time').datetimepicker({
            format:'H:i',
            mask :'',
            datepicker:false,
        });
        
        
        
        });
</script>


