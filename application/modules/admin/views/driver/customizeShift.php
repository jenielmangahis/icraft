<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">Manage Shift</h3>
        <div class="col-md-6 padLeftZero">
            <?php if ($this->session->flashdata('success_message')) { ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('success_message') ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('errors_message')) { ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('errors_message') ?> </div>
            <?php } ?>   
            <fieldset class="customFieldset">
                <div class="portlet-body flip-scroll table-scrollable" >
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                        <thead class="flip-content">
                            <tr>
                                <td><b>Date</b></td>
                                <td><b><?php echo date("d-m-Y", strtotime($driverShift['date'])); ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Day</b></td>
                                <td><b><?php echo date("D", strtotime($driverShift['date'])); ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Total Work Hours</b></td>
                                <td><b><?php echo $driverShift['total_time']; ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Total Break Hours</b></td>
                                <td><b> <?php echo $totalBreakTime['total_break_time_taken']; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Total Breaks Taken</b></td>
                                <td><b><?php echo $totalBreakTime['total_break_taken']; ?></b></td>
                            </tr>


                        </thead>

                    </table>
                </div>
            </fieldset>    

        </div>
        <div class="col-md-12 padLeftZero">
            <h4>Worked time</h4>
            <fieldset class="customFieldset">
                <div class="portlet-body flip-scroll table-scrollable" >

                    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                        <thead class="flip-content">
                            <?php if (count($driverbreakShift) > 0) { ?>
                                <tr>
                                    <td><b>Action</b></td>
                                    <td><b>Time</b></td>
                                    <td><b></b></td>
                                </tr>
                            </thead>
                            <tr>
                                <td>Shift Start</td>
                                <td><span><?php 
                                if($driverShift['edited_start_time'] && $driverShift['edited_start_time'] !="00:00:00"){
                                    echo $driverShift['edited_start_time']; 
                                }else{
                                    echo $driverShift['start_time']; 
                                }
                                ?></span>
                                    <input type="text" name="time"  class="timepicker" style="display:none;">
                                    
                                </td>
                                <td>
                                    <a class="btn red p-xl-pad editShiftTime" edit-type="start_time" id="<?php echo $driverShift['shift_id']; ?>" edit="shift" href="javascript:void(0);">Edit</a>
                                    <button type="button"  old-value="<?php 
                                if($driverShift['edited_start_time'] && $driverShift['edited_start_time'] !="00:00:00"){
                                    echo $driverShift['edited_start_time']; 
                                }else{
                                    echo $driverShift['start_time']; 
                                }
                                ?>" class="btn btn-danger edit-time-cancel" style="display:none;">Cancel</button>
                            </tr>   

                            <?php foreach ($driverbreakShift as $index => $val) { ?>
                                <tr>
                                    <td>Break Start</td>
                                    <td><span><?php 
                                    if($val['edited_start_time'] && $val['edited_start_time'] !="00:00:00"){
                                        echo $val['edited_start_time'];    
                                    }else{
                                        echo $val['start_time'];
                                    }
                                    ?></span>
                                        <input type="text" name="time"  class="timepicker" style="display:none;">
                                    </td>
                                    <td><a class="btn red p-xl-pad editShiftTime" edit-type="start_time"  id="<?php echo $val['break_id']; ?>" edit="break" href="javascript:void(0);">Edit</a>
                                 <button type="button" old-value="<?php 
                                    if($val['edited_start_time'] && $val['edited_start_time'] !="00:00:00"){
                                        echo $val['edited_start_time'];    
                                    }else{
                                        echo $val['start_time'];
                                    }
                                    ?>" class="btn btn-danger edit-time-cancel" style="display:none;">Cancel</button>        
                                </tr>
                                <tr>
                                    <td>Break End</td>
                                    <td><span><?php
                                    if($val['edited_end_time'] && $val['edited_end_time'] !="00:00:00"){
                                        echo $val['edited_end_time'];
                                    }else{
                                         echo $val['end_time']; 
                                    }
                                    ?></span>
                                        <input type="text" name="time"  class="timepicker" style="display:none;">
                                    </td>

                                    <td><a class="btn red p-xl-pad editShiftTime"  edit-type="end_time"  id="<?php echo $val['break_id']; ?>" edit="break" href="javascript:void(0);">Edit</a>
                                        <button  old-value="<?php
                                    if($val['edited_end_time'] && $val['edited_end_time'] !="00:00:00"){
                                        echo $val['edited_end_time'];
                                    }else{
                                         echo $val['end_time']; 
                                    }
                                    ?>" type="button" class="btn btn-danger edit-time-cancel" style="display:none;">Cancel</button>
                                </tr>

                            <?php } ?>
                            <tr>
                                <td>Shift End</td>
                                <td><span><?php
                                if($driverShift['edited_end_time'] && $driverShift['edited_end_time'] !="00:00:00"){
                                    echo $driverShift['edited_end_time'];
                                }else{
                                    echo $driverShift['end_time'];
                                }
                                ?></span>
                                    <input type="text" name="time"  class="timepicker" style="display:none;">
                                </td>
                                <td><a class="btn red p-xl-pad editShiftTime" edit-type="end_time"  id="<?php echo $driverShift['shift_id']; ?>" edit="shift" href="javascript:void(0);">Edit</a>
                                   <button type="button" old-value="<?php
                                if($driverShift['edited_end_time'] && $driverShift['edited_end_time'] !="00:00:00"){
                                    echo $driverShift['edited_end_time'];
                                }else{
                                    echo $driverShift['end_time'];
                                }
                                ?>" class="btn btn-danger edit-time-cancel" style="display:none;">Cancel</button>
                            </tr> 
                        <?php } else { ?>
                            <tr>
                                <td colspan="5"><p class="align_center">No data found</p></td>
                            </tr>
                        <?php } ?>
                    </table>

                </div>
            </fieldset>  
            <p>
                <span>TOTAL DISTANCE TRAVELLED</span> :
                <span style="margin-left: 31px;">
<?php echo number_format((float) $deliveryDetails['distance_in_km'], 2, '.', ''); ?> km
                </span>
            </p>
            <p>
                <span>TOTAL DELIVERIES MADE</span>  :
                <span style="margin-left: 52px;"> 
<?php echo $deliveryDetails['totaldelivery']; ?>
                </span>
            </p>
            <br/>
            <p>
                <span><b>TOTAL PAYABLE AMOUNT</b></span> 
                <span id="shift_payable_amount" style="margin-left: 31px;">
                   <?php echo $driverShift['payable_amount']; ?> 
                   
                </span>
                <span>
                    <input type="text" id="shift_amount"  class="" style="display: none;">  
                </span>
                <span style="margin-left: 31px;">
                   
                    <a id="<?php echo $driverShift['shift_id']; ?>"  old-value="<?php
                                if($driverShift['original_payable_amount']){
                                    echo $driverShift['original_payable_amount'];
                                }else{
                                    echo $driverShift['payable_amount'];
                                }
                                ?>" class="btn red p-xl-pad editShiftPayment" href="javascript:void(0);">Adjust pay</a>
                    <button type="button" class="btn btn-danger edit-payment-cancel" style="display:none;">Cancel</button>
                </span>
            </p>
        </div>  
    </div>
    <!-- Model for Block User -->
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript">
    $('.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 10,
        minTime: '0',
        maxTime: '11:00pm',
        defaultTime: '00:00',
        startTime: '12:00am',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
    
    $(document).on("click",".editShiftTime",function() {
      
        $(this).text('Save');
        $(this).removeClass('editShiftTime');
        $(this).addClass('timeSave');
        $(this).closest("td").prev('td').find("span").css("display", "none");
        $(this).closest("td").prev('td').find("input.timepicker").css("display", "inline-block");
        $(this).closest('td').find('button.edit-time-cancel').css("display", "inline-block");
    });

    
    $(document).on("click",".edit-time-cancel",function() {
        var oldVal = $(this).attr('old-value'); 
        $(this).closest("td").prev('td').find("span").text(oldVal);
        $(this).closest('td').find('a').text("Edit");
        $(this).closest('td').find('a').addClass('editShiftTime');
        $(this).closest('td').find('a').removeClass('timeSave');
        
        
        $(this).closest("td").prev('td').find("span").css("display", "inline-block");
        $(this).closest("td").prev('td').find("input.timepicker").css("display", "none");
        $(this).css("display", "none");
    });
    
    $(document).on("click",".timeSave",function() {
       
        var time     = $(this).closest("td").prev('td').find("input.timepicker").val();
        var editType = $(this).attr('edit-type');
        var edit     = $(this).attr('edit');
        var id       = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>driverShiftTimeEdit",
            data: {time:time,editType:editType,edit:edit,id:id},
            success: function(data){
              location.reload(); 
            }
        });  
    });
    
    $(document).on("click",".editShiftPayment",function() {
        $("#shift_payable_amount").hide();
        $("#shift_amount").css("display", "inline-block");
        $(".edit-payment-cancel").css("display", "inline-block");
        $(this).text('Save');
       
        
        $(this).addClass('amountSave');
        $(this).removeClass('editShiftPayment');
        
    });
    
    $(document).on("click",".edit-payment-cancel",function() {
        $("#shift_payable_amount").show();
        $("#shift_amount").css("display", "none");
        $(".edit-payment-cancel").css("display", "none");
        $(".amountSave").text('Adjust pay');
       
        
        $(".amountSave").addClass('editShiftPayment');
        $(".amountSave").removeClass('amountSave');
    });
    
    
    $("#shift_amount").on("keyup", function(){
        var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
            val = this.value;

        if(!valid){
            console.log("Invalid input!");
            this.value = val.substring(0, val.length - 1);
        }
    });
    
    $(document).on("click",".amountSave",function() {
        var amount   = $("#shift_amount").val();
        var original_payable_amount   =  $(this).attr('old-value');
        var id       = $(this).attr('id');
        
        if(amount !=""){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>driverShiftAmountEdit",
                data: {shift_id:id,payable_amount:amount,original_payable_amount:original_payable_amount},
                success: function(data){
                  location.reload(); 
                }
            });  
        }
    });
    
    
</script> 


<?php echo $this->load->view('templates/footer'); ?>
