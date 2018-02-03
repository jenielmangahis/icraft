var Login = function() {

    var handleLogin = function() {
        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },

            messages: {
                email: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }

    var handleRegister = function() {

        function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }

        if (jQuery().select2) {
	        $("#select2_sample4").select2({
	            placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
	            allowClear: true,
	            formatResult: format,
	            formatSelection: format,
	            escapeMarkup: function(m) {
	                return m;
	            }
	        });


	        $('#select2_sample4').change(function() {
	            $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
	        });
    	}

        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                fullname: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                country: {
                    required: true
                },

                username: {
                    required: true
                },
                password: {
                    required: true
                },
                rpassword: {
                    equalTo: "#register_password"
                },

                tnc: {
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                tnc: {
                    required: "Please accept TNC first."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.register-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.register-form').validate().form()) {
                    $('.register-form').submit();
                }
                return false;
            }
        });

        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();
            handleForgetPassword();
            handleRegister();

        }

    };

}();

    jQuery(document).ready(function() {     
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        //Login.init();
        Demo.init();
    });

    //-- Created By N.K.
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    
    
    
    
    
    //--- Delete Health Info
    $(document).on("click","#forget_password",function() {//enable disabled driver message popup
        $('#forgetPopUp').show();//show popup
    });

    $(document).on("click","#closePop",function() {//disable both popup
        $('#forgetPopUp').hide();// hide activate driver popup
    });
    
    //----- Form validation for Forget Password 
    $("#forgetpswForm").submit(function(){
        var emailText = $('#forgetpsw_email').val();
        if(emailText != '' && emailText != undefined && emailText != null){
            var res = isEmail(emailText);
            if(res != false){
                return true;                        
            }else{
                alert('Please enter a valid email ');
                return false; 
            }
        }else{
            alert('Email id is required');
            return false; 
        }


    });
    
    
    
    
    
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
    
        $("#loginForm").submit(function(){
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var error = [];
            var email    = $(".login-form").contents().find('input[name="email"]').val();
            var password = $(".login-form").contents().find('input[name="password"]').val();

            //--- Email Validation
            if(email == ''){
                setFeedError('email-error','Email id is required');
                error['email'] = true;
            }
            else if(regex.test(email) == false){
                setFeedError('email-error','Please enter a valid email.');
                error['email'] = true;                    
            }
            else if(email.length > 50){
                setFeedError('email-error','Email must be less than or equal to 50 characters');
                error['email'] = true;
            }
            else{
                washFeedError('email-error');
                error['email'] = false;
            }
            
            //--- Password Validation
            if(password == ''){
                setFeedError('password-error','Password is required');
                error['password'] = true;
            }else if(password.leangth > 20){
                setFeedError('password-error','Password must be less than or equal to 20 characters');
                error['password'] = true;
            }           
            else{
                washFeedError('password-error');
                error['password'] = false;
            }
            
            if(error['email'] == true || error['password'] == true){
                return false;
            }else{
                return true;
            }
            
        });
        
        
    
