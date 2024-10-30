if(typeof $ == 'undefined'){
	var $ = jQuery;
}
$(function () {

    /* open staff member form */	
	jQuery( "#instantchatwp-staff-editor-box" ).dialog({
        autoOpen: false,			
        width: '400', // overcomes width:'auto' and maxWidth bug
           maxWidth: 900,
        responsive: true,
        fluid: true, //new option
        modal: true,
        buttons: {
        "Add": function() {				
            
            var ret;
            
            var staff_name=   jQuery("#staff_name").val();
            var staff_email=   jQuery("#staff_email").val();
            var staff_nick=   jQuery("#staff_nick").val();	
            jQuery("#instantchatwp-err-message" ).html( '' );		
                        
            jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {"action": "instantchatwp_add_staff_confirm", "staff_name": staff_name, "staff_email": staff_email , "staff_nick": staff_nick },
                    
                    success: function(data){
                        
                        
                        var res = data;						
                        
                        if(isInteger(res))	
                        {
                            //load staff								
                            instantchatwp_load_staff_adm(res);																
                            jQuery("#instantchatwp-staff-editor-box" ).dialog( "close" );
                            
                                                    
                        }else{
                        
                            jQuery("#instantchatwp-err-message" ).html( res );	
                        
                        }				
                                                
                         
                        
                        
                        }
                });
            
            
            
        
        },
        
        "Cancel": function() {
            
            
            jQuery( this ).dialog( "close" );
        },
        
        
        },
        close: function() {
        
        
        }
    });

    function isInteger(x) {
        return x % 1 === 0;
    }

    jQuery(document).on("click", ".instantchatwp-staff-load", function(e) {
        e.preventDefault();        
        var staff_id =  jQuery(this).attr("staff-id");			
        instantchatwp_load_staff_member(staff_id);	            
        e.preventDefault();
    });

    //this will crop the avatar and redirect
	jQuery(document).on("click touchstart", "#uultra-confirm-avatar-cropping", function(e) {
			
        e.preventDefault();		
        
        var x1 = jQuery('#x1').val();
        var y1 = jQuery('#y1').val();
        var w = jQuery('#w').val();
        var h = jQuery('#h').val();
        var image_id = $('#image_id').val();
        var user_id = $('#user_id').val();				
        
        if(x1=="" || y1=="" || w=="" || h==""){
            alert("You must make a selection first");
            return false;
        }
        jQuery('#instantchatwp-cropping-avatar-wait-message').html(message_wait_availability);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {"action": "instantchatwp_crop_avatar_user_profile_image", "x1": x1 , "y1": y1 , "w": w , "h": h  , "image_id": image_id , "user_id": user_id},
            
            success: function(data){					
                //redirect				
                var site_redir = jQuery('#site_redir').val();
                window.location.replace(site_redir);	
                            
                
                
            }
        });
        
         return false;
        e.preventDefault();
            
    });

    jQuery(document).on("click", "#instantchatwp-btn-user-details-confirm", function(e) {
		e.preventDefault();	
		var staff_id =  jQuery(this).attr("data-field");
		var staff_id =  jQuery('#staff_id').val();
		var display_name =  jQuery('#reg_display_name').val();
		var reg_telephone =  jQuery('#reg_telephone').val();
        var u_profession =  jQuery('#u_profession').val();		  
		var reg_email =  jQuery('#reg_email').val();
		var reg_email2 =  jQuery('#reg_email2').val();

        var intantchwp_onlinetext =  jQuery('#intantchwp_onlinetext').val();
		var intantchwp_offlinetext =  jQuery('#intantchwp_offlinetext').val();

		jQuery("#instantchatwp-edit-details-message").html(message_wait_availability);	 
		
		jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {"action": "instantchatwp_update_staff_admin", 
						"staff_id": staff_id , 
						"display_name": display_name ,
						"reg_email": reg_email , 
						"reg_email2": reg_email2 , 
						"reg_telephone": reg_telephone ,
                        "u_profession": u_profession ,
                        "intantchwp_onlinetext": intantchwp_onlinetext,
                        "intantchwp_offlinetext": intantchwp_offlinetext},
						
						success: function(data){							
						
							jQuery("#instantchatwp-edit-details-message").html(data);				
						}
				});
			
	});


    	//this adds the user and loads the user's details	
	jQuery(document).on("click", "#instantchatwp-save-glogal-business-hours-staff", function(e) {
			
        e.preventDefault();			
        
        var staff_id =  jQuery(this).attr("instantchatwp-staff-id");
        
        var instantchatwp_mon_from=   jQuery("#instantchatwp-mon-from").val();
        var instantchatwp_mon_to=   jQuery("#instantchatwp-mon-to").val();			
        var instantchatwp_tue_from=   jQuery("#instantchatwp-tue-from").val();
        var instantchatwp_tue_to=   jQuery("#instantchatwp-tue-to").val();			
        var instantchatwp_wed_from=   jQuery("#instantchatwp-wed-from").val();
        var instantchatwp_wed_to=   jQuery("#instantchatwp-wed-to").val();			
        var instantchatwp_thu_from=   jQuery("#instantchatwp-thu-from").val();
        var instantchatwp_thu_to=   jQuery("#instantchatwp-thu-to").val();			
        var instantchatwp_fri_from=   jQuery("#instantchatwp-fri-from").val();
        var instantchatwp_fri_to=   jQuery("#instantchatwp-fri-to").val();			
        var instantchatwp_sat_from=   jQuery("#instantchatwp-sat-from").val();
        var instantchatwp_sat_to=   jQuery("#instantchatwp-sat-to").val();			
        var instantchatwp_sun_from=   jQuery("#instantchatwp-sun-from").val();
        var instantchatwp_sun_to=   jQuery("#instantchatwp-sun-to").val();			
            
        jQuery("#instantchatwp-err-message" ).html( '' );	
        jQuery("#instantchatwp-loading-animation-business-hours" ).show( );		
                    
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {"action": "instantchatwp_update_staff_business_hours", 
                "staff_id": staff_id,					
                "instantchatwp_mon_from": instantchatwp_mon_from, "instantchatwp_mon_to": instantchatwp_mon_to ,
                "instantchatwp_tue_from": instantchatwp_tue_from, "instantchatwp_tue_to": instantchatwp_tue_to ,
                "instantchatwp_wed_from": instantchatwp_wed_from, "instantchatwp_wed_to": instantchatwp_wed_to ,
                "instantchatwp_thu_from": instantchatwp_thu_from, "instantchatwp_thu_to": instantchatwp_thu_to ,
                "instantchatwp_fri_from": instantchatwp_fri_from, "instantchatwp_fri_to": instantchatwp_fri_to ,
                "instantchatwp_sat_from": instantchatwp_sat_from, "instantchatwp_sat_to": instantchatwp_sat_to ,
                "instantchatwp_sun_from": instantchatwp_sun_from, "instantchatwp_sun_to": instantchatwp_sun_to ,
                 
                 },
                
                success: function(data){
                    var res = data;		
                    jQuery("#instantchatwp-err-message" ).html( res );						
                    jQuery("#instantchatwp-loading-animation-business-hours" ).hide( );		
                    
                }
            });
        
        
         // Cancel the default action
        e.preventDefault();
            
    });

    /* open staff member form */	
	jQuery( "#instantchatwp-connect-editor-box" ).dialog({
        autoOpen: false,			
        width: '400', // overcomes width:'auto' and maxWidth bug
         maxWidth: 900,
        responsive: true,
        fluid: true, //new option
        modal: true,
        buttons: {
        "Submit": function() {				
            
            var ret;            
            var conn_id=   jQuery("#conn_id").val();
            var whats_status=   jQuery("#whats_status").val();          
                        
            jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {"action": "instantchatwp_connection_update", 
                           "conn_id": conn_id, 
                           "whats_status": whats_status  },                    
                    success: function(data){
                        var res = data;					
                        jQuery("#instantchat-err-message" ).html( res );
                        jQuery("#instantchatwp-connect-editor-box" ).dialog( "close" );
                    }
                });            
        
        },
        
        "Cancel": function() {            
            jQuery( this ).dialog( "close" );
        },
        
        },
        close: function() {
        
        }
    });

    jQuery(document).on("click", ".instantchatwp-connection-edit-module", function(e) {
        e.preventDefault();	
        var connection_id =  jQuery(this).attr("connection-id");
        jQuery("#instantchatwp-spinner").show();		
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {"action": "instantchatwp_get_connection_details",
                       "con_id": connection_id},
                success: function(data){							
                    jQuery("#instantchatwp-connect-editor-box" ).html( data );							
                    jQuery("#instantchatwp-connect-editor-box" ).dialog( "open" );
                    jQuery("#instantchatwp-spinner").hide();
                    
                }
            });
        e.preventDefault();
    });

    jQuery(document).on("click", "#instant-chat-save-customizer", function(e) {
        e.preventDefault();	
        var instantchatwp_customize_header_bg=   jQuery("#instantchatwp_customize_header_bg").val();
        var instantchatwp_customize_footer_color=   jQuery("#instantchatwp_customize_footer_color").val();
        var instantchatwp_customize_icon_color=   jQuery("#instantchatwp_customize_icon_color").val();
        var instantchatwp_customize_agent_color=   jQuery("#instantchatwp_customize_agent_color").val();
        var instantchatwp_customize_schedule_color=   jQuery("#instantchatwp_customize_schedule_color").val();

        jQuery("#instantchatwp-spinner").show();		
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {"action": "instantchatwp_save_appearance",
                       "instantchatwp_customize_header_bg": instantchatwp_customize_header_bg,
                       "instantchatwp_customize_footer_color": instantchatwp_customize_footer_color,
                       "instantchatwp_customize_icon_color": instantchatwp_customize_icon_color,
                       "instantchatwp_customize_agent_color": instantchatwp_customize_agent_color,
                       "instantchatwp_customize_schedule_color": instantchatwp_customize_schedule_color},
                success: function(data){							
                    				
                  
                   
                    
                }
            });
        e.preventDefault();
    });
    

    var $form   = $('#business-hours');
    jQuery(document).on("change", ".instantchatwp_select_start", function(e) {	
        
        var $row = $(this).parent(),
            $end_select = $('.instantchatwp_select_end', $row),
            $start_select = $(this);

        if ($start_select.val()) {
            $end_select.show();
            $('span', $row).show();

            var start_time = $start_select.val();

            $('span > option', $end_select).each(function () {
                $(this).unwrap();
            });

            // Hides end time options with value less than in the start time
            $('option', $end_select).each(function () {
                if ($(this).val() <= start_time) {
                    
                    $(this).wrap("<span>").parent().hide();
                }
            });
            
        
            if (start_time >= $end_select.val()) {
                $('option:visible:first', $end_select).attr('selected', true);
            }
        } else { // OFF
        
            $end_select.hide();
            $('span', $row).hide();
        }
        
    }).each(function () {
        var $row = $(this).parent(),
            $end_select = $('.instantchatwp_select_end', $row);

        $(this).data('default_value', $(this).val());
        $end_select.data('default_value', $end_select.val());

        // Hides end select for "OFF" days
        if (!$(this).val()) {
            $end_select.hide();
            $('span', $row).hide();
        }
    }).trigger('change');


    jQuery(document).on("click", "#instantchatwp-add-staff-btn", function(e) {
			
        e.preventDefault();	        
        jQuery("#instantchatwp-spinner").show();	
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {"action": "instantchatwp_get_new_staff" },
                success: function(data){							
                    jQuery("#instantchatwp-staff-editor-box" ).html( data );							
                    jQuery("#instantchatwp-staff-editor-box" ).dialog( "open" );
                    jQuery("#instantchatwp-spinner").hide();                    
                }
            });       

        e.preventDefault();        
    });
});

function instantchatwp_load_staff_adm(staff_id ){
	setTimeout("instantchatwp_load_staff_list_adm()", 1000);
	setTimeout("instantchatwp_load_staff_details(" + staff_id +")", 1000);
	
}



function instantchatwp_load_staff_list_adm(){
	jQuery("#instantchatwp-spinner").show();	
    jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "instantchatwp_get_staff_list_admin_ajax"},
					
					success: function(data){					
						
						var res = data;						
						jQuery("#instantchatwp-staff-list").html(res);
						jQuery("#instantchatwp-spinner").hide();					    
						
												

						}
				});	
	
}

function instantchatwp_load_staff_details(staff_id)	{
	jQuery("#instantchatwp-spinner").show();	
    jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "instantchatwp_get_staff_details_admin", "staff_id": staff_id},
					
					success: function(data){					
						
						var res = data;						
						jQuery("#instantchatwp-staff-details").html(res);		
						jQuery("#instantchatwp-spinner").hide();

					}
				});	
}

function instantchatwp_load_staff_member (staff_id){
		jQuery("#instantchatwp-spinner").show();
		  jQuery.post(ajaxurl, {
							action: 'instantchatwp_get_staff_details_ajax', 'staff_id': staff_id
									
							}, function (response){									
																
							jQuery("#instantchatwp-staff-details" ).html( response );			
																		
							jQuery("#instantchatwp-spinner").hide();
							
		 });
}