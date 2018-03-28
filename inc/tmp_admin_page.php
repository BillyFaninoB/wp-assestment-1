<?php 
global $wpdb;
$table_name = $wpdb->prefix . 'testimonial';
if( isset( $_POST['delete'] ) ){
    $id = $_POST['id'];
    $wpdb->delete( $table_name, array( 'id' => $id ) );
}
$testi = $wpdb->get_results("SELECT * FROM ".$table_name." ");
?>
<div class="wrap">
    <h2>Welcome To Admin Plugin</h2>
</div>

<?php foreach ($testi as $testimoni )  : ?>
    <div class="wrap">
    	<span>name : <?php echo $testimoni->name; ?></span>
    <br>
    	<span>email : <?php echo $testimoni->email; ?></span>
    <br>
    	<span>testimonial : <?php echo $testimoni->testimonial; ?></span>
    </div>
    <form action="" method="post">
        <input type="hidden" name="id" value="'.$testimoni->id.'"/>
        <input type="submit" name="delete" value="Delete"/>
    </form>
<?php endforeach; ?>