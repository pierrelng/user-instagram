<?php
add_action( 'wp_ajax_' . 'user_insta_filter', 'user_insta_filter' );

function user_insta_filter() {

	$id              = isset( $_GET['ID'] ) ? $_GET['ID'] : 0;
	$attachment      = get_post( $id );

    if( is_null( $attachment ) ) {
        die();
    }

	$file            = get_attached_file( $attachment->ID );
	$allowed_filters = array( 'sepia', 'greyscale', 'negate' );
	$filter          = isset( $_GET['filter'] ) && in_array( $_GET['filter'], $allowed_filters ) ? $_GET['filter'] : false;

    if ( ! wp_attachment_is_image( $id ) ) {
        die();
    }

	$image = wp_get_image_editor( $file, array( "methods" => array( 'sepia', 'greyscale' ) ) );
	$image = user_insta_filter_apply( $filter, $image );
	$image->resize( 1024, 0 );

	$image->stream();
	die();
}

/**
 * Apply the filters for the image
 *
 * @param $filter
 * @param $editor
 * @param array $args
 *
 * @return mixed
 */
function user_insta_filter_apply( $filter, $editor, $args = array() ) {
	switch ( $filter ) {
		case 'sepia' :
			$editor->sepia();
			break;
		case 'greyscale' :
			$editor->greyscale();
			break;
        case 'negate' :
            $editor->negate();
            break;
	}

	return $editor;
}

/**
 * Save an image and regenerate the thumbnails
 *
 * @param $editor
 * @param $destination
 * @param $attachment
 *
 * @return mixed
 */
function user_insta_save( $editor, $destination, $attachment ) {
	$editor->save( $destination );

	delete_post_meta( $attachment->ID, '_wp_attachment_metadata' );
	wp_maybe_generate_attachment_metadata( get_post( $attachment ) );

	return $editor;
}


/**
 * Add the new editors
 *
 * @param $editors
 *
 * @return mixed
 */
function User_Insta_add_image_filters_editors( $editors ) {
	require_once( USER_INSTA_DIR . '/inc/image_editor.php' );
	array_unshift( $editors, 'User_Insta_Imagick_Filters_Editor' );
	array_unshift( $editors, 'User_Insta_GD_Filters_Editor' );

	return $editors;
}

add_filter( 'wp_image_editors', 'User_Insta_add_image_filters_editors' );