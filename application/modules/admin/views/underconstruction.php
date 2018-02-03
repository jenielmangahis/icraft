<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        Widget settings form goes here
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn blue">Save changes</button>
                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
           
        </h3>
        
        <!-- END PAGE HEADER-->

        <div class="clearfix">
        </div>

        <!-- BEGIN PAGE CONTENT-->


        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-body">
                    <div class="tabbable">
                        <div class="tab-content no-space">
                            <div class="tab-pane active" id="tab_general">
                                <div class="row">
                                    <div class="manage_add clearfix">     


                                       

                                        <div class="row row_mrg">
                                            <div class="col-md-12">
                                                <div class="portlet-body flip-scroll" style="text-align: center">
                                                    
                                                    <img src="<?php echo base_url();?>assets/admin/layout/img/underconstruction.jpeg" alt="Under Construction">
                                                </div>
                                            </div>
                                        </div>                                   
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function updatestatus(val, id) {
        var status_id = val.value;
        var case_id = id;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>admin/Cases/updatecasestatus",
            data: {status_id: status_id, case_id: case_id},
            success: function (res) {
                $("#" + case_id).html(res);
            },
        });
    }
</script>