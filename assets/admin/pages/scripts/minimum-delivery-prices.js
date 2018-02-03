var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
var catCheckVal = false;


//-- Function : Set Cursor at end Char on Focus 
(function($){
    $.fn.focusTextToEnd = function(){
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    }
}(jQuery));



//--- Start : Editable Row JS 
jQuery(document).ready(function () {
    $('.editbtn').click(function() {
        var $this = $(this);
        var mainRowId = $this.closest('tr').find('td div').attr('id');
        // <a title="View/Edit" id="viewWarehouse" class="btn btn-default btn-xs editbtn"><i class="fa fa-pencil-square-o" style="color:#036891;"></i></a>

        var tds = $this.closest('tr').find('td div').filter(function() {
                return $(this).find('.editbtn').length === 0;
        });

        if ($this.html() === '<i class="fa fa-pencil-square-o" style="color:#036891;"></i>') {
                $this.html('<i class="fa fa-floppy-o" style="color:#94790e;"></i>');
                tds.prop('contenteditable', true);
                tds.attr('style','border-bottom:2px dotted grey;');
                $('#'+mainRowId).focus();  
        } else {
                saveMdpData(mainRowId);

                $this.html('<i class="fa fa-pencil-square-o" style="color:#036891;"></i>');
                tds.prop('contenteditable', false);
                tds.attr('style','border-bottom:0px;');
        }
    });
});
//-- Save Editable Row Data    
function saveMdpData(pin){
    var strAr1 = pin.split('_')
    
    var new_name = $("#"+pin).html();
    var old_name = $('#oldName_'+strAr1[1]).attr('val');
    
    var new_rate = parseFloat($("#mdpRate"+strAr1[1]).html()).toFixed(2);
    var old_rate = parseFloat($('#oldRate_'+strAr1[1]).attr('val')).toFixed(2);
    
    // Save Data by Ajax 
    if(new_rate != old_rate || new_name != old_name){
        dataPart = {id : strAr1[1], name : new_name, rate : new_rate, old_rate : old_rate};
        urlpart  = 'update-minimum-delivery-price/';
        console.log(dataPart)   
        $.ajax({
            type: "POST",
            url: urlpart,
            data: dataPart,
            dataType: "html",           
            complete: function (response) {
                if(response.status == 200){
                    var res = response.responseText;
                    $('#upRowId').html("<b>"+new_name +'</b> info has been Updated successfully');
                    $('#upRowId').fadeIn('fast');
                    $('#upRowId').delay(1000).fadeOut('fast');
                }else{
                    $('#upRowId').delay(1000).fadeOut('fast');
                }
            },
        });
    }
}
//--- End : Editable Row JS 




$( "#catname" ).on('keyup change paste',function(){
    var catnem = $("#catname").val();
    var urlpart = "check-category";
    datapart = {catname: catnem};
    if(catnem != ''){
        $.ajax({
            type: "POST",
            url: urlpart,
            data: datapart,
            dataType: "html",           
            complete: function (response) {
                if(response.status == 200){
                    var res = response.responseText;
                    if(res == 'true'){
                        catCheckVal = 'false';
                        $('#catcheck').attr('class','fa fa-close');
                    }else{
                        catCheckVal = 'true';
                        $('#catcheck').attr('class','fa fa-check-circle');
                    }
                }

            },
        });
    }else{
        $('#catcheck').attr('class','');
    }

});
//--On Body Load Set Image File Value
function chkAtLstOneInGroupChkBx() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function () {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  // Do something with atLeastOneIsChecked
}


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

function VehicleImageURL(input,val,imgTagId) {
    if(validate_uploadfile_format(val,'image') == 'true'){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+imgTagId)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }else{
        $('#'+imgTagId).attr('src', 'http://www.lifeline.ae/lifeline-hospital/wp-content/uploads/2015/02/LLH-Doctors-Male-Avatar.png');
    }        
}

//-- Created By N.K.
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) == false ? false : true;
    }
    
    //--- Validate input file extension
    function validate_uploadfile_format(fileName,filterType)
    {
         
        var allowed_extensions1  = new Array("jpeg","jpg","png","gif");
        var allowed_extensions2  = new Array("pdf","doc","docs");
        var allowed_extensions12 = new Array("jpeg","jpg","png","gif","pdf","doc","docx");
        
        var file_extension = fileName.split('.').pop(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

        if(filterType == 'image'){
            for(var i = 0; i <= allowed_extensions1.length; i++)
            {
                if(allowed_extensions1[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        if(filterType == 'docs'){
            for(var i = 0; i <= allowed_extensions2.length; i++)
            {
                if(allowed_extensions2[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        
        if(filterType == 'imgdocs'){
            for(var i = 0; i <= allowed_extensions12.length; i++)
            {
                if(allowed_extensions12[i]==file_extension)
                {
                    return 'true'; // valid file extension
                }
            }
        }
        
        
        
        return 'false';
    }
  

    
    //-- Created By N.K.
    function setFeedError(ele, dpart) {
        var element = $("span#"+ele);

        if(element.hasClass('hide')){
            element.removeClass("hide");
            element.html(dpart);
        }else{
            element.html(dpart);
        }
    }

    //-- Created By N.K.
    function washFeedError(ele) {
        var element = $("span#"+ele);

        if(element.hasClass('hide')){
            element.html("");
        }else{
            element.addClass("hide");
            element.html("");
        }
    }
    
    //-- Validate Group Check Box for Modules
    $(document).on("click",".groupchk",function() {//disable both popup      
       var checkboxs=document.getElementsByClassName("groupchk");
        var okay=false;
        for(var i=0;i< checkboxs.length;i++)
        {
            if(checkboxs[i].checked)
            {
                okay=true;
                break;
            }
        }
        if(okay){$('#selectedModules').val(true);}
        else{$('#selectedModules').val(''); }
    });
    
    //--- Validate Form Submission 
    $("#addRestrictedArea").submit(function(event){ 
        var phone_regex = /^[0-9]{10,12}$/;
        var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var link_regex  = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
        var error = [];
        
        var resname       = $("#resname").val();
              
        //--- First Name Validation
        if(resname == '' || resname == undefined){
            setFeedError('resname-error','required field');
            error['resname'] = true;
        }
        else if(resname.length < 5){
            setFeedError('resname-error','can\'t be less than 5 chars');
            error['resname'] = true;
        }
        else if(resname.length > 50){
            setFeedError('resname-error','can\'t exceed 50 chars');
            error['resname'] = true;
        }
        else{
            washFeedError('resname-error');
            error['resname'] = false;
        }

        
        if(error['resname'] == false ){
            return true;
        }else{
            return false;
        }


    });
        
        
    
