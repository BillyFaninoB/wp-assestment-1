<?php

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

?>
<?php if ( isset( $_POST['form-submitted'] ) ) : ?>
        <div class="thankyou-msg">
            <p>Form telah dikirimkan</p>
            <p>Terimakasih</p>
        </div>
<?php endif; ?>

<form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
    <p>
        Your Name (required) <br />
        <input required type="text" name="form-name" pattern="[a-zA-Z0-9 ]+" size="40" />
    </p>
    <p>
        Your Email (required) <br />
        <input required type="email" name="form-email" size="40" />
    </p>
    <p>
        Your Message (required) <br />
        <textarea required rows="10" cols="35" name="form-message"></textarea>
    </p>
    <p><input type="submit" name="form-submitted" value="Send"/></p>
</form>