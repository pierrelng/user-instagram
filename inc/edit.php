<?php
add_action( 'admin_post_' . 'user_insta_edit', 'user_insta_edit_post' );

function user_insta_edit_post() {
	// Code for publication

	$title = $_POST['title'];
	$description = $_POST['description'];
	$id = $_POST['ID'];
	$filter = $_POST['filter'];
		// var_dump($filter);

	$post = get_post( get_post_thumbnail_id( $id ) );
		// var_dump($post);
	$image_url = get_attached_file( $post->ID );
		// var_dump($image_url);

	$image = wp_get_image_editor( $image_url, array( "methods" => array( 'sepia', 'greyscale' ) ) );
		// https://codex.wordpress.org/Function_Reference/wp_get_image_editor
	
	// Apply the filters for the image
	$image_edited = user_insta_filter_apply( $filter, $image );

	// Save image and regenerate the thumbnail
	user_insta_save( $image_edited, $image_url, $post );

	// Update post
	  $my_post = array(
	      'ID'          => $id,
		  'post_status' => 'publish',
		  'post_title'	=> $title,
		  'post_content'=> $description
	  );

	// Update the post into the database
	  wp_update_post( $my_post );
		// https://codex.wordpress.org/Function_Reference/wp_update_post

	// die();

// -----------------------------------------------------------------
// --------- Premier essai -----------------------------------------
// -----------------------------------------------------------------

// 	$post_informations = array(
// 		'post_title' => $_POST['title'],
// 		'post_content' => $_POST['description'],
// 		'post_filter' => $_POST['filter'],
// 		'post_type' => 'post',
// 		'post_status' => 'publish'
// 		);

// 	$post_id = wp_insert_post( $post_informations );
	
// 	// Add Featured Image to Post
// 	$image_url  = $image_edited; // Define the image URL here
// 	// $image_url  = 'http://i.imgur.com/Erysvda.jpg'; // Define the image URL here
// 	$upload_dir = wp_upload_dir(); // Set upload folder
// 	$image_data = file_get_contents($image_url); // Get image data
// 	$filename   = basename($image_url); // Create image file name

// 	// Check folder permission and define file location
// 	if( wp_mkdir_p( $upload_dir['path'] ) ) {
// 	    $file = $upload_dir['path'] . '/' . $filename;
// 	} else {
// 	    $file = $upload_dir['basedir'] . '/' . $filename;
// 	}

// 	// Create the image file on the server
// 	file_put_contents( $file, $image_data );

// 	// Check image file type
// 	$wp_filetype = wp_check_filetype( $filename, null );

// 	// Set attachment data
// 	$attachment = array(
// 	    'post_mime_type' => $wp_filetype['type'],
// 	    'post_title'     => sanitize_file_name( $filename ),
// 	    'post_content'   => '',
// 	    'post_status'    => 'inherit'
// 	);

// 	// Create the attachment
// 	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

// 	// Include image.php
// 	require_once(ABSPATH . 'wp-admin/includes/image.php');

// 	// Define attachment metadata
// 	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

// 	// Assign metadata to attachment
// 	wp_update_attachment_metadata( $attach_id, $attach_data );

// 	// And finally assign featured image to post
// 	set_post_thumbnail( $post_id, $attach_id );
	
	

// 	// var_dump($post_informations);die;

// 	// $id = $_GET['id'];
// 	// $post = get_post ($id);
// 	// $post = post_author;
// 	// $user = wp_get_currrent_user();

// 	// if ($user != $post_author) {
// 	// 	# code...
// 	// }
	

// 	// current_user_can("edit_post", $id);

// 	if ( $post_id ) {
// 	    wp_redirect( home_url() );
// 	    exit;
// 	 }
// 	// wp_safe_redirect( add_query_arg( array( 'status' => 'success', 'code' => 3 ), home_url( 'editer/' . $ID ) ) );
// 	die();
// }

	wp_safe_redirect( add_query_arg( array( 'status' => 'success', 'code' => 3 ), home_url( 'editer/' . $id ) ) );
	die();

}

?>