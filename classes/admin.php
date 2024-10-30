<?php
class InstantChatWPAdmin extends InstantChatWPCommon {

	var $options;
	var $wp_all_pages = false;
	var $instantchatwp_default_options;
	var $valid_c;

	function __construct(){
		/* Plugin slug and version */
		$this->slug = 'instantchatwp';				
		$this->update_default_option_ini();		
		add_action( 'admin_notices', array(&$this, 'display_custom_message'));
		add_action('admin_menu', array(&$this, 'add_menu'), 9);	
		add_action('admin_enqueue_scripts', array(&$this, 'add_styles'), 9);
		add_action('admin_head', array(&$this, 'admin_head'), 9 );
		add_action('admin_init', array(&$this, 'admin_init'), 9);		
	}


    function admin_init() {	
		
		global $instantchatwpcomplement;
		$this->tabs = array(
		   			
			'settings' => __('Settings','instant-chat-wp'),
		);

		if(isset($instantchatwpcomplement)){

			$this->default_tab = 'main';	

		}else{

			$this->default_tab = 'settings';

		}
		
			
		$this->default_tab_membership = 'settings';		
	}
	
	public function update_default_option_ini (){
		$this->options = get_option('instantchatwp_options');		
		$this->set_default_options();
		
		if (!get_option('instantchatwp_options')){			
			update_option('instantchatwp_options', $this->instantchatwp_default_options );
		}
		
		if (!get_option('instantchatwp_pro_active')){			
			update_option('instantchatwp_pro_active', true);
		}			
		
	}

	/* default options */
	function set_default_options(){
		
		$this->instantchatwp_default_options = array(							
			'instantchatwpcomplement' => 1,
			'phone' => null,
			'popupMessage' => __('Hi, how can I help you?','instant-chat-wp'),
			'message' => __('I would like to receive further information about your services','instant-chat-wp'),
			'size' => 62,
			'position' => 'right',
			'multiAgent' => false,			
			'showPopup' => true,
			'zIndex' => 105000,
			'showOnIE' => false,
			'headerTitle' => __('Welcome','instant-chat-wp'),
			'headerColor' => 'rgb(37 211 102)',
			'backgroundColor' => 'rgb(37 211 102)',
			'buttonImage' => '<img class="instant-chat-whatsap-icon" src="'.instantchatwp_url.'img/whatsapp.svg" />'							
		);
			
	}

    function admin_head(){
		$screen = get_current_screen();
		$slug = $this->slug;
		
	}

	function add_styles(){		
		global $wp_locale, $instantchatwp, $pagenow;	
		
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style("wp-jquery-ui-dialog");
		wp_enqueue_style( 'wp-color-picker' );	

		wp_enqueue_script('plupload-all');	
		wp_enqueue_script('jquery-ui-progressbar');	
		 
		wp_register_style('instantchatwp_admin', instantchatwp_url.'admin/css/admin.css');
		wp_enqueue_style('instantchatwp_admin');	
		
		wp_register_style('instantchatwp_fawesome', instantchatwp_url.'css/css/font-awesome.min.css');
		wp_enqueue_style('instantchatwp_fawesome');
			
		/*google graph*/		
		wp_register_script('bupro_jsgooglapli', 'https://www.gstatic.com/charts/loader.js');
		wp_enqueue_script('bupro_jsgooglapli');				
			
		$current_tab = '';
		if(isset($_GET['tab'])){
			$current_tab = sanitize_text_field($_GET['tab']);
		}  

		wp_register_script( 'instantchatwp_admin', instantchatwp_url.'admin/js/instant-chat-admin.js', array( 
			'jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-droppable',	'jquery-ui-sortable', 'wp-color-picker',  'jquery-ui-position'	), null );
		wp_enqueue_script( 'instantchatwp_admin' );

		
		wp_localize_script( 'instantchatwp_admin', 'instantchatwp_admin_v98', array(          
			'msg_pending_requests'  => __( 'Pending Requests', 'instant-chat-wp' )          
            
        ) );	
		
	}
    
    public  function getShortLocale() {
        $locale = $this->getLocale();
        if ( $second = strpos( $locale, '_', min( 3, strlen( $locale ) ) ) ) {
            $locale = substr( $locale, 0, $second );
        }

        return $locale;
    }
    
    public  function getLocale() {
        $locale = get_locale();
        if ( function_exists( 'get_user_locale' ) ) {
            $locale = get_user_locale();
        }
        return $locale;
    }

    function add_menu()	{
		global $instantchatwp, $instantchatwpcomplement ;
		
		$pending_count =0;
		$pending_title = esc_attr( sprintf(__( '%d  pending contact requests','instant-chat-wp'), $pending_count ) );
		
		if ($pending_count > 0){
			$menu_label = sprintf( __( 'Instant Chat WP %s','instant-chat-wp' ), "<span class='update-plugins count-$pending_count' title='$pending_title'><span class='update-count'>" . number_format_i18n($pending_count) . "</span></span>" );
		} else {
            $menu_label = __('Instant Chat WP','instant-chat-wp');
		}
		
		add_menu_page( __('Instant Chat WP Pro','instant-chat-wp'), $menu_label, 'manage_options', $this->slug, array(&$this, 'admin_page'), instantchatwp_url .'admin/images/small_logo_16x16.png', '159.140');
		add_submenu_page( $this->slug, __('Agents','instant-chat-wp'), __('Agents','instant-chat-wp'), 'manage_options', ''.$this->slug.'&tab=users', array(&$this, 'admin_page') );
		add_submenu_page( $this->slug, __('Appearance','instant-chat-wp'), __('Appearance','instant-chat-wp'), 'manage_options', ''.$this->slug.'&tab=customize', array(&$this, 'admin_page') );

		add_submenu_page( $this->slug, __('Settings','instant-chat-wp'), __('Settings','instant-chat-wp'), 'manage_options', ''.$this->slug.'&tab=settings', array(&$this, 'admin_page') );
		add_submenu_page( $this->slug, __('Go Premium','instant-chat-wp'), __('Go Premium','instant-chat-wp'), 'manage_options', ''.$this->slug.'&tab=pro', array(&$this, 'admin_page') );

		do_action('instantchatwp_admin_menu_hook');
	}

	function admin_tabs( $current = null ){
		 global $bupultimate, $bupcomplement;
			$tabs = $this->tabs;
			$links = array();
			if ( isset ( $_GET['tab'] ) ) {
				$current = sanitize_text_field($_GET['tab']);
			} else {
				$current = $this->default_tab;
			}
			foreach( $tabs as $tab => $name ) :
			
				$custom_badge = "";
				
				if($tab=="pro"){					
					$custom_badge = 'instantchatwp-pro-tab-bubble ';					
				}
				
				if(isset($bupcomplement) && $tab=="pro"){continue;}
				
				if ( $tab == $current ) :
					$links[] = "<a class='nav-tab nav-tab-active ".$custom_badge."' href='?page=".$this->slug."&tab=$tab'>$name</a>";
				else :
					$links[] = "<a class='nav-tab ".$custom_badge."' href='?page=".$this->slug."&tab=$tab'>$name</a>";
				endif;
				
			endforeach;
			foreach ( $links as $link )
				echo esc_url($link);
	}
	
	function do_action(){
		global $bup;				
		
	}

    function include_tab_content() {
		
		global $instantchatwp, $wpdb, $instantchatwpcomplement ;		
		$screen = get_current_screen();
		
		if( strstr($screen->id, $this->slug ) ) {
			if ( isset ( $_GET['tab'] ) ){
				$tab = sanitize_text_field($_GET['tab']);				
			} else {				
				$tab = $this->default_tab;
			}

			$this->current_tab = $tab;			
			if($this->valid_c=="" ){


				require_once (instantchatwp_path.'admin/tabs/'.$tab.'.php');			
			
			}else{ //no validated
				$tab = "licence";				
				require_once (instantchatwp_path.'admin/tabs/'.$tab.'.php');
			}
			
		}
	}
	
	/* set a global option */
	function instantchatwp_set_option($option, $newvalue){
		$settings = get_option('instantchatwp_options');		
		$settings[$option] = $newvalue;
		update_option('instantchatwp_options', $settings);
	}

	// update settings
	function update_settings() 	{
		global $insantchatwp;
		foreach($_POST as $key => $value){	
			if ($key != 'submit'){					
				$this->instantchatwp_set_option($key, $value) ; 
			}
		}	
			  
		if( isset ($_GET['tab']) ) {
			$current = sanitize_text_field($_GET['tab']);				
		}else{
			$current = sanitize_text_field($_GET['page']);				
		}	
				
		$special_with_check = $this->get_special_checks($current);			 
		foreach($special_with_check as $key){       
			if(!isset($_POST[$key])){
				$value= '0';
			}else{
				$value= sanitize_text_field($_POST[$key]);
			} 	
			$this->instantchatwp_set_option($key, $value) ;  
		}
			 
		$this->options = get_option('instantchatwp_options');	
		$text_sett = __('Settings saved.','instant-chat-wp');
		echo  wp_kses( '<div class="updated"><p><strong>'.$text_sett.'</strong></p></div>',  $instantchatwp->allowed_html);
	}
		
	public function get_special_checks($tab){
		$special_with_check = array();			
		if($tab=="settings"){
			$special_with_check = array('instantchatwp_active');
		}
		return  $special_with_check ;
	}	

	function display_custom_message(){
		global $instantchatwp; $instantchatwpcomplement;
		$message = '';
		if($this->get_option('phone') == ''){

			$message .= '<div id="message" class="updated instantchatwp-message wc-connect">
				<p><strong>INSTANT CHAT WP IMPORTANT ADVICE:</strong> – '.__('You must to set a valid WhatsApp Number','instant-chat-wp').'</p>
				<p class="submit">
		<a href="?page=instantchatwp&tab=settings" class="button-primary" >'.__('Go to Settings','instant-chat-wp').'</a>
		
	</p>
				
				</div>';
		}
		echo  wp_kses($message ,  $instantchatwp->allowed_html);
	}

    function admin_page() {
		global $instantchatwp; $instantchatwpcomplement;

		if ( isset ( $_GET['tab'] ) ) {

				$tab = sanitize_text_field($_GET['tab']);
				
		} else {
				
				$tab = $this->default_tab;
		}
		
		
		if (isset($_POST['update_settings']) ) {
            $this->update_settings();
        }

		
			
	?>
	
	<div class="wrap <?php echo esc_attr($this->slug); ?>-admin"> 

		<?php if($tab !='welcome' && $tab !='pro'){ ?>            
            
            <div class="wrap instantchatwp-top-main-bar">
				<div class="instantchatwp-top-main-texts">
				<div class="instantchatwp-top-main-plugin-name">

					<?php
					$urlText = __('INSTANT CHAT WP','instant-chat-wp');
					_e('<a href="?page=instantchatwp">'.$urlText.'</a>');?>
				</div>			
					<ul>
						<li>
							<a href="?page=instantchatwp"><i class="fa fa-home fa-2x"></i><p><?php _e('DASHBOARD','instant-chat-wp');?></p></a>
						</li>	

						<li>   
							<a href="?page=instantchatwp&tab=users"><i class="fa fa-users fa-2x"></i><p><?php _e('AGENTS','instant-chat-wp');?></p></a>
						</li>

						<li class="pro">   
							<a href="https://instantchatwp.com/#pricing"><i class="fa fa-unlock fa-2x pro"></i><p><?php _e('GO PRO','instant-chat-wp');?></p></a>
						</li>
					</ul>
				</div>
            </div>

			<?php  }?>
            

			<div class="<?php echo esc_attr($this->slug); ?>-admin-contain">     
            
			
				<?php $this->include_tab_content(); ?>				
				<div class="clear"></div>
				
			</div>
			
		</div>

	<?php }
	

	
}
$key = "admin";
$this->{$key} = new InstantChatWPAdmin();