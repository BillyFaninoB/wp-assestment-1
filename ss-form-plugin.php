<?php
/*
Plugin Name: SS Contact Form plugin
Plugin URI: localhost
Description: WP assesment test 1 plugin
Version: 1.0
Author: Billy Fanino
Author URI: -
*/

class Testimonial{


    /**
    * Create Table for Testimonial
    *
    */
    
    public static function install_db() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'testimonial';
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
             id INT NOT NULL AUTO_INCREMENT , 
             name VARCHAR(50) NULL , 
             email VARCHAR(50) NULL , 
             testimonial VARCHAR(255) NULL , 
             submitted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
             PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta( $sql );
    }

    /**
    * Load Contact Form Template
    *
    */

    public static function contact_form() {
        include 'inc/tmp_contact_form.php';
    }

    public static function contactform_shortcode() {
        ob_start();
        Testimonial::contact_form();
        return ob_get_clean();
    }


    /**
    * Create admin menu
    *
    */

    public static function my_admin_menu() {
        add_menu_page( 'Admin menu', 'Admin Menu', 'manage_options', 'testimonial-admin-page', ['Testimonial' , 'myplguin_admin_page'], 'dashicons-tickets', 6  );
    }

    /**
    * Load admin menu template page
    *
    */

    public static function myplguin_admin_page(){
        include 'inc/tmp_admin_page.php';
    }

    /**
    * Load submission result page
    *
    */

    public static function contactform_submission() {
        include 'inc/tmp_submission_result.php';
    }

    
}

register_activation_hook( __FILE__, ['Testimonial' , 'install_db'] );
add_shortcode( 'contact_form', ['Testimonial' , 'contactform_shortcode'] );
add_action( 'admin_menu', ['Testimonial' , 'my_admin_menu'] );
add_shortcode( 'contact_form_result', ['Testimonial' , 'contactform_submission'] );
?>