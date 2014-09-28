<?php

/*
Plugin Name: Advanced Custom Fields: Multi Taxonomy Chooser
Plugin URI: https://github.com/reyhoun/acf-multi-taxonomy-chooser
Description: Choose multi taxonomies.
Version: 1.1.0
Author: Reyhoun
Author URI: http://reyhoun.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-multi-taxonomy-chooser', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 




// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_multi_taxonomy_chooser( $version ) {
	
	include_once('acf-multi-taxonomy-chooser-v5.php');
	
}

add_action('acf/include_field_types', 'include_field_types_multi_taxonomy_chooser');	




	
?>