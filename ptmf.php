<?php
/*
Plugin Name: Post nad Taxonomy Selector
Plugin URI: http://example.com/
Description: This is a post tax meta field plugin
Version: 1.0
Author: sadat himel
Author URI: http://example.com/
License: GPLv2 or later
Text Domain: post-tax-metafield
Domain Path: /languages
*/


function ptmf_load_texdomain(){
    load_plugin_textdomain('post-tax-metafield',false,dirname(__FILE__)."/languages");
}
add_action('plugin_loaded','ptmf_load_texdomain');