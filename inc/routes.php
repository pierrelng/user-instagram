<?php

add_action( 'init', 'user_instagram_add_routes' );
function user_instagram_add_routes() {
	hm_add_rewrite_rule(
		array(
			'regex'          => '^publier/?',
			'query'          => 'user_insta_page=publication',
			'template'       => user_instagram_get_template( 'user-instagram-publication' ),
			'title_callback' => function ( $title, $seperator ) {
				return 'Publier une photo';
			},
			'access_rule'    => 'logged_in_only'
		)
	);

	hm_add_rewrite_rule(
		array(
			'regex'            => '^editer/([0-9]+)?',
			'query'            => 'user_insta_page=edition&ID=$matches[1]',
			'template'         => user_instagram_get_template( 'user-instagram-edit' ),
			'title_callback'   => function ( $title, $seperator ) {
				return 'Editer une photo';
			},
			'access_rule'      => 'logged_in_only',
			'request_callback' => function ( WP $wp ) {
				$post = get_post( $wp->query_vars['ID'] );

				if ( (int) $post->post_author !== (int) wp_get_current_user()->ID ) {
					wp_redirect( home_url( '/' ) );
					die();
				}
			}
		)
	);

	hm_add_rewrite_rule(
		array(
			'regex'          => '^dashboard?',
			'query'          => 'user_insta_page=dashboard',
			'template'       => user_instagram_get_template( 'user-instagram-dashboard' ),
			'title_callback' => function ( $title, $seperator ) {
				return 'Mon dashboard';
			},
			'access_rule'    => 'logged_in_only'
		)
	);
}

function user_instagram_get_template( $tpl = '' ) {
	if ( empty( $tpl ) ) {
		return false;
	}

	// Locate from the theme
	$located = locate_template( array( $tpl . '.php' ), false, false );
	if ( ! empty( $located ) ) {
		return $located;
	}

	// Locate on the files
	if ( is_file( USER_INSTA_DIR . 'views/' . $tpl . '.php' ) ) {// Use builtin template
		return ( USER_INSTA_DIR . 'views/' . $tpl . '.php' );
	}

	return false;
}
