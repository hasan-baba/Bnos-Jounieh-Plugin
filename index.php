<?php
/*
Plugin Name: Registration Functionality
Description: Registration Functionality for BnosJounieh
Author: Hasan Al Baba
Version: 1.0.0
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

// calling sidebar menu
include_once dirname(__FILE__) . '/admin/admin-menu.php';
include_once dirname(__FILE__) . '/admin/pages/bnosjounieh_welcome.php';
include_once dirname(__FILE__) . '/admin/pages/scan_visit.php';
//include_once dirname(__FILE__) . '/admin/functions/functions.php';

// include shortcodes
include_once dirname(__FILE__) . '/functions/shortcodes/add_new_visit.php';

// enque funcionalities
include_once dirname(__FILE__) . '/functions/functions.php';

// enque databases
include_once dirname(__FILE__) . '/functions/visitors_db.php';
include_once dirname(__FILE__) . '/functions/visits_status_db.php';

// including front styles and JS files
function visits_front_enque_scripts()
{
    // styles
//    $allowed_pages = array('/my-account/view-all-visits/', '/my-account/add-new-visit/', '/my-account/view-all-visits', '/my-account/add-new-visit');
//    $current_url = $_SERVER['REQUEST_URI'];
//
//    if (in_array($current_url, $allowed_pages)) {
//
//    }
    wp_enqueue_style('bootstrap-min-css', plugin_dir_url(__FILE__) . 'assets/bootstrap/bootstrap.min.css', array(), time());
    wp_enqueue_style('visits-main-css', plugin_dir_url(__FILE__) . 'assets/css/forms-front-styles.css', array(), time());

    // javascipt
    wp_enqueue_script('visits-main-js', plugin_dir_url(__FILE__) . 'assets/js/forms-validation.js', array('jquery'), time());
//	wp_enqueue_script('slim-js', plugin_dir_url(__FILE__) . 'assets/bootstrap/slim.min.js', array('jquery'), '1.0.0');
	wp_enqueue_script('popper-js', plugin_dir_url(__FILE__) . 'assets/bootstrap/popper.min.js', array('jquery'), '1.0.0');
	wp_enqueue_script('bootstrap-min-js', plugin_dir_url(__FILE__) . 'assets/bootstrap/bootstrap.min.js', array('jquery'), '1.0.0');
    wp_enqueue_script('qr-code-min-js', plugin_dir_url(__FILE__) . 'assets/js/qr_code_generator.js', array('jquery'), '1.0.0');
    wp_enqueue_script('crypto-js-minjs', plugin_dir_url(__FILE__) . 'assets/js/encryption/crypto-js.min.js', array('jquery'), '1.0.0');
    wp_enqueue_script('aes-min-js', plugin_dir_url(__FILE__) . 'assets/js/encryption/aes.min.js', array('jquery'), '1.0.0');

}
add_action('wp_enqueue_scripts', 'visits_front_enque_scripts');

// including backend styles
function visits_backend_enque_scripts()
{
    // styles
    $current_page = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

    if (strpos($current_page, '/wp-admin/admin.php?page=scan_visit') === 0
        || strpos($current_page, '/wp-admin/admin.php?page=bnosjounieh_functioality') === 0) {
        
        wp_enqueue_style('backendbootstrap-min-css', plugin_dir_url(__FILE__) . 'assets/bootstrap/bootstrap.min.css', array(), time());

    }
    wp_enqueue_style('visits-backend-css', plugin_dir_url(__FILE__) . 'assets/css/admin-styles.css', array(), time());

    // javascipt
    wp_enqueue_script('backend-main-js', plugin_dir_url(__FILE__) . 'assets/js/admin-js.js', array('jquery'), time());
    wp_enqueue_script('backendpopper-js', plugin_dir_url(__FILE__) . 'assets/bootstrap/popper.min.js', array('jquery'), '1.0.0');
    wp_enqueue_script('backendbootstrap-min-js', plugin_dir_url(__FILE__) . 'assets/bootstrap/bootstrap.min.js', array('jquery'), '1.0.0');
    wp_enqueue_script('backendqr-code-min-js', plugin_dir_url(__FILE__) . 'assets/js/qr_code_generator.js', array('jquery'), '1.0.0');

}
add_action('admin_enqueue_scripts', 'visits_backend_enque_scripts');