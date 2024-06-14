<?php
/**
 * Template name: Front page
 * Home page for the Rech theme
 *
 * @category   Components
 * @package    WordPress
 * @since      1.0.0
 */

get_header(); ?>
<section class="section hero">
	<div class="hero__title">
		<?php the_field( 'hero_title' ); ?>
	</div>
</section>
<section class="section work">
	<?php
	$taxonomy_name       = 'case_category';
	$terms               = get_terms( $taxonomy_name );
	$current_category_id = get_queried_object_id();
	if ( $terms ) {
		foreach ( $terms as $term_name ) {
			?>
			<a href="<?php echo esc_url( get_term_link( $term_name ) ); ?>" class="work-card">
				<div class="work-card__title title-2 js-scroll slide-bottom in-view-detect">
					<svg width="42" height="32" viewBox="0 0 42 32" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.999999 15.4407L37.8706 15.4407L24.5759 2.14604L25.514 1.20798L40.41 16.104L25.514 31L24.5759 30.0619L37.8706 16.7673L0.999999 16.7673L0.999999 15.4407Z" />
					</svg>
					<?php echo esc_html( $term_name->name ); ?>
				</div>
				<?php
				$args  = array(
					'post_type'      => 'cases',
					'posts_per_page' => 1,
					'tax_query'      => array(
						array(
							'taxonomy' => $taxonomy_name,
							'field'    => 'id',
							'terms'    => $term_name->term_id,
						),
					),
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						?>
						<div class="work-card__media js-scroll slide-bottom in-view-detect">
							<?php
							$poster = get_field( 'case-poster_image' );
							if ( $poster ) {
								?>
								<img src="<?php echo esc_url( $poster['url'] ); ?>" alt="<?php echo esc_attr( $poster['alt'] ); ?>" data-parallax>
							<?php } ?>
						</div>
						<?php
					}
				}
				wp_reset_postdata();
				?>
			</a>
			<?php
		}
	}
	?>
</section>
<section class="section awards">
	<div class="container">
		<div class="awards__title"><?php the_field( 'awards_title', 'options' ); ?></div>
		<?php
		$awards_gallery = get_field( 'awards_gallery', 'option' );
		if ( $awards_gallery ) {
			?>
			<ul class="awards-list">
				<?php foreach ( $awards_gallery as $image ) : ?>
					<li class="awards-list__item js-scroll slide-top in-view-detect">
						<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
					</li>
				<?php endforeach; ?>
			</ul>
		<?php } ?>
	</div>
</section>
<section class="section clients">
	<div class="container">
		<div class="clients__title clients__title_hidden"><?php the_field( 'clients_title' ); ?></div>
		<?php
		$awards_gallery = get_field( 'clients_gallery' );
		if ( $awards_gallery ) {
			?>
			<ul class="clients-list">
				<?php
				$total_items = count( $awards_gallery );
				foreach ( $awards_gallery as $key => $image ) {
					?>
					<li class="clients-list__item js-scroll slide-top in-view-detect">
						<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
					</li>
					<?php
					if ( 4 < $total_items && 3 === $key ) {
						?>
							<li class="clients-list__item">
								<div class="clients__title"><?php the_field( 'clients_title' ); ?></div>
							</li>
							<?php
					}
				}
				?>
			</ul>
		<?php } ?>
	</div>
</section>
<section class="section mission js-scroll slide-top in-view-detect">
	<div class="mission__row">
		<div class="mission__col">
			<div class="mission__sidebar">
				<div class="circle">
					<svg class="circle__arrow" width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M1.18945 8.64377L21.7719 8.64376L14.3503 1.50379L14.874 1L23.1895 9L14.874 17L14.3503 16.4962L21.7719 9.35623L1.18945 9.35624L1.18945 8.64377Z" fill="#DA7B33" stroke="#DA7B33" />
					</svg>
					<svg class="circle__text" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="300px" viewBox="0 0 300 300" enable-background="new 0 0 300 300" xml:space="preserve">
						<defs>
							<path id="circlePath" d=" M 150, 150 m -60, 0 a 60,60 0 0,1 120,0 a 60,60 0 0,1 -120,0 " />
						</defs>
						<circle cx="300" cy="200" r="220" fill="none" />
						<use xlink:href="#circlePath" fill="none" />
						<text fill="#000">
							<textPath xlink:href="#circlePath"><?php the_field( 'mission_animated_text' ); ?></textPath>
						</text>
					</svg>
				</div>
				<?php the_field( 'mission_sidebar_text' ); ?>
			</div>
		</div>
		<div class="mission__col">
			<div class="mission__content">
				<?php the_field( 'mission_content' ); ?>
			</div>
		</div>
	</div>
</section>
<section class="section vision js-scroll slide-top in-view-detect">
	<div class="vision__row">
		<div class="vision__col">
			<div class="vision__sidebar" data-parallax>
				<?php
				$image = get_field( 'vision_image' );
				if ( ! empty( $image ) ) {
					?>
					<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
				<?php } ?>
				<div class="vision__title">
					<p><?php the_field( 'vision_title' ); ?>
					</p>
					<svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M1.18945 8.64377L21.7719 8.64376L14.3503 1.50379L14.874 1L23.1895 9L14.874 17L14.3503 16.4962L21.7719 9.35623L1.18945 9.35624L1.18945 8.64377Z" fill="#000" stroke="#000" />
					</svg>
				</div>
			</div>
		</div>
		<div class="vision__col">
			<div class="vision__content">
				<?php the_field( 'vision_content' ); ?>
				<?php
				$vision_text = get_field( 'vision_footer_text' );
				if ( $vision_text ) {
					?>
					<div class="vision__footer">
						<p><?php the_field( 'vision_footer_text' ); ?></p>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<?php
get_footer(); ?>