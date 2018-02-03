<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>

<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">Manage Customers</h3>
        <!-- SEARCH HEVRE -->
            <div class="col-md-12">
                <form action='<?php echo base_url();?>customers' id="searchData" method="POST">
                <div class="form-group search col-md-12"> 
                   <input type="text" class="search-custom form-control" value="<?php echo $this->input->get('searchText')!= '' ? $this->input->get('searchText'):'';?>" name="searchText" onkeyup="stoppedTyping()" placeholder="Search Customer Name, Email, Location">
                </div>
                <div class="form-group col-md-12">                    
                    <div class="col-md-3">
                        <b>Registered Between</b>
                    </div>
                    <div class=" col-md-3">
                        <input type="text"  class="datetime form-control" id="date_timepicker_start" name="from_time"  />
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="datetime  form-control" id="date_timepicker_end" name="to_time" />
                    </div>                   
                    <div class="col-md-3">
                        <select class="form-control" name="prescription">
                            <option value="0">Prescription type</option>
                            <option value="1">Outbound</option>
                            <option value="2">Inbound</option>
                        </select>
                    </div>
                </div>
                    <div class="form-group col-md-12"> 
                    <div class="form-group col-md-3">
                        <label class="checkbox clearfix">
                            <input type="checkbox" name="preOrder"  />
                            <span class="box_line"> </span>
                            <span class="checkbox_txt">Did Pre-Order</span> 
                        </label>
                    </div>                   
                    <div class="form-group col-md-3">
                        <label class="checkbox clearfix">
                        <input type="checkbox" name="firstTimeUsers"  /> 
                         <span class="box_line"> </span>
                            <span class="checkbox_txt">First time users</span> 
                        </label>
                    </div>                   
                    <div class="form-group col-md-3">
                        <label class="checkbox clearfix">
                        <input type="checkbox" name="nonVerifiedUsers" />
                        <span class="box_line"> </span>
                            <span class="checkbox_txt">Non Verified Users</span> 
                        </label>
                    </div>                   
                    <div class="form-group col-md-3">
                        <input type="submit" class="btn btn-sm green success" value="Apply Filter" />
                        <a href="<?php echo base_url(); ?>customers" class="btn" >Reset</a>
                    </div>                   
                    
                </div>
                   
               </form>
                
            </div>
        
       
       
        <div class="row-fluid top-act">
            <div class="form-group pull-right">
               <a class="btn red reset p-xl-pad" href="<?php echo base_url(); ?>add-customer" id=""><i class="fa fa-plus" style="color:white;"></i> Add New</a>
            </div>
        </div>
        
        
         
        
        <div class="row row_mrg">
            <div class="col-md-12">
                <div class="portlet-body flip-scroll table-scrollable">
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                        <thead class="flip-content">
                            <tr>
                                <th width="50px"> S No.</th>
                                <th class="numeric"> Customer Name </th>
                                <th class="numeric"> Email </th>
                                <th class="numeric"> Location</th>
                                <th class="numeric"> Age </th>
                                <th class="numeric"> Join Date </th>
                                <th class="numeric"> Total Orders </th>
                                <th class="numeric"> Prescriptions</th>
                                <th class="numeric"> Verified</th>
                                <th class="numeric"> Action </th>
                      
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($customerlist) > 0) 
                        {
                            $i = 0;

                            if ( isset($_GET['page']) ) {
                                if ($_GET['page'] == '') {
                                    $i = 0;
                                } else {
                                    $i = ($_GET['page'] - 1 ) * RECORDS_PERPAGE;
                                }
                            }

                            foreach ($customerlist as $key => $list) {
//                                echo "<pre>";print_r($list);
                                $ct = new DateTime(isset($list['createdon']) ? $list['createdon'] : "");
                                $pt = new DateTime(isset($list['postdate']) ? $list['postdate'] : "");
                                
                                if ( !empty($list['email']) ):
                                ?>
                                    <tr>
                                        <td> <?php echo $i + 1; ?> </td>
                                        <td class="numeric editable"><?php echo $list['first_name']." ".$list['last_name']; ?> </td>

                                        <!--<td class="numeric editable"><?php echo ucfirst($list['first_name']." ".$list['last_name']); ?> </td>-->
                                        <td class="numeric editable"><?php echo $list['email'];?></td>
                                        <td class="numeric editable"><?php echo $list['address']; ?></td>
                                        <td class="numeric editable">
                                            <?php
                                                $from = new DateTime($list['dob']);
                                                $to   = new DateTime();
                                                echo $from->diff($to)->y;

                                            ?>
                                        </td>
                                        
                                         <td class="numeric editable"    ><?php echo date(date('d-m-Y',strtotime($list['created_at'])));?></td>
                                         <td class="numeric editable"    ><?php echo $list['orders_count'];?></td>
                                         <td class="numeric editable"    ><?php if($list['uploaded_by']=='1'){ echo "Outbound"; }else if($list['uploaded_by']=='0'){  echo "Inbound";  }else{ echo "Not Added"; } ?></td>
                                         <td class="text-center">
                                            <?php if ( $list['is_verified'] == 1 ): ?>
                                                <span class="fa fa-check text-success"></span>
                                            <?php else: ?>
                                                <span class="fa fa-times text-danger"></span>
                                            <?php endif; ?>
                                         </td>
                                        <td class="action">
                                            <span class="no_wrap">
                                            <?php 
                                            
                                            echo '<a title="View Details" id="view" href="'.base_url().'view-customer/'.$list['id'].'" class="btn btn-default btn-xs"> <i class="fa fa-eye" style="color:green;"></i> </a>';
                                            ?>
                                            </span>
                                        </td>                                            
                                    </tr>                              
                                <?php
                                else: ?>
                                <tr>
                                    <td colspan="20" style="text-align: center"> No Record Found </td>
                                </tr>
                                <?php endif;

                                $i++;
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="20" style="text-align: center"> No Record Found </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="row row_mrg paginate">
                        <div class="col-sm-12">
                            <?php if($this->input->get('searchText') != '' || $this->input->get('all')){ ?>
                                <span  class="right show-more" ><a href="<?php echo base_url();?>customers" data-ci-pagination-page="2" rel="next">Back</a></span>
                            <?php }else{ ?>
                                <span  class="right show-more" ><?php echo $this->pagination->create_links(); ?><a class= "btn" href="<?php echo base_url();?>customers?all=true" data-ci-pagination-page="2" rel="next">All</a></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $this->load->view('templates/footer'); ?>
<script type="text/javascript">
jQuery(document).ready(function () {
    //--- Start Date  
    jQuery('#date_timepicker_start').datetimepicker({
        format:'Y-m-d',
        //value:'<?php echo date('Y-m-d'); ?>',
        mask :'',
        onShow:function( ct ){
         this.setOptions({
          maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
         })
        },
        timepicker:false
    });
    //--- End Date
    jQuery('#date_timepicker_end').datetimepicker({
        format:'Y-m-d',
        //value:'<?php echo date('Y-m-d'); ?>',
        mask : '',
        onShow:function( ct ){
         this.setOptions({
          minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false,
         })
        },
        maxDate:'+1970/01/01',
        timepicker:false
    });
});
</script>