<?php
/**
 * Get the published contents for the current user
 *
 * @param array $args
 *
 * @return WP_Query
 */
function user_instagram_get_contents( $args = array() ) {
	$defaults = array(
		'author'      => wp_get_current_user()->ID,
		'nopaging'    => true,
		'post_status' => 'publish'
	);

	return new WP_Query( wp_parse_args( $args, $defaults ) );
}

/**
 * Get the draft contents for the current user
 *
 * @param array $args
 *
 * @return WP_Query
 */
function user_instagram_get_draft_contents( $args = array() ) {
	$defaults = array(
		'author'      => wp_get_current_user()->ID,
		'nopaging'    => true,
		'post_status' => 'draft'
	);

	return new WP_Query( wp_parse_args( $args, $defaults ) );
}

/**
 * Return the content edit url for the given id
 *
 * @param $content_id
 *
 * @return string|void
 */
function user_instagram_get_content_edit_url( $content_id ) {
	return home_url( 'editer/' . $content_id );
}

/**
 * Get the message for the form if needed
 *
 * @return string
 */
function user_instagram_get_message() {
	$messages = array(
		'publication' => array(
            0 => 'Erreur de sécu',
            1 => "Veuillez entrer un titre",
            2 => 'Entrez une image',
            3 => 'Erreur lors de upload image',
            4 => 'Erreur lors de upload du post'
		),
		'edition' => array(
            3 => 'Mise à jour effectuée !',
		)
	);
	$code = isset( $_GET['code'] ) ? absint( $_GET['code'] ) : -1 ;
	$message = isset( $messages[get_query_var( 'user_insta_page' )] ) ? $messages[get_query_var( 'user_insta_page' )] : '' ;
	$status = isset( $_GET['status'] ) ? $_GET['status'] : 'success' ;

	if( empty( $message ) || !isset( $message[$code] ) ) {
		return '';
	}

	return sprintf( '<span class="%1$s" >%2$s</span>', $status, $message[$code] );
}