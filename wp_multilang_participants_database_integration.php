 
<?php

/*
Plugin Name: WP Multilang integration for Participants Database
Plugin URI: 
Description: This plugin enables translations for Participants Database plugin. It translates option page, field manager and field groups.
Author: Anthony R
Version: 0.1
Author URI: 
*/

function wpm_pdb_save_options($value, $old_value) {
  
  	$translatable_fields = [
  		'empty_field_message',
  		'invalid_field_message',
  		'nonmatching_field_message',
  		'captcha_field_message',
  		'required_field_marker',
  		'signup_button_text',
  		'signup_thanks_page',
  		'duplicate_field_message',
  		'receipt_from_name',
  		'signup_receipt_email_subject',
  		'signup_receipt_email_body',
  		'email_signup_notify_subject',
  		'email_signup_notify_body',
  		'save_changes_label',
  		'save_changes_button',
  		'record_updated_message',
  		'no_record_error_message',
  		'record_update_email_subject',
  		'record_update_email_body',
  		'no_records_message',
  		'count_template',
  		'retrieve_link_text',
  		'retrieve_link_title',
  		'retrieve_link_success',
  		'id_field_prompt',
  		'retrieve_link_email_subject',
  		'retrieve_link_email_body',
  		'retrieve_link_notify_subject',
  		'retrieve_link_notify_body',
  		'identifier_field_message',
  	];


  	if (!is_array( $old_value ) || empty( $old_value )) {
  		return $value;
  	}
  		foreach ($value as $key => $field) {
  			if (isset($old_value[$key])) {
  				if (in_array($key, $translatable_fields) && $old_value[$key] != $field) {
  					$value[$key] = wpm_set_new_value($old_value[$key], $field);
  				}
  			}
  		}
      
  	return $value;
}

add_filter('pre_update_option_participants-database_options', 'wpm_pdb_save_options', 10, 2);


function wpm_pdb_translate_options($value) {
  
  	if (!is_array( $value ) || empty( $value )) {
  		return $value;
  	}
  	foreach ($value as $key => $field) {
  		$value[$key] = wpm_translate_string($field);
  	}

  	return $value;

}


add_filter('option_participants-database_options', 'wpm_pdb_translate_options');


function wpm_pdb_save_fields($row, $status) {
  
  	$translatable_fields = [
  		"title",
  		"help_text",
  		"validation_message",
  		"default",
  //         "options",
  	];

  	$old_field = Participants_Db::get_field_def($status["name"]);

  	foreach ($row as $key => $value) {
  			if (in_array($key, $translatable_fields)) {
  				$row[$key] = wpm_set_new_value($old_field->$key, $value);
  			}
  	}

  	return $row;

}

add_filter('pdb-update_field_def', 'wpm_pdb_save_fields', 10, 2);
