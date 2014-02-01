<?php 
add_action( 'wp_ajax_my_ajax', 'my_ajax' );

function my_ajax() {
	die( "Hello World" );
}

 ?>