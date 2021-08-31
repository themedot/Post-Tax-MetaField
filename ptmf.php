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


function ptmf_add_metabox(){
    add_meta_box(
        'ptmf_select_posts_mb',
        __('Select Posts','our-metabox'),
        'ptmf_display_metabox',
        array('page')
    );
}
add_action('admin_menu','ptmf_add_metabox');

function ptmf_display_metabox(){
    
}