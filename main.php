<?php
/*
 Template Name: Front Page Template
*/
?>
<?php get_header(); ?>

<div id="content">

	<main id="home" role="main">
		<div class="container">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			
				<article id="post-<?php the_ID(); ?>">
				<?php if ( is_front_page() ) { ?>
			
					<h2 class="entry-title hidden"><?php the_title(); ?></h2>
				  <?php } else { ?>
			
					<h1 class="entry-title hidden"><?php the_title(); ?></h1>
					<?php } ?>
			
							<?php the_content(); ?>

							<p><?php echo get_post_meta($post->ID, 'callout', true); ?></p>
							<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'boilerplate' ), 'after' => '' ) ); ?>
							<?php edit_post_link( __( 'Edit', 'boilerplate' ), '', '' ); ?>

				</article><!-- #post-## -->
			
			<?php endwhile; ?>
		</div>
	</main>

</div>

<?php get_footer(); ?>
