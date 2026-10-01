<?php
// Heading
$_['heading_title']       		= 'SyncProdQuantity';

// Text
$_['text_module_title']   		= 'Please enter your second database connection details.';
$_['text_database_host']   		= 'Database Host:';
$_['text_database_host_port']   = 'Database Host Port:';
$_['text_user']					= 'User:';
$_['text_password']   			= 'Password:';
$_['text_database_name']  		= 'Database Name:';
$_['text_database_prefix']		= 'Database Prefix:';
$_['text_sync_by']				= 'Sync Product By:';
$_['text_id']					= 'ID';
$_['text_model']				= 'Model';
$_['text_sku']					= 'SKU';
$_['text_upc']					= 'UPC';
$_['text_ean']					= 'EAN';
$_['text_jan']					= 'JAN';
$_['text_isbn']					= 'ISBN';
$_['text_mpn']					= 'MPN';
$_['text_sync_cat']				= 'Sync Product At:';
$_['text_sync_status']			= 'Sync Product Status:';
$_['text_option_sync']			= 'Sync product option:';
$_['text_option_sync_lang']		= 'Options language:';
$_['text_sync_difference']		= 'Sync difference:';
$_['text_subtract_constant']	= 'Subtract the constant:';
$_['text_module']         		= 'Modules';
$_['text_success']        		= 'Success: You have modified module "SyncProdQuantity > %s "!';

// Entry
$_['entry_name']  				= 'Module Name';
$_['entry_status']				= 'Status';
$_['entry_category']			= 'Name of category(Autocomplete)';

// Help
$_['help_sync_by']				= 'Please select product identifier that will be use for product sync.';
$_['help_sync_cat']				= 'Please select for which categories script will be made product sync.';
$_['help_sync_status']   		= 'Select if you want to sync product \'Enable\', \'Disable\' status.';
$_['help_option_sync']   		= 'If on your site you use stock for option then please choose yes. Options will sync by names.';
$_['help_option_sync_lang']   	= 'For multilanguage stores. For options stock sync module is use option name. Please select language of option name, that will use for sync. Note: This language must be on both stores and option name for this language on both stores must be same!';
$_['help_sync_difference']		= 'Select if you want to sync differences between the new and old product quantity value. This product quantity differences will be added to the product quantity at second shop to increase or decrease the product quantity.';
$_['help_subtract_constant']	= 'Please enter the product quantity that will subtract from sync product quantity for second shop';

// Error
$_['error_field']    			= 'This field is required!';
$_['error_not_all']    			= 'Error: Please check your entered data. You must entering all fields with "*"!';
$_['error_conection']    		= '<br>Error: Script can not connecting with database! <br>Connection error: <b class="blink">%s. </b><br>Please check your entered data for connection. <b>Your entered data for module has not saved!!!</b>';
$_['error_permission']    		= 'Warning: You do not have permission to modify module "SyncProdQuantity"!';
?>