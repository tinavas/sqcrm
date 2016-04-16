<?php 
// Copyright SQCRM. For licensing, reuse, modification and distribution see license.txt 
/**
* List view data 
* @author Abhik Chakraborty
*/
$list_object = new  cpanel_quotes\Quotes() ;
$fields = $list_object->list_view_fields ;
$do_crm_fields = new \CRMFields();
$fields_info = $do_crm_fields->get_specific_fields_information($fields,13,true);
$module_namespace = 'cpanel_quotes' ;
if (isset($_GET['ajaxreq']) && $_GET['ajaxreq'] == true) {
	require_once('view/listview_entry.php');
} else {
	require_once('view/listview.php');
}
?>