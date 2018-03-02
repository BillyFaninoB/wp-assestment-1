<?php
/*
Plugin Name: SS Contact Form plugin
Plugin URI: localhost
Description: WP assesment test 1 plugin
Version: 1.0
Author: Billy Fanino
Author URI: -
*/


function install_db() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'testimonial';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
         id INT NOT NULL AUTO_INCREMENT , 
         nama VARCHAR(50) NULL , 
         email VARCHAR(50) NULL , 
         testimonial VARCHAR(255) NULL , 
         submitted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
         PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'install_db' );

function contact_form_html() {

    if ( isset( $_POST['form-submitted'] ) ) {
        echo '<div class="thankyou-msg">';
        echo "<p>Form telah dikirimkan</p>";
        echo "<p>Terimakasih</p>";
        echo '</div>';
    }    


    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    echo 'Your Name (required) <br />';
    echo '<input required type="text" name="form-name" pattern="[a-zA-Z0-9 ]+" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Email (required) <br />';
    echo '<input required type="email" name="form-email" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Message (required) <br />';
    echo '<textarea required rows="10" cols="35" name="form-message"></textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="form-submitted" value="Send"/></p>';
    echo '</form>';
}

function save() {
    global $wpdb;
    // if the submit button is clicked, send the email
    if ( isset( $_POST['form-submitted'] ) ) {

        // sanitize form values
        $name = sanitize_text_field( $_POST["form-name"] );
        $email = sanitize_email( $_POST["form-email"] );
        $message = esc_textarea( $_POST["form-message"] );

        $table = $wpdb->prefix . 'testimonial';
        $wpdb->insert( 
        $table, 
            array( 
            'name' => $name, 
            'email' => $email,
            'testimonial' => $message  
            ) 
        );

        $message = '<div class="wrap">';
        $message .= "name : ".$name;
        $message .= '<br>';
        $message .= "email : ".$email;
        $message .= '<br>';
        $message .= "testimonial :".$message;
        $message .= '</div>';

        wp_mail( get_bloginfo('admin_email'), 'Contact Form Submission', $message, '', '');
    }
}

function contactform_shortcode() {
    ob_start();
    save();
    contact_form_html();

    return ob_get_clean();
}

add_shortcode( 'contact_form', 'contactform_shortcode' );

add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
    add_menu_page( 'Admin menu', 'Admin Menu', 'manage_options', 'myplugin/myplugin-admin-page.php', 'myplguin_admin_page', 'dashicons-tickets', 6  );
}

function myplguin_admin_page(){
    ?>
    <div class="wrap">
        <h2>Welcome To Admin Plugin</h2>
    </div>
    <?php 
        global $wpdb;
        $table_name = $wpdb->prefix . 'testimonial';
        if( isset( $_POST['delete'] ) ){
            $id = $_POST['id'];
            $wpdb->delete( $table_name, array( 'id' => $id ) );
        }
        $testi = $wpdb->get_results("SELECT * FROM ".$table_name." ");
        foreach ($testi as $testimoni ) {
            echo '<div class="wrap">';
            echo "name : ".$testimoni->name;
            echo '<br>';
            echo "email : ".$testimoni->email;
            echo '<br>';
            echo "testimonial :".$testimoni->testimonial;
            echo '</div>';
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="id" value="'.$testimoni->id.'"/>';
            echo '<input type="submit" name="delete" value="Delete"/>';
            echo '</form>';
        }
     ?>

    <?php
}

function contactform_submission() {
    ?>
    <div class="wrap">
        <h2>Form Submission</h2>
    </div>
    <?php 
        global $wpdb;
        $table_name = $wpdb->prefix . 'testimonial';
        $testi = $wpdb->get_results("SELECT * FROM ".$table_name." ");
        foreach ($testi as $testimoni ) {
            echo '<div class="wrap">';
            echo "name : ".$testimoni->name;
            echo '<br>';
            echo "email : ".$testimoni->email;
            echo '<br>';
            echo "testimonial :".$testimoni->testimonial;
            echo '</div>';
            echo '<p>';
        }
     ?>
     <?php
}

add_shortcode( 'contact_form_result', 'contactform_submission' );

?>