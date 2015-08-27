<?php get_header(); ?>

			<div id="content" class="wrap">

				<div id="inner-content" class="group">

						<div id="main" class="group" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

								<header class="article-header">

									<h1 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
									<p class="byline vcard">
										<?php printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>', 'frankentheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
									</p>

								</header>

								<section class="entry-content group">
									<?php the_content(); ?>
								</section>

								<footer class="article-footer group">
									<p class="footer-comment-count">
										<?php comments_number( __( '<span>No</span> Comments', 'frankentheme' ), __( '<span>One</span> Comment', 'frankentheme' ), _n( '<span>%</span> Comments', '<span>%</span> Comments', get_comments_number(), 'frankentheme' ) );?>
									</p>


                 	<?php printf( __( '<p class="footer-category">Filed under: %1$s</p>', 'frankentheme' ), get_the_category_list(', ') ); ?>

                  <?php the_tags( '<p class="footer-tags tags"><span class="tags-title">' . __( 'Tags:', 'frankentheme' ) . '</span> ', ', ', '</p>' ); ?>


								</footer>

							</article>

							<?php endwhile; ?>

									<?php frankentheme_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry group">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'frankentheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'frankentheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the index.php template.', 'frankentheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>


						</div>

					<?php get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
