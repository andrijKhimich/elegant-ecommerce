<?php
/**
 * Index file for the Elegant theme.
 *
 * @category Page
 * @package  WordPress
 * @author   tag in file comment phpcs
 * @since    1.0.0
 * @license  tag in file comment phpcs
 * @link tag in file comment php
 */

get_header(); ?>
<section class="section hero text-section">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</section>
<?php
get_footer(); ?>