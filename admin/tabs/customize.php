<?php
global $instantchatwp, $instantchatwpcomplement;


?>

<?php if(!isset($instantchatwpcomplement)){?>

    <div class="instantchatwp-welcome-panel">  
      <h3 class="instantchatwp-extended">Instant Chat WP Pro Version</h3>
      <p class="instantchatwp-extended-p"> <?php _e("Thank you very much for using Instant Chat WP.",'instant-chat-wp')?></p> 

      <p class="instantchatwp-extended-p"><?php _e("Should you wish to activate the appearance module, please consider upgrading your version.",'instant-chat-wp')?>
</p>

<p class="instantchatwp-extended-p"><?php _e("The premium version has many useful features.",'instant-chat-wp')?>
</p>

<div class=" instantchatwp-divline">  </div>

    <div class="instantchatwp-upgrade-pro-btn">
      <a href="https://instantchatwp.com/#pricing" target="_blank"> <button class="instantchatwp-button-upgrade">Upgrade to PRO	</button> </a>
       
    </div>


    </div>

    


<?php }else{
   
    ?>


        <div class="instantchatwp-sect ">
        <h1 ><?php _e("Set Appearance",'instant-chat-wp')?></h1>
       

          <div class="instantchatwp-profile-field" >
            <label class="instantchatwp-field-type" for="display_name"><span><?php _e("Header Background Color:",'instant-chat-wp')?></span></label>
            <div class="instantchatwp-field-value" ><input type="text" class=" instantchatwp-input color-picker"  id="instantchatwp_customize_header_bg" value="<?php echo esc_attr(get_option('instantchatwp_customize_header_bg'));?>" ></div>	
          </div>

          <div class="instantchatwp-profile-field" >
            <label class="instantchatwp-field-type" for="display_name"><span><?php _e("Footer Font Color",'instant-chat-wp')?></span></label>
            <div class="instantchatwp-field-value" ><input type="text" class=" instantchatwp-input color-picker"  id="instantchatwp_customize_footer_color" value="<?php echo esc_attr(get_option('instantchatwp_customize_footer_color'));?>" ></div>	
          </div>

          <div class="instantchatwp-profile-field" >
            <label class="instantchatwp-field-type" for="display_name"><span><?php _e("Whatsapp Icon Color:",'instant-chat-wp')?></span></label>
            <div class="instantchatwp-field-value" ><input type="text" class=" instantchatwp-input color-picker" id="instantchatwp_customize_icon_color" value="<?php echo esc_attr(get_option('instantchatwp_customize_icon_color'));?>" ></div>	
          </div>

          <div class="instantchatwp-profile-field" >
            <label class="instantchatwp-field-type" for="display_name"><span><?php _e("Agent's Name Color",'instant-chat-wp')?></span></label>
            <div class="instantchatwp-field-value" ><input type="text" class=" instantchatwp-input color-picker" id="instantchatwp_customize_agent_color" value="<?php echo esc_attr(get_option('instantchatwp_customize_agent_color'));?>" ></div>	
          </div>

          <div class="instantchatwp-profile-field" >
            <label class="instantchatwp-field-type" for="display_name"><span><?php _e("Schedule Font Color",'instant-chat-wp')?></span></label>
            <div class="instantchatwp-field-value" ><input type="text" class=" instantchatwp-input color-picker"  id="instantchatwp_customize_schedule_color" value="<?php echo esc_attr(get_option('instantchatwp_customize_schedule_color'));?>" ></div>	
          </div>

          <p class="submit">
	<input type="button" name="instant-chat-save-customizer" id="instant-chat-save-customizer" class="button button-primary" value="<?php _e('Save Changes','instant-chat-wp'); ?>"  />
	
</p>

        
        </div>
        
        	
        
  

 <script type="text/javascript">

jQuery(document).ready(function($) {


$('.color-picker').wpColorPicker();


});
	
			
			  
		
	</script>

<?php }?>
