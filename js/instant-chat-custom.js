if(typeof $ == 'undefined'){
	var $ = jQuery;
}
$(function () {
    

    $('#InstantChatWPWhatsBtn').instantchatwpWhatsApp({
        phone: instantchatwp_pro_front.phone,
        popupMessage:instantchatwp_pro_front.popupMessage,
        message: instantchatwp_pro_front.message,
        footer_message: instantchatwp_pro_front.footer_message,
        footer_message_here: instantchatwp_pro_front.footer_message_here,
        message_box_placeholder: instantchatwp_pro_front.message_box_placeholder,     
        
        size:instantchatwp_pro_front.size,
        position: instantchatwp_pro_front.position,
        multiAgent: instantchatwp_pro_front.multiAgent,
        agentsList: instantchatwp_pro_front.agentsList,        
        showPopup: instantchatwp_pro_front.showPopup,
        zIndex:instantchatwp_pro_front.zIndex,
        showOnIE: instantchatwp_pro_front.showOnIE,
        headerTitle: instantchatwp_pro_front.headerTitle,
        headerColor: instantchatwp_pro_front.headerColor,
        backgroundColor: instantchatwp_pro_front.backgroundColor,
        buttonImage: instantchatwp_pro_front.buttonImage

    });
});