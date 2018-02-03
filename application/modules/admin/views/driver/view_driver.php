<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">View Driver</h3>
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
            <div class="col-md-12 margin-top-20">
             <!-------------map here---------->
            </div>
            <div class="col-md-12">
             
            </div>
            
        </div>
        <!------------------content end---------------------------------->

</div>
    </div>








