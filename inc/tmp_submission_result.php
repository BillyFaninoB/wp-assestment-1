<?php 
global $wpdb;
$table_name = $wpdb->prefix . 'testimonial';
$testi = $wpdb->get_results("SELECT * FROM ".$table_name." ");
?>

<div class="wrap">
    <h2>Form Submission</h2>
</div>
<?php foreach ($testi as $testimoni ) : ?>
    <div class="wrap">
        <span>name : <?php echo $testimoni->name; ?></span>
        <br>
        <span>email : <?php echo $testimoni->email; ?></span>
        <br>
        <span>testimonial : <?php echo $testimoni->testimonial; ?></span>
    </div>
    <p></p>
<?php endforeach; ?>   