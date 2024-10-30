<?php 
global $instantchatwp,   $instantchatwpcomplement;
?>
  <h3><?php _e('Instant Chat WP Settings','instant-chat-wp'); ?></h3>
<form method="post" action="">
<input type="hidden" name="update_settings" />
<?php wp_nonce_field('instantchatwp-action', 'instantchatwp_nonce' ); ?>


<div class="instantchatwp-sect ">
  
  
  <table class="form-table">
<?php 

$this->create_plugin_setting(
                'checkbox',
                'instantchatwp_active',
                __('Activate Instant Chat WP','instant-chat-wp'),
                '1',
                __('If this is checked the floating WhatsApp button will be displayed in all pages.','instant-chat-wp'),
                __('If this is checked the floating WhatsApp button will be displayed in all pages.','instant-chat-wp')
        ); 

        $this->create_plugin_setting(
                'select',
                'instant_chat_showPopup',
                __('Show PopUp?','instant-chat-wp'),
                array(
                        'true' => __('YES','instant-chat-wp'), 
                        'false' => __('NO','instant-chat-wp')
                        ),
                        
                __('.','instant-chat-wp'),
          __('.','instant-chat-wp')
               );


$this->create_plugin_setting(
        'input',
        'phone',
        __('WhatsApp Number','instant-chat-wp'),array(),
        __('Input the WhatsApp phone number with country DD. Example 1 for U.S.','instant-chat-wp'),
        __('Input the WhatsApp phone number with country DD. Example 1 for U.S.','instant-chat-wp')
);

$this->create_plugin_setting(
        'input',
        'popupMessage',
        __('Popup Message','instant-chat-wp'),array(),
        __('You can set your custom question here.','instant-chat-wp'),
        __('You can set your custom question here.','instant-chat-wp')
);

$this->create_plugin_setting(
        'textarea',
        'message',
        __('Message','instant-chat-wp'),array(),
        __('This message will be displayed as the first message of the conversation.','instant-chat-wp'),
        __('This message will be displayed as the first message of the conversation.','instant-chat-wp')
);

$this->create_plugin_setting(
        'textarea',
        'instant_chat_wp_footer_message',
        __('Footer Message','instant-chat-wp'),array(),
        __('This message will be displayed at the footer of the ChatBox.','instant-chat-wp'),
        __('This message will be displayed at the footer of the ChatBox.','instant-chat-wp')
);

$this->create_plugin_setting(
        'input',
        'headerTitle',
        __('Header Title','instant-chat-wp'),array(),
        __('You can set your custom header title.','instant-chat-wp'),
        __('You can set your custom header title.','instant-chat-wp')
);

$this->create_plugin_setting(
	'select',
	'instant_chat_position',
	__('Position','instant-chat-wp'),
	array(
		'right' => __('Right','instant-chat-wp'), 
		'left' => __('Left','instant-chat-wp')
		),
		
	__('.','instant-chat-wp'),
  __('.','instant-chat-wp')
       );		

$this->create_plugin_setting(
	'select',
	'instantchatwp_multiAgent',
	__('Multiple Agents?','instant-chat-wp'),
	array(
		'false' => __('Deactivated','instant-chat-wp'), 
		'true' => __('Active','instant-chat-wp')
		),
		
	__('.','instant-chat-wp'),
  __('.','instant-chat-wp')
       );

     

       
?>
</table>

  
</div>



<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','instant-chat-wp'); ?>"  />
	
</p>

</form>