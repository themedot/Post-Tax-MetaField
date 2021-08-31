<?php
/*
Plugin Name: Post and Taxonomy Selector
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

function ptmf_save_meta($post_id){
    if (!ptmf_is_secured('ptmf_posts_nonce','ptmf_posts',$post_id)) {
        return $post_id;
    }
    $selected_post_id = $_POST['ptmf_posts'];
    if($selected_post_id > 0){
        update_post_meta( $post_id, 'ptmf_selected_post', $selected_post_id );
    }
}
add_action( 'save_post', 'ptmf_save_meta');

function ptmf_display_metabox($post){
    $selected_post_id = get_post_meta($post->ID,'ptmf_selected_post',true);
    echo $selected_post_id;
     wp_nonce_field( 'ptmf_posts', 'ptmf_posts_nonce');

     $args = array(
        'post_type' => 'post',
        'post_per_page' => -1
     );

     $dropdown_list = '';
     $_posts = new wp_query($args);
     while($_posts->have_posts()){
        $extra = "";
        $_posts->the_post();
        if (get_the_ID() == $selected_post_id) {
            $extra = 'selected';
        }
        $dropdown_list .= sprintf("<option %s value='%s'>%s</option>",$extra,get_the_ID(),get_the_title());
     }
     wp_reset_query();


     $label = __("Select Posts","post-tax-metafield");
     $metabox_html = <<<EOD
        <div class="fields">
            <div class="field_c">
                <div class="label_c" >
                    <label>{$label}</label>
                </div>
                <div class="input_c">
                    <select name="ptmf_posts" id="ptmf_posts">
                        <option value="0">{$label}</option>
                        {$dropdown_list}
                    </select>
                </div>
            </div>
            <div class="float_c"></div>
        </div>  
     EOD;

     echo $metabox_html;
}


if (!function_exists('ptmf_is_secured')) {
    function ptmf_is_secured($nonce_field, $action, $post_id)
    {
        $nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field]:"";

        if ($nonce == '') {
            return false;
        }

        if (!wp_verify_nonce($nonce, $action)) {
            return false;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }

        if (wp_is_post_autosave($post_id)) {
            return false;
        }

        if (wp_is_post_revision($post_id)) {
            return false;
        }
        return true;
    }
}




































