<?php  if(!$main_content['data'] = ''){ ?>
<?php  $this->load->view($header['view'],$header['data']); ?>
<?php  $this->load->view($main_content['view'],$main_content['data']); ?>    
<?php  $this->load->view($footer['view'],$footer['data']); ?>  
<?php }  ?>