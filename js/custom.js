
// loading function
jQuery(window).load(function () {
	jQuery(".loadingBg").delay(500).fadeOut("slow");
});	
	
// login js	
$(document).ready(function() {
	$('.ForgotBtn').click( function(){
		$('.ForgotPasswordSec').slideToggle();
		$('.LoginSec').slideToggle();
	});
	
	$('.CancelBtn').click( function(){
		$('.ForgotPasswordSec').slideToggle();
		$('.LoginSec').slideToggle();
	});
	
    
    // popup js
    
      $(document).on("click" , function(e){
      if($(".opend-pop").length > 0 && !$(e.target).is(".opend-pop , .opend-pop * , [data-attribute] , [data-attribute] *")){
       $(".opend-pop").fadeOut();
       $("body").removeClass("overlay");
      }
     });  
    $("body").on("click" , "[data-attribute] , [data-attribute] *" , function(e){
      e.preventDefault();
      $("[data-pop='" + $(this).attr("data-attribute")+"']").addClass("opend-pop").fadeIn();
      $("body").addClass("overlay");
     });
    
    $('.closebtn').click(function(){
         $(".opend-pop").fadeOut();
        $("body").removeClass("overlay");
    })
    
    
    //tab js
    $(".tabContent").hide(); //Hide all content
    $(".tabAction li:first").addClass("selected").show(); //Activate first tab
    $(".tabContent:first").show(); //Show first tab content
    //On Click Event
    $(".tabAction li").click(function() {
    $(".tabAction li").removeClass("selected"); //Remove any "active" class
    $(this).addClass("selected"); //Add "active" class to selected tab
    $(".tabContent").hide(); //Hide all tab content
    var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
    $(activeTab).fadeIn(); //Fade in the active content
    return false;
    }); 
    
    
    
     $('.RightContent').css({'min-height':$(".LeftContent").height()+'px'});

    $(window).resize(function(){
    	$('.RightContent').css({'min-height':$(".LeftContent").height()+'px'});
    });
    
    
});

$(document).ready(function() {
 //--- Validate Date Range Form 
        $("#addDriver").validate({
            //validateOnBlur : false, // disable validation when input looses focus
            //errorMessagePosition : 'top', // Instead of 'inline' which is default
            //scrollToTopOnError : false, // Set this property to true on longer forms
            //-- date_timepicker_start date_timepicker_end
            rules: {
                
                    driver_image: {
                    required: true,
                    },
                    first_name: {
                            required: true,
                    },
                    last_name: {
                    required: true
                    },
                    email: {
                    required: true
                    },
                    mobile: {
                    required: true
                    },
                    ssn: {
                    required: true
                    },
                    driving_license: {
                    required: true
                    },
                    gender: {
                    required: true
                    },
                    hourly_pay: {
                    required: true
                    },
                    vehicle_image: {
                    required: true
                    },
                    make: {
                    required: true
                    },
                    model: {
                    required: true
                    },
                    color: {
                    required: true
                    },
                    registration_number: {
                    required: true
                    },
                    manufactur_date: {
                    required: true
                    },
                    document1: {
                    required: true
                    },
                    document_image1: {
                    required: true
                    },
                    from_time: {
                    required: true
                    },
                    to_time: {
                    required: true
                    },
                    warehouse: {
                    required: true
                    }
                    
                    
            },
            //errorPlacement: function(error, element) {}

        });	
	
});