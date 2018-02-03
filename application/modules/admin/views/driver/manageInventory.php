<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>
<style>
/*    .dd_label select,.dd_label input{width: 40%;}*/
.flex{ display: -webkit-flex; display: flex;}
.flex-middle{ -webkit-align-items: center; align-items: center;}
.no-mar{ margin: 0;}

</style>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">Manage Inventory</h3>
        <?php if ($this->session->flashdata('success_message')) { ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('success_message') ?> </div>
        <?php } ?>
        <?php if ($this->session->flashdata('errors_message')) { ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('errors_message') ?> </div>
        <?php } ?>   
        <div class="col-md-6 padLeftZero">
            <fieldset class="customFieldset">
                <legend style="font-size:13px;margin-bottom: 5px;">Assign to Driver</legend>
                <div class="portlet-body flip-scroll table-scrollable" >
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                        <thead class="flip-content">
                            <tr>
                                <td><b>Date</b></td>
                                <td><b><?php echo $driverTotalOrder['currentDate']; ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Day</b></td>
                                <td><b><?php echo $driverTotalOrder['currentDay']; ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Total Orders</b></td>
                                <td><b><?php echo $driverTotalOrder['total_order']; ?></b></td>
                            </tr>

                        </thead>
                    </table>
                </div>
            </fieldset>   
        </div>

        <div class="col-md-12 padLeftZero">
            <form class="" method="post" action="<?php echo base_url(); ?>save-template-item">
                <input type="hidden" name="driver_id" id="driver_id" value="<?php echo $this->uri->segment('2'); ?>">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="sr-only" for="email">Templates:</label>
                            <select class="form-control" id="template"  name="template">
                                <option value="0">--Please Select Template --</option>
                                <?php
                                if (sizeof($driverTemplate) > 0) {

                                    foreach ($driverTemplate as $dt) {
                                        $selected = "";
                                        if ($dt['is_assigned'] == '1') {
                                            $selected = "selected";
                                        }
                                        echo"<option value='" . $dt['id'] . "' " . $selected . ">" . $dt['name'] . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary no-mar assign_to_driver">Assign To Driver</button>
                        <button type="button" id="add_prod_colla_btn" class="btn btn-primary no-mar" data-toggle="collapse" data-target="#product_collapse">
                            Add Product
                        </button>
                    </div>
                </div>
                <div class="row collapse" id="product_collapse">
                    <div class="product_input_fields_wrap">
                        <div class="col-md-4">
                            <div class="form-group flex flex-middle row">
                                <label for="product " class="col-md-3">Product:</label>
                                <select class="form-control col-md-9" id="product"  name="product[]">
                                    <option value="0">--Please Select Product --</option>

                                    <?php
                                    if (sizeof($allProduct) > 0) {

                                        foreach ($allProduct as $p) {

                                            echo"<option value='" . $p['item_id'] . "'>" . $p['item_name'] . "</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group flex flex-middle row">
                                <label for="pickup" class="col-md-3">Pickup:</label>
                                <select class="form-control col-md-9" id="pickup"  name="pickup[]">
                                    <option value="0">--Please Select Pickup Location --</option>
                                    <?php
                                    if (sizeof($allWarehouse) > 0) {

                                        foreach ($allWarehouse as $wh) {

                                            echo"<option value='" . $wh['id'] . "'>" . $wh['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ">   
                            <div class="form-group flex flex-middle row">
                                <label for="quantity" class="col-md-3">Quantity:</label>
                                <div class="col-md-4">
                                    <input type="number" name="quantity[]" class="form-control" id="quantity">
                                </div>
                                <button type="button" class="btn btn-primary no-mar add_more_product_button">Add More</button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary no-mar pull-right" style="margin-right: 45px;">Save</button>
                </div>
            </form>
        </div>
        <div class="col-md-12 padLeftZero">
            <fieldset class="customFieldset">
                <div class="portlet-body flip-scroll table-scrollable" >
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                        <thead class="flip-content">
                            <tr>
                                <td><b>S.No.</b></td>
                                <td><b>Product</b></td>
                                <td><b>Quantity</b></td>
                                <td><b>Pickup</b></td>
                                <td><b>Action</b></td>
                            </tr>
                        </thead>
                        <tbody id="template_item_tbody">
                            <?php
                            if (count($driverInventory) > 0) {
//                                   echo "<pre>"; print_r($driverInventory);exit;
                                foreach ($driverInventory as $index => $val) {
                                    ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $val['item_name']; ?></td>
                                        <td>
                                            <span><?php echo $val['quantity']; ?></span>
                                            <input type="number" id="" name="quantity" class="form-control edit_temp_quantity" value="<?php echo $val['quantity']; ?>"  style="display:none;">

                                        </td>
                                        <td><?php echo $val['name']; ?></td>
                                        <td><a class="btn red p-xl-pad editQuantity" data-inv-id="<?php echo $val['id']; ?>" data-qty="<?php echo $val['quantity']; ?>"  href="javascript:void(0);">Edit</a>
                                        <a class="btn red p-xl-pad temp_prod_remove" data-inv-id="<?php echo $val['id']; ?>" href="javascript:void(0);">Remove</a>

                                            <button type="button" old-value="<?php echo $val['quantity']; ?>" class="btn btn-danger edit-quantity-cancel" style="display:none;">Cancel</button>

                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5"><p class="align_center">No data found</p></td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
        </div> 
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading clearfix">

                            <h3 class="panel-title pull-left" style="padding-top: 7.5px;">Template List</h3>
                            <div class="btn-group pull-right">
                                <a href="javascript:void(0);" class="btn red p-xl-pad add-temp-popup" data-toggle="modal" data-target="#addTempModal">Add Template</a>

                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th style="background-color: #f9f9f9;color: #080805;">Template Name</th>
                                        <th style="background-color: #f9f9f9;color: #080805;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (sizeof($driverTemplate) > 0) {

                                        foreach ($driverTemplate as $dt) {
                                            ?>
                                            <tr>
                                                <td><?php echo $dt['name']; ?></td>
                                                <td><a class="btn red p-xl-pad temp_remove" data-temp-id="<?php echo $dt['id']; ?>" href="javascript:void(0);">Remove</a></td>
                                            </tr>

                                        <?php }
                                    } else {
                                        ?>
                                        <tr><td colspan="2">No Redcord Found</td></tr>
<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>        
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="addTempModal" tabindex="-1" role="dialog" aria-labelledby="addTempModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="temp_name_already_exist"></div>
                <form>
                    <div class="form-group">
                        <label for="temp_name">Template Name:</label>
                        <input type="text" class="form-control" id="temp_name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_temp">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        $("#product_collapse").on('show.bs.collapse', function () {
            $("#add_prod_colla_btn").text("Cancel");
            $("#add_prod_colla_btn").removeClass("btn-primary");
            $("#add_prod_colla_btn").addClass("btn-danger");
            
        });
        $("#product_collapse").on('hide.bs.collapse', function () {
            $("#add_prod_colla_btn").text("Add Product");
            $("#add_prod_colla_btn").removeClass("btn-danger");
            $("#add_prod_colla_btn").addClass("btn-primary");
        });
    });
    
   /****************************************************   
    *********** Start Add More Product Field ***********
    *****************************************************/
   
    /*** Maximum input boxes allowed ***/
    var product_max_row      = 6;
    
    /*** Fields wrapper ***/
    var product_wrapper         = $(".product_input_fields_wrap");
    
    /*** Add button ID ***/
    var product_add_button      = $(".add_more_product_button"); 
    
    var allProduct   = JSON.parse('<?php echo json_encode($allProduct);?>');
    var allWarehouse = JSON.parse('<?php echo json_encode($allWarehouse);?>');

    var productOption = "";
   for(var i in allProduct){
      
        productOption +='<option value="'+allProduct[i].item_id+'">'+allProduct[i].item_name+'</option>';
    }
 
    var warehouseOption = "";
    for(var j in allWarehouse){
        warehouseOption +='<option value="'+allWarehouse[j].id+'">'+allWarehouse[j].name+'</option>';
    }
 
 
   var html ='<div class="remove_product_input_fields_wrap">\n\
    <div class="col-md-4">\n\
        <div class="form-group flex flex-middle row">\n\
            <label for="product " class="col-md-3">Product:</label>\n\
            <select class="form-control col-md-9" id="product"  name="product[]"> \n\
                <option value="0">--Please Select Product --</option>'+productOption+'</select>\n\
        </div>\n\
    </div>\n\
    <div class="col-md-4"> \n\
        <div class="form-group flex flex-middle row">\n\
            <label for="pickup" class="col-md-3">Pickup:</label>\n\
            <select class="form-control col-md-9" id="pickup"  name="pickup[]">\n\
                <option value="0">--Please Select Pickup Location --</option>'+warehouseOption+'</select>\n\
        </div>\n\
    </div>\n\
    <div class="col-md-4 ">\n\
        <div class="form-group flex flex-middle row">\n\
            <label for="quantity" class="col-md-3">Quantity:</label>\n\
            <div class="col-md-4">\n\
                <input type="number" name="quantity[]" class="form-control" id="quantity">\n\
            </div>\n\
            <button type="submit" class="btn btn-danger no-mar remove_product_btn">Remove</button>\n\
        </div>\n\
    </div>\n\
</div>';
        
        /*** initlal text box count ***/ 
        var product_row_increment = 1; 
        /*** on add input button click ***/
        $(product_add_button).click(function(e){
            e.preventDefault();
            /*** max input box allowed ***/
            if(product_row_increment < product_max_row){               
               $(product_wrapper).append(html); 
                product_row_increment++;   
            }           
        });   
        
        /*** user click on remove text ***/
        $(product_wrapper).on("click",".remove_product_btn", function(e){ 
            e.preventDefault();          
            $(this).parent('div').parent('div').parent('div').remove();
            product_row_increment--;
        });
        
    /****************************************************   
    ********** End Add More Client Email Field **********
    *****************************************************/
    
    
    $('#template').on('change', function() {
        var template_id =  this.value;
        var driver_id   = $('#driver_id').val();
        
        if(template_id == 0){
            
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>get-template-item",
                data: {template_id:template_id,driver_id:driver_id},
                success: function(data){
                    var res = JSON.parse(data);
                    var row = "";
                    if(res.result){
                        for (var i in res.data){
                        row +='<tr>\n\
                                <td>'+parseInt(i+1)+'</td>\n\
                                <td>'+res.data[i].item_name+'Digital Dreem edited</td>\n\
                                <td><span>'+res.data[i].quantity+'</span><input type="number" id="" name="quantity" class="form-control edit_temp_quantity" value="'+res.data[i].quantity+'"  style="display:none;"></td>\n\
                                <td>'+res.data[i].name+'</td>\n\
                                <td>\n\
                                    <a class="btn red p-xl-pad editQuantity" data-inv-id="'+res.data[i].id+'" data-qty="'+res.data[i].quantity+'" href="javascript:void(0);">Edit</a> \n\
                                    <a class="btn red p-xl-pad temp_prod_remove" data-inv-id="'+res.data[i].id+'" href="javascript:void(0);">Remove</a>\n\
                                 <button type="button" old-value="'+res.data[i].quantity+'" class="btn btn-danger edit-quantity-cancel" style="display:none;">Cancel</button></td>\n\
                            </tr>';
                        }
                    }else{
                      row += '<tr><td colspan="5"><p class="align_center">No data found</p></td></tr>';
                    }
                   $("#template_item_tbody").html(row);
                    
                }
            });
        }
 
    });
    
    
    $(document).on("click",".assign_to_driver",function() {
        var template_id = $('#template').val();
        var driver_id   = $('#driver_id').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>assing-template",
            data: {template_id:template_id,driver_id:driver_id},
            success: function(data){
              location.reload();
            }
        });
    });
    
    $(document).on("click",".editQuantity",function() {//enable disabled driver message popup
        $(this).text('Save');
        $(this).removeClass('editQuantity');
        $(this).addClass('quantitySave');
        $(this).closest("td").prev('td').prev('td').find("span").css("display", "none");
        $(this).closest("td").prev('td').prev('td').find("input.edit_temp_quantity").css("display", "inline-block");
        $(this).closest('td').find('button.edit-quantity-cancel').css("display", "inline-block");
        
    });
    
    $(document).on("click",".edit-quantity-cancel",function() {
        $(this).closest('td').find('a.quantitySave').text('Edit');
        $(this).closest('td').find('a.quantitySave').addClass('editQuantity');
        $(this).closest('td').find('a.editQuantity').removeClass('quantitySave');
        
        $(this).closest("td").prev('td').prev('td').find("span").css("display", "inline-block");
        $(this).closest("td").prev('td').prev('td').find("input.edit_temp_quantity").css("display", "none");
        $(this).css("display", "none");
    });
    
    $(document).on("click",".quantitySave",function() {
        var qty = $(this).closest("td").prev('td').prev('td').find("input.edit_temp_quantity").val();
        var id  = $(this).attr('data-inv-id');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>update-assigned-quantity",
            data: {quantity:qty,id:id},
            success: function(data){
                location.reload();
            }
        });
    });  
    
    $(document).on("click",".temp_prod_remove",function() {
        var id  = $(this).attr('data-inv-id');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>remove-assigned-product",
            data: {id:id},
            success: function(data){
                location.reload();
            }
        });
    });
    
    $(document).on("click",".add_temp",function() {
        var driver_id = $("#driver_id").val();
        var temp_name = $("#temp_name").val();
        if(temp_name){
            $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>add-template",
            data: {driver_id:driver_id,template_name:temp_name},
            success: function(data){
                var res = JSON.parse(data);
                if(res.result){
                  location.reload();  
                }else{
                    $('#temp_name_already_exist').html('<div class="alert alert-danger">'+res.message+'</div>');
                }
            }
            });
        }
    });
    
    $(document).on("click",".temp_remove",function() {
        var id  = $(this).attr('data-temp-id');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>remove-template",
            data: {id:id},
            success: function(data){
                location.reload();
            }
        });
    });
    
    
    
</script> 

<?php echo $this->load->view('templates/footer'); ?>
