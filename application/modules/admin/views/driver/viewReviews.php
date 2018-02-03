<?php echo $this->load->view('templates/header'); ?>
<?php echo $this->load->view('templates/common_sidebar'); ?>
<!--<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">-->

<style>
    .profile-image {
    float: left;
    width: 110px;
    text-align: center;
    padding-right: 20px;
}
.profile-image img {
    width: 80px;
    border-radius: 50% !important;
    height: 80px;
    box-shadow: 0px 0px 33px -9px rgba(0, 0, 0, 0.95);
}
.review-block-description {
    float: left;
    width: 100%;
    padding: 25px 15px 0;
}


.glyphicon-star {
  font-size: 40px;
  color: #e67e22;
  &.half {
    position: relative;
    &:before {
      position: relative;
      z-index: 9;
      width: 47%;
      display: block;
      overflow: hidden;
    }
    &:after {
      content: '\e006';
      position: absolute;
      z-index: 8;
      color: #bdc3c7;
      top: 0;
      left: 0;
    }
  }
}


h1 {
    font-size: 2em; 
    margin-bottom: .5rem;
}

/* Ratings widget */
.rate {
    display: inline-block;
    border: 0;
}
/* Hide radio */
.rate > input {
    display: none;
}
/* Order correctly by floating highest to the right */
.rate > label {
    float: right;
}
/* The star of the show */
.rate > label:before {
    display: inline-block;
    font-size: 1.1rem;
    padding: .3rem .2rem;
    margin: 0;
    cursor: pointer;
    font-family: FontAwesome;
    content: "\f005 "; /* full star */
}
/* Zero stars rating */
.rate > label:last-child:before {
    content: "\f006 "; /* empty star outline */
}
/* Half star trick */
.rate .half:before {
    content: "\f089 "; /* half star no outline */
    position: absolute;
    padding-right: 0;
}
/* Click + hover color */
input:checked ~ label, /* color current and previous stars on checked */
label:hover, label:hover ~ label { color: #73B100;  } /* color previous stars on hover */

/* Hover highlights */
input:checked + label:hover, input:checked ~ label:hover, /* highlight current and previous stars */
input:checked ~ label:hover ~ label, /* highlight previous selected stars for new rating */
label:hover ~ input:checked ~ label /* highlight previous selected stars */ { color: #A6E72D;  } 



</style>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
        <h3 class="page-title page_mrg">View Driver Reviews</h3>
        <?php // echo "<pre>"; print_r($reviews);
        $rateIncrement =1;
        foreach ($reviews as $key => $val) {
            ?>
        <div class="row">
        <div class="col-sm-12">
            <hr/>
            <div class="review-block">
                <div class="row">
                    <div class="col-sm-3">
                        
                        <span class="profile-image" >
                                <?php if ($val['profile_pic'] != '') { ?>
                                    <img src="<?php echo $val['profile_pic']; ?>" class="img-rounded">
                                  <?php } else { ?>

                                    <img src="<?php echo base_url(); ?>assets/img/no-image.png" class="img-rounded">
                                <?php } ?>
                            </span>
                      
                        <div class="review-block-name cust-name"><a href="#"><?php echo ucfirst($val['first_name']) . ' ' . $val['last_name']; ?></a></div>
                        <div class="review-block-date"><?php echo date("d-m-Y | h:m", strtotime($val['created_at'])); ?></div>
                    </div>
                  
                        <div class="review-block-rate pull-right">
                            <?php
                          
                                if($val['rating']){
                                    for($i= 0; $i < 5; $i++){
                                        if($val['rating'] > $i){?>
                                             <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                                <span class="glyphicon glyphicon-star half" aria-hidden="true"></span>
                                            </button>
                                       <?php  }else{?>
                                             <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                <span class="glyphicon glyphicon-star half" aria-hidden="true"></span>
                            </button>
                                        <?php }
                                    }
                                }
                            ?>
                           
                        </div>
<!--                        <div class="review-block-title"><?php echo $val['review']; ?></div>-->
                        <div class="review-block-description"><?php echo $val['review']; ?></div>
                   
                </div>
                <hr/>
            </div>
        </div>
    </div>

<!--        <fieldset class="rate">
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+10;?>" name="rating<?php echo $val['id']; ?>" value="10" />
    
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+10;?>" title="5 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+9;?>" name="rating<?php echo $val['id']; ?>" checked="true" value="9" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+9;?>" title="4 1/2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+8;?>" name="rating<?php echo $val['id']; ?>" value="8" />
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+8;?>" title="4 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+7;?>" name="rating<?php echo $val['id']; ?>" value="7" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+7;?>" title="3 1/2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+6;?>" name="rating<?php echo $val['id']; ?>" value="6" />
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+6;?>" title="3 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+5;?>" name="rating<?php echo $val['id']; ?>" value="5" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+5;?>" title="2 1/2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+4;?>" name="rating<?php echo $val['id']; ?>" value="4" />
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+4;?>" title="2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+3;?>" name="rating<?php echo $val['id']; ?>" value="3" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+3;?>" title="1 1/2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+2;?>" name="rating<?php echo $val['id']; ?>" value="2" />
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+2;?>" title="1 star"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+1;?>" name="rating<?php echo $val['id']; ?>" value="1" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+1;?>" title="1/2 star"></label>    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+7;?>" title="3 1/2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+6;?>" name="rating<?php echo $val['id']; ?>" value="6" />
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+6;?>" title="3 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+5;?>" name="rating<?php echo $val['id']; ?>" value="5" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+5;?>" title="2 1/2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+4;?>" name="rating<?php echo $val['id']; ?>" value="4" />
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+4;?>" title="2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+3;?>" name="rating<?php echo $val['id']; ?>" value="3" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+3;?>" title="1 1/2 stars"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+2;?>" name="rating<?php echo $val['id']; ?>" value="2" />
    <label for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+2;?>" title="1 star"></label>
    
    <input type="radio" id="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+1;?>" name="rating<?php echo $val['id']; ?>" value="1" />
    <label class="half" for="<?php echo $val['id']; ?>rating<?php echo $rateIncrement+1;?>" title="1/2 star"></label>
    
   
</fieldset>-->
        <?php  $rateIncrement ++; ?>


<!--            <div class="review-listing">
                <span class="profile-image">
                    <img src="<?php echo $val['profile_pic']; ?>"/>
                </span>
                <span class="profile-details-memo">
                    <span class="cust-name"><?php echo ucfirst($val['first_name']) . ' ' . $val['last_name']; ?></span>
                    <span class="cust-mail"><?php echo $val['email']; ?></span>                  
                    <span class="date-shol"><?php echo date("d-m-Y | h:m", strtotime($val['created_at'])); ?></span>


                </span>
              
                <span class="profile-rating">
                    <fieldset class="rating">
                    
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        
                        <input type="radio" id="star4half" name="rating" value="4 and a half" />
                        <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" id="star3half" name="rating" value="3 and a half" />
                        <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2half" name="rating" value="2 and a half" />
                        <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" id="star1half" name="rating" value="1 and a half" />
                        <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" id="starhalf" name="rating" value="half" />
                        <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>

                    </fieldset>

                </span>
                <p class="inner-tat"><?php echo $val['review']; ?></p>
                <p class="inner-tat"><?php echo $val['rating']; ?></p>
            </div>-->
<?php } ?>
    </div>
    
    
    
    










