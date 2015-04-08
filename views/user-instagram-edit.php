<?php get_header();
$edited_post = get_post( get_query_var( 'ID' ) );
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article>
				<div class="entry-content">
				
					<?php echo user_instagram_get_message(); ?>

					<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="POST">

						<label for="title">Title : </label>
						<input id="title" type="text" name="title" value=" <?php echo get_the_title( $edited_post); ?>"> <br><br>

						<label for="description">Description : </label>
						<textarea name="description" id="description" cols="10" rows="5" ><?php echo esc_textarea ( $edited_post -> post_content); ?></textarea> <br><br>
						
						<?php	
								$post_thumbnail_id = get_post_thumbnail_id( $edited_post -> ID);
								$arr_params = array( 'action' => 'user_insta_filter', 'ID' => $post_thumbnail_id, 'filter' => isset ($_GET['filter'] ) ? $_GET['filter'] : '' );
						?>
	

						<img src="<?php echo add_query_arg( $arr_params, admin_url( 'admin-ajax.php' ) ); ?>" alt=""> <br><br>
						
						
						<input type="hidden" name="action" value="user_insta_edit">
						<input type="hidden" name="ID" value="<?php echo esc_attr( $edited_post->ID ); ?>">
						<input type="hidden" name="filter"
						       value="<?php echo esc_attr( isset( $_GET['filter'] ) ? $_GET['filter'] : '' ); ?>">

						<input type="hidden" name="photo"
						       value="<?php echo add_query_arg( $arr_params, admin_url( 'admin-ajax.php' ) ); ?>">

						<?php wp_nonce_field( 'user-instagram-edit' ); ?>

						<a href="&?filter=sepia">Sépia</a> <br><br>
						<a href="&?filter=greyscale">Greyscale</a> <br><br>
						<a href="&?filter">Reset</a> <br><br>
						
						
						<input type="submit" name="submit" value="Publier">
					</form>

				</div>
			</article>
		</main>
		<!-- #main -->
	</div><!-- #primary -->
<?php get_footer();