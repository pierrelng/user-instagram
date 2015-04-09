<?php get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article>
				<div class="entry-content">
					<h1> Dashboard utilisateur </h1>
					<p>-----------------------------------------------------------</p>
						
						<h2> Mes articles en attente </h2>

					<p>-----------------------------------------------------------</p>
						<?php	
							
							$drafts = user_instagram_get_draft_contents();
							//var_dump($drafts);

							// The Loop
							if ( $drafts->have_posts() ) {
								while ( $drafts->have_posts() ) {
									
									$drafts->the_post();
									$post_id = get_the_ID();
									
									echo '<article>';
									echo '<h4>' . get_the_title() . '</h4>';
									echo '<a href="' . user_instagram_get_content_edit_url($post_id) . '"> -> Editer ce brouillon</a>';
									echo '<p>' . get_the_content() . '</p>';
									if ( has_post_thumbnail() ) {
										the_post_thumbnail();
									}
									echo '</article>';
									echo '<p>___</p>';
								}
							}
							else {
								echo '<p>Aucun brouillon pour le moment</p>';
							}

						?>

					<p>--------------------------------------------------</p>

						<h2> Mes articles publiés </h2>

					<p>--------------------------------------------------</p>
						<?php	
							
							$publishedposts = user_instagram_get_contents();
							// var_dump($publishedposts);

							// The Loop
							if ( $publishedposts->have_posts() ) {
								while ( $publishedposts->have_posts() ) {
									
									$publishedposts->the_post();
									$post_id = get_the_ID();
									
									echo '<article>';
									echo '<h4>' . get_the_title() . '</h4>';
									echo '<a href="' . user_instagram_get_content_edit_url($post_id) . '"> -> Editer cet article</a>';
									echo '<p>' . get_the_content() . '</p>';
									if ( has_post_thumbnail() ) {
										the_post_thumbnail();
									}
									echo '</article>';
									echo '<p>___</p>';
								}
							}
							else {
								echo '<p>Aucun article pour le moment</p>';
							}

						?>
					

				</div>
			</article>
		</main>
		<!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer();
