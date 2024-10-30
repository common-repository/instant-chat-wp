<?php
global $instantchatwp, $instantchatwpcomplement;

$today = $instantchatwpcomplement->agent->get_total_period('today') ;

$week = $instantchatwpcomplement->agent->get_total_period('week') ;;
$pending_answer = $instantchatwpcomplement->agent->get_total_by_status(0);
$answered = $instantchatwpcomplement->agent->get_total_by_status(1);
$followup = $instantchatwpcomplement->agent->get_total_by_status(2);

$lasts_connections = $instantchatwpcomplement->agent->get_latest_connections(20);

$time_format = get_option( 'time_format' ); 
$date_format = get_option( 'date_format' ); 

$display_date_format = $date_format.' '.$time_format;
	
?>
        
<div class="instantchatwp-welcome-panel">  
    

      <div class="instantchatwp-main-quick-summary" >            
            
          
             <ul>
                <li>                    
                  
                   <p style=""> <?php echo esc_attr($today)?></p>  
                    <small><?php _e('Today','instant-chat-wp')?> </small>                  
                 </li>

                 
                 <li>                   
                  
                   <p style="color:"> <?php echo esc_attr($week)?></p> 
                    <small><?php _e('This Week','instant-chat-wp')?> </small>                   
                 </li>
                 
                 <li>                   
                  
                   <p style="color:"> <?php echo esc_attr($followup)?></p> 
                    <small><?php _e('Follow-up','instant-chat-wp')?> </small>                   
                 </li>
             
                
                 <li><a href="#"  class="instantchatwp-adm-see-appoint-list-quick" instantchatwp-status='0' instantchatwp-type='bystatus'>                    
                      
                       <p style="color: #333"> <?php echo esc_attr($answered)?></p>   
                       <small><?php _e('Answered','instant-chat-wp')?> </small>
                     </a>                
                 </li>
                
                  <li>     
                     
                      <a href="#" class="instantchatwp-adm-see-appoint-list-quick" instantchatwp-status='3' instantchatwp-type='byunpaid'>              
                      
                       <p style="color: #F90000"> <?php echo esc_attr($pending_answer)?></p> 
                       <small><?php _e('Unanswered ','instant-chat-wp')?> </small>
                       
                        </a>                     
                </li>
                
                
           </ul>
           
         </div>

    
    <h2><?php _e('Latest Contact Requests','instant-chat-wp')?> </h2>

    <div class="instantchatwp-main-cont" >

      <?php
				
		if (!empty($lasts_connections)){?>
       
        <table width="100%" class="wp-list-table widefat fixed posts table-generic">
            <thead>
                <tr>                 
                    <th width="15%"><?php _e('Date', 'instant-chat-wp'); ?></th> 
                    <th width="13%"><?php _e('When', 'instant-chat-wp'); ?></th>                 
                    <th width="23%"><?php _e('Agent', 'instant-chat-wp'); ?></th>
                    <th width="20%"><?php _e('Client', 'instant-chat-wp'); ?></th>
                    <th width="20%"><?php _e('Phone Number', 'instant-chat-wp'); ?></th>                    
                    <th width="18%"><?php _e('URL', 'instant-chat-wp'); ?></th>
                    <th width="16%"><?php _e('Message', 'instant-chat-wp'); ?></th>            
                    <th width="11%"><?php _e('Status', 'instant-chat-wp'); ?></th>
                    <th width="7%"><?php _e('Actions', 'instant-chat-wp'); ?></th>
                </tr>
            </thead>
            
            <tbody>
            
            <?php 

			foreach($lasts_connections as $connection) {
				
				
				$date=  date($display_date_format, strtotime($connection->whats_date));
				$nice_time = $instantchatwp->nicetime( $connection->whats_date);
				$agent = get_user_by( 'id', $connection->whats_user_id );

                $contact_name ='N/A';
                if($connection->whats_name !=''){
                    $contact_name = $connection->whats_name;
                }
                $whats_cel ='N/A';
                if($connection->whats_cel!=''){
                    $whats_cel = $connection->whats_cel;
                }
				
			?>
              

            <tr>
                   
                <td><?php echo  esc_attr($date); ?>      </td> 
                <td><?php echo  esc_attr($nice_time); ?>      </td>                       
                <td><?php echo esc_attr($agent->display_name); ?> (<?php echo esc_attr($agent->user_email); ?>)</td>
                <td><?php echo esc_attr($contact_name); ?></td>
                <td><?php echo esc_attr($whats_cel); ?></td>
                <td><?php echo esc_attr($connection->whats_url); ?> </td>
                <td><?php echo  esc_attr($connection->whats_message); ?></td>   
                     
                <td><?php echo wp_kses($instantchatwpcomplement->agent->get_status_legend($connection->whats_status ), $instantchatwp->allowed_html); ?></td>
                <td> <a href="#" class="instantchatwp-connection-edit-module" connection-id="<?php echo esc_attr($connection->whats_id)?>" title="<?php _e('Edit','instant-chat-wp'); ?>"><i class="fa fa-edit"></i></a></td>
            </tr>
              
                
                <?php
					}
					
					} else {
			?>
			<p><?php _e('There are no stats yet.','instant-chat-wp'); ?></p>
			<?php	} ?>

            </tbody>
        </table>

    </div> 

    
</div>   

<div id="instantchatwp-connect-editor-box"></div>
                                          
