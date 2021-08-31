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

function ptmf_admin_assets()
{
    wp_enqueue_style( 'omb-admin-style', plugin_dir_url(__FILE__)."assets/admin/css/style.css", null, time());    
}
add_action( 'admin_enqueue_scripts','ptmf_admin_assets');


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
    
     wp_nonce_field( 'ptmf_posts', 'ptmf_posts_nonce');
     $label = __("Select Posts","post-tax-metafield");
     $metabox_html = <<<EOD
        <div class="fields">
            <div class="field_c">
                <div class="label_c" >
                    <label>{$label}</label>
                </div>
                <div class="input_c">
                    <select name="ptmf_posts" id="ptmf_posts>
                        <option value="0">{$label}</option>
                    </select>
                </div>
            </div>
            <div class="float_c"></div>
        </div>  
     EOD;

     echo $metabox_html;
}









































