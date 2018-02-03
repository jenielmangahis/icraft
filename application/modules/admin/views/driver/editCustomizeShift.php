<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <div class="col-lg-6">
            
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" action="<?php echo base_url(); ?>update-worked-time">
                            <input type="hidden" class="form-control timepicker" name="shift_id" id="" value="<?php echo $this->uri->segment('2'); ?>" >
                            <input type="hidden" class="form-control timepicker" name="driver_id" id="" value="<?php echo $this->uri->segment('3'); ?>" >
                            <input type="hidden" class="form-control timepicker" name="date" id="" value="<?php echo $workedTime['date']; ?>" >

                            <div class="form-group">
                                <label for="exampleInputEmail1">From time: </label>
                                <input type="text" class="form-control timepicker" name="from_time" id="" value="<?php echo $workedTime['start_time']; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">To time: </label>
                                <input type="text" class="form-control timepicker2" name="to_time" id="exampleInputPassword1" value="<?php echo $workedTime['end_time']; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Payable amount: </label>
                                <input type="text" class="form-control" id="" name="payable_amount" value="<?php echo $workedTime['payable_amount']; ?>" >
                            </div>
                            <div class="form-group">
                                <a onclick="javascript:history.go(-1)" class="form-control btn">Back</a>
                                <input type="submit" class="form-control" value="Save" >
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        
        
                <!------------------content start ------------------------------>
        

<script>

$(document).ready(function () {

    $('.timepicker').datetimepicker({
        format:'H:i',
        mask :'',
        datepicker:false
    });

     $('.timepicker2').datetimepicker({
        format:'H:i',
        mask :'',
        datepicker:false
    });


});
</script>

    
</div>
</div>

<?php echo $this->load->view('templates/footer'); ?>