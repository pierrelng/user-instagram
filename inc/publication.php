<?php
add_action( 'admin_post_' . 'user_insta_publish', 'user_insta_publish_post' );

function user_insta_publish_post() {

	// Code for publication
    $title              = isset( $_POST['title'] ) ? $_POST['title'] : '';
    $description              = isset( $_POST['description'] ) ? $_POST['description'] : '';
    $nonce = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';

    // var_dump($_FILES);die;

    if( !wp_verify_nonce( $nonce, 'user-instagram-publish' ) ) {
        wp_safe_redirect(
            add_query_arg(
                array(
                    "code" => 0,
                    "status" => "error" 
                ),
                home_url( '/publier' )
            )
        );
        die();
    }

    //faire la verification pour le title et pour la description

    if( empty($_FILES) || $_FILES['image']['error'] !== 0 ) {
        wp_safe_redirect(
            add_query_arg(
                array(
                    "code" => 2,
                    "status" => "error"
                ),
                home_url( '/publier' )
            )
        );
        die();
    }

    // WP_Error ou ID attachment
    /*
     * Ici utilisation du $_FILES['image'] pour uploader l'image dans WP
     */
   
   $attachment = user_insta_upload_file ($_FILES['image']);
   
    if( is_wp_error( $attachment ) ) {
         wp_safe_redirect(
            add_query_arg(
                array(
                    "code" => 3,
                    "status" => "error"
                ),
                home_url( '/publier' )
            )
        );
        die();
    }

    /*
    * Ici utilisation de wp_insert_post pour insérer l'article dans le contenu
     * Sans oublier de sanitize le contenu
    */

    $my_post = array(
        'post_title' => sanitize_text_field($title),
        'post_content' => wp_kses($description)
    );

    $inserted_post = wp_insert_post($my_post, $wp_error);

    //tags_input il faut aussi les rajouter dans le formulaire


    if( is_wp_error( $inserted_post ) ) {
        wp_safe_redirect(
            add_query_arg(
                array(
                    "code" => 4,
                    "status" => "error"
                ),
                home_url( '/publier' )
            )
        );
        die();

    }

    // Ajout image à la une
    set_post_thumbnail( $inserted_post, $attachment );

	wp_safe_redirect( home_url( 'editer/' . $inserted_post ) );
	die();
}

/**
 * Handle an upload on the sideload
 *
 * @param null $file
 * @param int $post_id
 * @param string $filename
 *
 * @return int|WP_Error
 * @author Nicolas Juen
 */
function user_insta_upload_file( $file = null, $post_id = 0, $filename = '' ) {
	// Include libs
	if ( ! function_exists( 'media_handle_sideload' ) ) {
		include( ABSPATH . '/wp-admin/includes/file.php' );
		include( ABSPATH . '/wp-admin/includes/image.php' );
		include( ABSPATH . '/wp-admin/includes/media.php' );
	}

	// Insert the attachment
	$att_id = media_handle_sideload( $file, $post_id, '', array(
		'post_title'   => $filename,
		'post_content' => '',
		'post_excerpt' => ''
	) );

	// check if wp_error
	if ( is_wp_error( $att_id ) ) {
		return new WP_Error( 'broken-insert-attachment', "Erreur lors de l\'insertion dans WordPress" );
	}

	//return attachment id
	return $att_id;
}