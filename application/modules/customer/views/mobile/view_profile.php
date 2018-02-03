<section class="container mobile-view-container">
    <div class="view_container">
        <div class="main_img">
            <?php if($userRecord->profile_pic == '') {
                $profile_pic    =   $this->config->item('customerassets').'images/user.jpg';
            }else {
                $profile_pic    =   $userRecord->profile_pic;   
            }
            ?>
            <div class="back_img_wraper">
                <img src="<?=$profile_pic?>" alt="user">	
            </div>
            <div class="profile_container">
                <div class="profile_pic">
                    <img src="<?=$profile_pic?>" alt="user">
                </div>
                <h2 class="user_name"><?=$userRecord->first_name?> <?=$userRecord->last_name?></h2>
                <a href="javascript:;" class="user_email"><?=$userRecord->email?></a>
            </div>
        </div>
        <ul class="profile_detail">
            <li>
                <span class="label">Phone Number:</span>
                <span class="value"><?=$userRecord->phone_number?></span>
            </li>

            <li>
                <span class="label">Date of Birth:</span>
                <span class="value"><?=$userRecord->dob?></span>
            </li>

            <li>
                <span class="label">Gender:</span>
                <span class="value"><?php if($userRecord->gender == '1'){ echo 'Male'; }elseif($userRecord->gender == '2'){ echo 'Female';}else{echo 'Other';}?></span>
            </li>

            <li>
                <span class="label">Location:</span>
                <span class="value"><?=$userRecord->address?></span>
            </li>

            <li>
                <span class="label">Reward Points:</span>
                <span class="value"><?=$userRecord->total_point?$userRecord->total_point:0?></span>
            </li>

            <li>
                <span class="label">My Referral Code:</span>
                <span class="value"><?=$userRecord->refferal_code?></span>
            </li>
        </ul>
    </div>
</section>
