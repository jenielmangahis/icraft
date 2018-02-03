</div>
</div>
<div class="page-footer">
        <div class="page-footer-inner"> <?php echo date('Y'); ?> &copy; Travel Assist </div>
        <div class="scroll-to-top"> <i class="icon-arrow-up"></i> </div>
    </div>

<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>-->


 <!--<script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>-->
<script src="https://keenthemes.com/preview/metronic/theme/assets/global/plugins/bootstrap-table/bootstrap-table.min.js" type="text/javascript"></script>
<!--<script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>-->
<script src="https://keenthemes.com/preview/metronic/theme/assets/pages/scripts/table-bootstrap.min.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/custom.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/ninjaDate/build/jquery.datetimepicker.full.js"  type="text/javascript" ></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS --> 
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<!--<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/components-dropdowns.js"></script>
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"  type="text/javascript" ></script>

<script>
<!-- Custom JS -->
    //--- Common Print Dashboard function 
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=600,width=800');
        mywindow.document.write('<html><head><title>Dashboard | InstaCraft</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

    //--- Common phoneFormatter
    function phoneFormatter() {
      $('.onlyDigit').on('input', function() {
        var number = $(this).val().replace(/[^\d]/g, '')
        if (number.length <= 7) {
          number = number.replace(/(\d{3})(\d)/, "$1 $2");
        } else if (number.length > 7 && number.length <= 10) {
          number = number.replace(/(\d{3})(\d{3})(\d)/, "$1 $2 $3");
        } else if (number.length > 10) {
          number = number.replace(/(\d{3})(\d{3})(\d{4})(\d)/, "$1 $2 $3 $4");
        }
        $(this).val(number)
      });
    };
    
    $(phoneFormatter);
    
    
    //--- Common phoneFormatter
    function formsubmit(formid){
        document.forms[formid].submit();
    }
    
    function isNumberKey(evt)
    {
       //-- onkeypress="return isNumberKey(event)"
       var charCode = (evt.which) ? evt.which : evt.keyCode;
       if (charCode != 46 && charCode > 31 
         && (charCode < 48 || charCode > 57))
          return false;

       return true;
    }    
    
    $('.bindnum').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
    });

    var filterFloat = function(value) {
        if (/^(\-|\+)?([0-9]+(\.[0-9]+)?|Infinity)$/
          .test(value))
          return Number(value);
      return NaN;
    }

    function strip(html)
    {
       var tmp = document.createElement("DIV");
       tmp.innerHTML = html;
       return tmp.textContent || tmp.innerText || "";
    }
 
    
    //-- Block Mouse Wheel for Date Box
    $(".datetime").bind("mousewheel", function () {
        if ($.browser.webkit === true) {
            return false;
        }
    });


    //--- Remove Matched Text 
    function rmMatchText(pText){
        var ret = pText.replace('data-','');
        console.log(ret);
    }

    
<!-- Custom JS -->
</script>
</body>
</html>