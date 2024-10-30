<?php
global $instantchatwp, $instantchatwpcomplement;

$howmany = "20";
$year = "";
$month = "";
$day = "";
$status = "";
$avatar = "";
$edit = "";

if(isset($_GET["avatar"]) && $_GET["avatar"]!=''){
	
	$avatar = sanitize_text_field($_GET["avatar"]);
}

if(isset($_GET["edit"]) && $_GET["edit"]!=''){
	
	$edit = sanitize_text_field($_GET["edit"]);
}




?>

<?php if(!isset($instantchatwpcomplement)){?>

    <div class="instantchatwp-welcome-panel">  
      <h3 class="instantchatwp-extended">Instant Chat WP Pro Version</h3>
      <p class="instantchatwp-extended-p"> <?php _e("Thank you very much for using Instant Chat WP.",'instant-chat-wp')?></p> 

      <p class="instantchatwp-extended-p"><?php _e("Should you wish to add more staff members please consider upgrading your version.",'instant-chat-wp')?>
</p>

<div class=" instantchatwp-divline">  </div>

    <div class="instantchatwp-upgrade-pro-btn">
      <a href="https://instantchatwp.com/#pricing" target="_blank"> <button class="instantchatwp-button-upgrade">Upgrade to PRO	</button> </a>
       
    </div>


    </div>

    


<?php }else{
    $load_staff_id = $instantchatwpcomplement->agent->get_first_staff_on_list();
    ?>

     
        <div class="instantchatwp-sect ">
        
        <div class="instantchatwp-staff ">
        
        	
            
            
             <?php if($avatar==''){?>	
             
             
                 <div class="instantchatwp-staff-left " id="instantchatwp-staff-list">           	
                          
            	
            	 </div>
                 
                 <div class="instantchatwp-staff-right " id="instantchatwp-staff-details">
                 </div>
            
            <?php }else{ //upload avatar?>
            
           <?php  

			$crop_image  ='';

			if(isset($_POST['crop_image'])){

				$crop_image = sanitize_text_field($_POST['crop_image']);


			}
		   
		  
		   if( $crop_image=='crop_image') //displays image cropper
			{
			
			 $image_to_crop = sanitize_text_field($_POST['image_to_crop']);
			 
			
			 ?>
             
             <div class="instantchatwp-staff-right-avatar " >
           		  <div class="pr_tipb_be">
                              
                            <?php echo  wp_kses($instantchatwpcomplement->agent->display_avatar_image_to_crop($image_to_crop, $avatar) , $instantchatwp->allowed_html);?>                          
                              
                   </div>
                   
             </div>
            
           
		    <?php }else{  
			
			$user = get_user_by( 'id', $avatar );
			?> 
            
            <div class="instantchatwp-staff-right-avatar " >
            
           
                   <div class="instantchatwp-avatar-drag-drop-sector"  id="instantchatwp-drag-avatar-section">
                   
                   <h3> <?php echo esc_attr($user->display_name)?><?php _e("'s Picture",'instant-chat-wp')?></h3>
                        
                             <?php 

							 echo wp_kses($instantchatwpcomplement->agent->get_user_pic( $avatar, 100, 'avatar', 'rounded', 'dynamic'), $instantchatwp->allowed_html);
							 
							 ?>

                                                    
                             <div class="uu-upload-avatar-sect">
                              
                                     <?php echo wp_kses($instantchatwpcomplement->agent->avatar_uploader($avatar), $instantchatwp->allowed_html)?>  
                              
                             </div>
                             
                        </div>  
                    
             </div>
             
             
              <?php }  ?>
            
             <?php }?>
        
        	
        </div>        
        </div>
        
        
        <div id="instantchatwp-spinner" class="instantchatwp-spinner" style="display:">
            <span> <img src="<?php echo esc_url(instantchatwp_url.'admin/images/loaderB16.gif')?>" width="16" height="16" /></span>&nbsp; <?php  _e('Please wait ...','instant-chat-wp')?>
	</div>
        
         <div id="instantchatwp-staff-editor-box"></div>
        
  

 <script type="text/javascript">
	
			
			 var message_wait_availability ='<img src="<?php echo esc_url(instantchatwp_url.'admin/images/loaderB16.gif')?>" width="16" height="16" /></span>&nbsp; <?php  _e("Please wait ...","instant-chat-wp")?>'; 
			 
			 jQuery("#instantchatwp-spinner").hide();		 
			  
			  
			  
			  <?php if($avatar==''){?>	
			  
			  	   instantchatwp_load_staff_list_adm();
			   
				   <?php if($load_staff_id!=''){?>		  
				  
					setTimeout("instantchatwp_load_staff_details(<?php echo esc_attr($load_staff_id)?>)", 1000);
				  
				  <?php }?>
			  
			   <?php }?>	
				  
			  
		
	</script>

<?php }?>
