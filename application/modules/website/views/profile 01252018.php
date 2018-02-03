<?php include('templates/header.php')  ?>
<section class="main-body">
        <div class="ground-elements">
            <!--no need to go back thats why closed-->
            <!--<a href="#" class="action-back"><span class="icon-back"></span><span class="redi-txt">Back</span></a>-->
            <form method="POST" action="<?php echo base_url(); ?>updateProfile"  enctype="multipart/form-data" >
            <div class="profile-sec">
                <div class="dp propage-upload">
                    <?php if($data['data']['profile_pic']){ ?>
                        <img src="<?php echo $data['data']['profile_pic'];  ?>" />
                    <?php  }else{  ?>
                        <img src="<?php echo base_url(); ?>assets/images/prof.jpg" />
                    <?php } ?>
                    <div class="browse">
                        <input type="file" name="profile_pic" id="file" class="inputfile" value="<?php echo $data['data']['profile_pic'];  ?>"  >
                        <label for="file">
                            <i class="icon-camera"></i>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="profile_pic_old" id="file" class="inputfile" value="<?php echo $data['data']['profile_pic'];  ?>"  >
                <input type="hidden" name="signature_old" id="file" class="inputfile" value="<?php echo $data['data']['signature_or_document'];  ?>"  >
                <div class="pro-details">
                    <div class="row widout-bordr">
                        <div class="form-group">
                            <label class="lablo left user-name">First Name</label>
                            <input class="right input-gex" type="text" name="first_name" value="<?php echo $data['data']['first_name']; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="lablo left user-name">Last Name</label>
                            <input class="right input-gex" type="text" name="last_name" value="<?php echo $data['data']['last_name']; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="lablo left user-name">Email Id</label>
                            <input class="right input-gex" type="text" name="email" value="<?php echo $data['data']['email']; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="lablo left user-name">Contact Number</label>
                            <input class="right input-gex" type="text" name="phone_number" value="<?php echo $data['data']['phone_number']; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="lablo left user-name">Location</label>
                            <input class="right input-gex" type="text" name="address" value="<?php echo $data['data']['address']; ?>" />

                        </div>
                    </div>
                </div>
            </div>
            <div class="personal-info">
                <div class="row widout-bordr">
                    <div class="form-group">
                        <label class="lablo left user-name">Specialization</label>
                        <input class="right input-gex" type="text" name="specialization" value="<?php echo $data['data']['specialization']; ?>" />
                    </div>
                    <div class="form-group">
                        <label class="lablo left user-name">Experience</label>
                        <input class="right input-gex" type="text" name="experience" value="<?php echo $data['data']['experience']; ?>" />
                    </div>
                    <div class="form-group">
                        <label class="lablo left user-name">Licence Number</label>
                        <input class="right input-gex" type="text" name="license_number" value="<?php echo $data['data']['license_number']; ?>" />
                    </div>
                    <div class="form-group pro-docs">
                        <label class="lablo left user-name">Signature/Documents</label>
                        <?php
                          if($data['data']['signature_or_document']){
                          
                        ?>
                        <img src="<?php echo $data['data']['signature_or_document']; ?>" height="100px" />
                        <div class="dp propage-upload">
                            <div class="browse">
                                
                                <input type="file" name="signature" id="file" class="inputfile" >
                                <label for="file">
                                    <span class="icon-attached"></span><p>Attach Signature/Document</p>
                                </label>
                            </div>
                        </div>
                        <?php }else{  ?>
                        <div class="dp propage-upload">
                            <div class="browse">
                            <input type="file" name="signature" id="fileSign" class="inputfile" >   
                                <label for="fileSign">
                                    <span class="icon-attached"></span>
                                    <p>Attach Signature/Document</p>
                                </label>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="btn-bg-grad margin-top-15">
                        <input type="submit" class="btn-insta-sub" name="save" value="Save">
                        
                    </div>
                    <div class="btn-bg-grad margin-top-15">
                        <a class="btn-insta-sub" >Cancel</a>
                        
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
<?php include('templates/footer.php')  ?>
<script>
//    function uploadFile(){
//        var signature_or_document = $('#file').val();
//        $.post( 
//        "<?php echo base_url(); ?>signatureUpload",{signature_or_document:signature_or_document},
//        function(data) {
//            alert(data);return false;
//            if(data ==1){
//                $('.alert-Success').show();
//                setTimeout(function () {//remove pop up after 1.5 seconds
//                     $('body').removeClass('overlaypop');
//                     $('.insta-pop').removeClass('opend-pop');
//                     $('.insta-pop').fadeOut();
//                     $('.alert-Success').hide();
//                 }, 1500);
//                
//            }
//           
//            }
//        );
//    }
//    $(document).on('change','#file' , function(){ uploadFile(); });
     
</script>
