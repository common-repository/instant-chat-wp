<?php
class InstantChatWPShortCode {

	function __construct(){
		add_action( 'init',   array(&$this,'shortcodes'));	
		add_action( 'init', array(&$this,'respo_base_unautop') );
	}
	
	/**
	* Add the shortcodes
	*/
	function shortcodes(){
	    add_filter( 'the_content', 'shortcode_unautop');			
		add_shortcode( 'instantchatwp_widget', array(&$this,'chat_widget') );		
	}
	
	/**
	* Don't auto-p wrap shortcodes that stand alone
	*/
	function respo_base_unautop() {
		add_filter( 'the_content',  'shortcode_unautop');
	}
	
	public function  chat_widget ($atts){
		global $getbookingwp;			
	}	
}
$key = "shortcode";
$this->{$key} = new InstantChatWPShortCode();