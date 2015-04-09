<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article>
				<div class="entry-content">
					<?php echo user_instagram_get_message(); ?>
					<form
                        enctype="multipart/form-data"
                        action="<?php echo admin_url( 'admin-post.php' ); ?>"
                        method="POST">

                        <label for="title" >Titre</label>
                        <input id="title" type="text" name="title" />

                        <label for="description" >Description</label>
                        <textarea id="description" name="description" ></textarea>

                        <input type="file" name="image" >

						<?php wp_nonce_field( 'user-instagram-publish' ); ?>
						<input type="hidden" name="action" value="user_insta_publish">
						<br/>
						<input type="submit" name="submit" value="Envoyer la photo">
					</form>
				</div>
			</article>
		</main>
		<!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer();
