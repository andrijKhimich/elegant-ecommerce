<?php
/**
 * Main Header file for the Elegant theme.
 *
 * @category   Components
 * @package    WordPress
 * @since      1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin-top: 0 !important;">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="description" content="Rech website.">
	<meta name="theme-color" content="#0B0B0B">
	<meta name="msapplication-TileColor" content="#0B0B0B">
	<meta name="msapplication-navbutton-color" content="#0B0B0B">
	<meta name="apple-mobile-web-app-status-bar-style" content="#0B0B0B">
	<?php wp_head(); ?>
</head>

<body>
	<div <?php body_class(); ?>>
		<div class="wrapper">
			<header class="header js-header">
				<?php
				$header_cta = get_field( 'header_cta', 'options' );
				if ( $header_cta ) :
					?>
					<div class="header-cta js-header-cta">
						<div class="container">
							<div class="header-cta__row">
								<?php
								$icon = $header_cta['icon'];
								if ( ! empty( $icon ) ) :
									?>
									<img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" />
								<?php endif; ?>
								<p><?php echo esc_html( $header_cta['text'] ); ?></p>
								<?php
								$header_link = $header_cta['link'];
								if ( $header_link ) :
									$link_url    = $header_link['url'];
									$link_title  = $header_link['title'];
									$link_target = $header_link['target'] ? $header_link['target'] : '_self';
									?>
									<a class="link link_sm link_blue link__header" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?>
										<svg class="icon icon-arrow">
											<use xlink:href="<?php echo esc_url( get_theme_file_uri( 'build/images/sprite/sprite.svg#icon-arrow-right' ) ); ?>"></use>
										</svg>
									</a>
								<?php endif; ?>
							</div>
						</div>
						<button class="close close__header js-header-cta-btn">
							<svg class="icon icon-close">
								<use xlink:href="<?php echo esc_url( get_theme_file_uri( 'build/images/sprite/sprite.svg#close' ) ); ?>"></use>
							</svg>
						</button>
					</div>
				<?php endif ?>
			</header>

			<main class='main-wrapper js-wrapper'>