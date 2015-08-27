<?php get_header(); ?>

			<div id="content">

				<div class="container">

						<main role="main">

							<?php if (is_category()) { ?>
								<h1 class="archive-title">
									<span><?php _e( 'Posts Categorized:', 'frankentheme' ); ?></span> <?php single_cat_title(); ?>
								</h1>

							<?php } elseif (is_tag()) { ?>
								<h1 class="archive-title">
									<span><?php _e( 'Posts Tagged:', 'frankentheme' ); ?></span> <?php single_tag_title(); ?>
								</h1>

							<?php } elseif (is_author()) {
								global $post;
								$author_id = $post->post_author;
							?>
								<h1 class="archive-title">

									<span><?php _e( 'Posts By:', 'frankentheme' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>

								</h1>
							<?php } elseif (is_day()) { ?>
								<h1 class="archive-title">
									<span><?php _e( 'Daily Archives:', 'frankentheme' ); ?></span> <?php the_time('l, F j, Y'); ?>
								</h1>

							<?php } elseif (is_month()) { ?>
									<h1 class="archive-title">
										<span><?php _e( 'Monthly Archives:', 'frankentheme' ); ?></span> <?php the_time('F Y'); ?>
									</h1>

							<?php } elseif (is_year()) { ?>
									<h1 class="archive-title">
										<span><?php _e( 'Yearly Archives:', 'frankentheme' ); ?></span> <?php the_time('Y'); ?>
									</h1>
							<?php } ?>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" role="article">

								<header class="article-header">

									<h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<p class="byline vcard"><?php
										printf(__( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'frankentheme' ), get_the_time('Y-m-j'), get_the_time(__( 'F jS, Y', 'frankentheme' )), get_author_posts_url( get_the_author_meta( 'ID' ) ), get_the_category_list(', '));
									?></p>

								</header>

								<section class="entry-content group">

									<?php the_post_thumbnail( 'frankentheme-thumb-300' ); ?>

									<?php the_excerpt(); ?>

								</section>

								<footer class="article-footer">

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
												<p><?php _e( 'This is the error message in the archive.php template.', 'frankentheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>

					<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
