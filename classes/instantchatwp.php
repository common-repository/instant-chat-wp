<?php
class InstantChatWP {

	function __construct(){
		$this->logged_in_user = 0;
		$this->login_code_count = 0;
		$this->current_page = sanitize_url($_SERVER['REQUEST_URI']);
		$this->set_allowed_html();
        $this->ini_ajax_call();
        $this->set_display();   
	}

    public function set_display(){
        add_filter('the_content', array(&$this, 'showPost'), 89);	       
    }

    public function ini_ajax_call(){
        add_action( 'wp_ajax_instantchatwp_save_stat',  array( &$this, 'save_conversation' ));
		add_action( 'wp_ajax_nopriv_instantchatwp_save_stat',  array( &$this, 'save_conversation' ));
    }

    public function plugin_init(){			
		/*Load Amin Classes*/		
		if (is_admin()) {
			$this->set_admin_classes();
			$this->load_classes();		
		}else{			
			/*Load Main classes*/
			$this->set_main_classes();
			$this->load_classes();
		}
		
		//ini settings
		$this->intial_settings();	
        $this->iniDatabase();	
	}

    public function intial_settings(){	 
		add_action('wp_enqueue_scripts', array(&$this, 'add_front_end_styles'), 9); 		
	}

    public function iniDatabase(){
		global $wpdb;   
		$query = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'instantchat_whatsapp_stats (
				`whats_id` bigint(20) NOT NULL auto_increment,
                `whats_user_id` int(11)  DEFAULT NULL,
				`whats_name`varchar(300) NOT NULL,
				`whats_cel` varchar(300) NOT NULL,		
                `whats_ip` varchar(300) NOT NULL,
                `whats_message` varchar(300) NOT NULL,	
                `whats_url` varchar(300) NOT NULL,	
                `whats_date` datetime NOT NULL,	
				`whats_reply_date` datetime NOT NULL,
                `whats_status` int(1) NOT NULL DEFAULT "0",						
				PRIMARY KEY (`whats_id`)
			) COLLATE utf8_general_ci;';

		$wpdb->query( $query );    


		$query = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'instantchatwp_staff_availability (
			`avail_id` int(11) NOT NULL AUTO_INCREMENT,
			`avail_staff_id` int(11) NOT NULL,
			`avail_day` int(11) NOT NULL,
			`avail_from` time NOT NULL,
			`avail_to` time NOT NULL,
			PRIMARY KEY (`avail_id`)
	  	) ENGINE=MyISAM COLLATE utf8_general_ci;';

		 $wpdb->query( $query );	
	}

    public function save_conversation(){	 
        global $wpdb;
        $whats_name = sanitize_text_field($_POST['w_stat_name']);
        $whats_cel = sanitize_text_field($_POST['w_stat_cel']);
        $whats_message = sanitize_text_field($_POST['w_stat_message']);
        $whats_url = sanitize_text_field($_POST['whats_url']);
		$whats_agent_id = sanitize_text_field($_POST['whats_agent_id']);
        $whats_ip    = $this->commmonmethods->getUserIpAddr();
		$whats_date = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );

		$new_record = array('whats_name' => $whats_cel,	
							'whats_user_id' => $whats_agent_id,		
							'whats_cel' => $whats_cel,
							'whats_message' => $whats_message,
							'whats_ip' => $whats_ip,
							'whats_date' => $whats_date,
							'whats_url' => $whats_url);	
		$wpdb->insert( $wpdb->prefix . 'instantchat_whatsapp_stats', $new_record, array( '%s', '%s' , '%s' , '%s', '%s', '%s'));
        die();
	}

    public function showPost($content){	 
        return $content . '<div id="InstantChatWPWhatsBtn"></div>';
	}


	public function get_user_meta($user_id, $meta){
		$data = get_user_meta($user_id, $meta, true);		
		return $data;
	}

    	/* register styles */
	public function add_front_end_styles(){
		global $wp_locale, $instantchatwpcomplement;    
         if($this->get_option('instantchatwp_active') == '1'){               
            wp_register_style('instantchatwp_style', instantchatwp_url.'css/instant-chat-wp.css');
            wp_enqueue_style('instantchatwp_style');
			wp_register_script( 'instantchatwp-svgpl', instantchatwp_url.'js/svg-inject.min.js',array('jquery'),  null, true);
            wp_enqueue_script('instantchatwp-svgpl');		
            wp_register_script( 'instantchatwp-pl', instantchatwp_url.'js/instant-chat-wp-front.js',array('jquery'),  null);
            wp_enqueue_script('instantchatwp-pl');
            wp_register_script( 'instantchatwp-front_js', instantchatwp_url.'js/instant-chat-custom.js',array('jquery'),  null, true);
            wp_enqueue_script('instantchatwp-front_js');
			


        }
        wp_add_inline_script( 'instantchatwp-pl', 'const INSTANTCHATWPFRONTV = ' . json_encode( array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),		
		'input_name_placeholder' => __( 'Please, type your name here', 'instant-chat-wp' ) ,	
		'input_cel_placeholder' => __( 'Please, type your cel. number here', 'instant-chat-wp' ) ,	
         ) ), 'before' );

		//get staff list

		$agentsList = '';
		if(isset($instantchatwpcomplement)){
			$agentsList = $instantchatwpcomplement->agent->get_staff_list_public();
		}	

		$footer_message =  $this->get_option('instant_chat_wp_footer_message');		
		if($footer_message==''){
			$link = '<a href="https://instantchatwp.com/download-free/" target="_blank">'.__( 'here!', 'instant-chat-wp' ).'</a>';			
			$footer_message =  sprintf(__( 'Instant Chat WP is free, download and try it now %s ','instant-chat-wp'), $link ) ;
		}		
		 
        $country_detection = "no";		
		wp_localize_script( 'instantchatwp-front_js', 'instantchatwp_pro_front', array(           
			'phone'     => $this->get_option('phone'),	
            'message'     =>  $this->get_option('message'),
            'size'     =>  $this->get_option('size'),
			'footer_message'     =>  $footer_message,
			'footer_message_here'     =>  __( 'here!', 'instant-chat-wp' ),
			'message_box_placeholder'     =>  __( 'Write a reponse', 'instant-chat-wp' ),
            'backgroundColor'     =>  $this->get_option('backgroundColor'),
            'position'     =>  $this->get_option('instant_chat_position'), 
            'popupMessage'     =>  $this->get_option('popupMessage'), 
            'showPopup'     =>  $this->get_option('instant_chat_showPopup'), 
			'multiAgent'     =>  $this->get_option('instantchatwp_multiAgent'), 
			'agentsList'     =>  $agentsList, 						
            'showOnIE'     =>  $this->get_option('showOnIE'), 
            'autoOpenTimeout'     =>  $this->get_option('autoOpenTimeout'), 
            'headerColor'     =>  $this->get_option('headerColor'), 
            'headerTitle'     =>  $this->get_option('headerTitle'), 
            'zIndex'     =>  $this->get_option('zIndex')    ,
            'buttonImage'     =>  $this->get_option('buttonImage')       

        ) );	
	}

	public function set_allowed_html(){
		global $allowedposttags;
		$allowed_html = wp_kses_allowed_html( 'post' );
		$allowed_html['select'] = array(
			'name' => array(),
			'id' => array(),
			'class' => array(),
			'style' => array()
		);

		$allowed_html['option'] = array(
			'name' => array(),
			'id' => array(),
			'class' => array(),
			'value' => array(),
			'selected' => array(),
			'style' => array()
		);

		$allowed_html['input'] = array(
			'name' => true,
			'id' => true,
			'class' => true,
			'value' => true,
			'selected' => true,
			'style' =>true
		);

		$allowed_html['table'] = array(
			'name' => true,
			'id' => true,
			'class' => true,			
			'style' => true
		);

		$allowed_html['td'] = array(
			'name' =>true,
			'id' => true,
			'class' => true,
			'style' => true
		);

		$allowed_html['tr'] = array(
			'name' => array(),
			'id' => array(),
			'class' => array(),
			
		);

		$allowed_atts = array(
			'align'      => array(),
			'span'      => array(),
			'checked'      => array(),
			'class'      => array(),
			'selected'      => array(),
			'type'       => array(),
			'id'         => array(),
			'dir'        => array(),
			'lang'       => array(),
			'style'      => array(),
			'display'      => array(),
			'xml:lang'   => array(),
			'src'        => array(),
			'alt'        => array(),
			'href'       => array(),
			'rel'        => array(),
			'rev'        => array(),
			'target'     => array(),
			'novalidate' => array(),
			'type'       => array(),
			'value'      => array(),
			'name'       => array(),
			'tabindex'   => array(),
			'action'     => array(),
			'method'     => array(),
			'for'        => array(),
			'width'      => array(),
			'height'     => array(),
			'data'       => array(),
			'title'      => array(),			
			'/option'      => array(),
			'label'      => array(),

			'data-staff-id'      => array(),
			'data-staff_id'      => array(),
			'data-id'      => array(),
			'appointment-id'      => array(),
			'message-id'      => array(),
			
			'appointment-status'      => array(),
			'instantchatwp-staff-id'      => array(),				
			'service-id'      => array(),			
			'staff-id'      => array(),	
			'user-id'      => array(),	
			'staff_id'      => array(),		
			
			

			
		);



		$allowedposttags['button']     = $allowed_atts;
		$allowedposttags['form']     = $allowed_atts;
		$allowedposttags['label']    = $allowed_atts;
		$allowedposttags['input']    = $allowed_atts;
		$allowedposttags['textarea'] = $allowed_atts;
		$allowedposttags['iframe']   = $allowed_atts;
		$allowedposttags['script']   = $allowed_atts;
		$allowedposttags['style']    = $allowed_atts;
		$allowedposttags['display']    = $allowed_atts;
	
		$allowedposttags['select']    = $allowed_atts;
		$allowedposttags['option']    = $allowed_atts;
		$allowedposttags['optgroup']    = $allowed_atts;
		$allowedposttags['strong']   = $allowed_atts;
		$allowedposttags['small']    = $allowed_atts;
		$allowedposttags['table']    = $allowed_atts;
		$allowedposttags['span']     = $allowed_atts;
		$allowedposttags['abbr']     = $allowed_atts;
		$allowedposttags['code']     = $allowed_atts;
		$allowedposttags['pre']      = $allowed_atts;
		$allowedposttags['div']      = $allowed_atts;
		$allowedposttags['img']      = $allowed_atts;
		$allowedposttags['h1']       = $allowed_atts;
		$allowedposttags['h2']       = $allowed_atts;
		$allowedposttags['h3']       = $allowed_atts;
		$allowedposttags['h4']       = $allowed_atts;
		$allowedposttags['h5']       = $allowed_atts;
		$allowedposttags['h6']       = $allowed_atts;
		$allowedposttags['ol']       = $allowed_atts;
		$allowedposttags['ul']       = $allowed_atts;
		$allowedposttags['li']       = $allowed_atts;
		$allowedposttags['em']       = $allowed_atts;
		$allowedposttags['hr']       = $allowed_atts;
		$allowedposttags['br']       = $allowed_atts;
		$allowedposttags['tr']       = $allowed_atts;
		$allowedposttags['td']       = $allowed_atts;
		$allowedposttags['p']        = $allowed_atts;
		$allowedposttags['a']        = $allowed_atts;
		$allowedposttags['b']        = $allowed_atts;
		$allowedposttags['i']        = $allowed_atts;

		$this->allowed_html = $allowedposttags;

	}

    /* get setting */
	function get_option($option){
		$settings = get_option('instantchatwp_options');
		if (isset($settings[$option])){
			if(is_array($settings[$option])){
                return $settings[$option];			
			}else{				
				return stripslashes($settings[$option]);
			}
			
		}else{			
		    return '';
		}		    
	}

	function nicetime($date){
		if(empty($date)) {
			return "No date provided";
				}
	   
		$periods         = array(__("second", 'instant-chat-wp'), 
							     __("minute", 'instant-chat-wp'), 
								 __("hour", 'instant-chat-wp'), 
								 __("day", 'instant-chat-wp'), 
								 __("week", 'instant-chat-wp'), 
								 __("month", 'instant-chat-wp'), 
								 __("year", 'instant-chat-wp'), 
								 __("decade", 'instant-chat-wp'));
		$lengths         = array("60","60","24","7","4.35","12","10");
	   
		$now             = time();
		$now =  current_time( 'timestamp', 0 );

		//$now = date( 'Y-m-d H:i', current_time( 'timestamp', 0 ) );
		$unix_date         = strtotime($date);
		
		
	   
		   // check validity of date
		if(empty($unix_date)) {   
			return "Bad date";
		}
	
		// is it future date or past date
		if($now > $unix_date) {   
			$difference     = $now - $unix_date;
			$tense         =  __("ago", 'instant-chat-wp');
		   
		} else {
			$difference     = $unix_date - $now;
			$tense         =  __("from now", 'instant-chat-wp');
		}
	   
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	   
		$difference = round($difference);
	   
		if($difference != 1) 
		{
			$periods[$j].= "s";
		}
	   
		return "$difference $periods[$j] {$tense}";
	}
	
 
	public function set_main_classes()	{
		 $this->classes_array = array( "commmonmethods" =>"common",		 
		 "shortcode" =>"shorcodes"
		   ); 	
	}
	
	public function set_admin_classes()	{
		$this->classes_array = array( "commmonmethods" =>"common" , 
		 "imagecrop" =>"cropimage",			
		 "shortcode" =>"shorcodes",				
		 "admin" =>"admin"	 
		  
		); 	
	}

    function load_classes(){	
		foreach ($this->classes_array as $key => $class){
			if (file_exists(instantchatwp_path."classes/$class.php")) {
				require_once(instantchatwp_path."classes/$class.php");				
			}
		}	
	}	

}
