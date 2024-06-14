<?php
/**
 *
 * Single page for the Elegant theme
 *
 * @category   Components
 * @package    WordPress
 * @since      1.0.0
 */

get_header();
$banner = get_field( 'case-poster_image' ) ?>

<section class="section single-banner" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
	<div class="container">
		<?php
		$case_id = get_the_ID();
		$terms   = get_the_terms( $case_id, 'case_category' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term_name ) {
				if ( 'case_category' === $term_name->taxonomy ) {
					?>
					<p class="single__category"> <span>*</span> <?php echo esc_html( $term_name->name ); ?></p>
					<?php
				}
			}
		}
		?>
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<section class="section single-video">
	<div class="video">
		<a href="<?php echo esc_url( the_field( 'case-vimeo_video_link' ) ); ?>" class="video-item video-toggle follow-wrap">
			<?php
			if ( $banner ) {
				?>
				<img src="<?php echo esc_attr( $banner['url'] ); ?>" alt="<?php echo esc_attr( $banner['alt'] ); ?>">
				<?php
			}
			?>
		</a>
		<div class="video-btn js-follower"></div>
		<div class="video-btn_mob"></div>
	</div>
</section>
<?php
$images = get_field( 'case-gallery' );
if ( $images ) {
	?>
	<section class="section single-gallery">
		<div class="splide gallery">
			<div class="splide__track">
				<div class="splide__list gallery__list">
					<?php
					foreach ( $images as $image ) {
						?>
						<a href="<?php echo esc_url( $image['url'] ); ?>" class="splide__slide gallery__item">
							<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
						</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

<?php get_footer(); ?>