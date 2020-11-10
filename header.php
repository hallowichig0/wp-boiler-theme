<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bootstrap4
 */
$get_template_directory = get_template_directory();

// Default Logo Variables
$custom_logo_id = get_theme_mod( 'custom_logo' );
$header_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

// Kirki Variables
$header_bg = get_theme_mod('header_background_field_setting');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>
		<?php
		bloginfo('name'); 
		wp_title('|', true, 'left'); 
		?>
	</title>

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	
	<!-- Loading Animation -->
	<div class="pre-loader">
		<div class="loader"></div>
		<p>Please wait while loading...</p>
	</div>

	<!-- Navigation -->
	<header class="nav-header">
		<nav class="navbar navbar-dark nav-top" style="background-color: <?php echo !empty($header_bg) ? $header_bg : '#ffffff'; ?>">
			<div class="container px-sm-0">
				<div class="navbar-nav">
					<?php if(has_custom_logo()): ?>
						<a href="<?php echo esc_url( home_url( '/' )); ?>">
							<img src="<?php echo $header_logo[0]; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" height="40px" width="100px">
						</a>
					<?php
					else:
					$header_logoTitleColor = get_theme_mod('header_logoColorTitle_field_setting');
					$header_logoSubtitleColor = get_theme_mod('header_logoColorSubTitle_field_setting');
					?>
						<a class="navbar-brand col-md-6 px-0" style="color:<?php echo !empty($header_logoTitleColor) ? $header_logoTitleColor : '#000000'; ?>" class="navbar-brand" href="<?php echo esc_url( home_url( '/' )); ?>">
							<h3 class="font-weight-bold" style="margin-bottom:0.3rem;"><?php esc_url(bloginfo('name')); ?></h3>
							<?php if(get_bloginfo('description')): ?>
								<h6 class="mb-0" style="color:<?php echo !empty($header_logoSubtitleColor) ? $header_logoSubtitleColor : '#000000'; ?>">
									<?php echo get_bloginfo('description'); ?>
								</h6>
							<?php endif; ?>
						</a>
					<?php endif; ?>
				</div>

				<div class="navbar-nav ml-sm-auto social-media">
					<?php
					// header contact
					$header_contactText = get_theme_mod('header_contactText_field_setting');
					$header_contactTextColor = get_theme_mod('header_contactColor_field_setting');
					if(!empty($header_contactText) && isset($header_contactText)):
					?>
						<div class="navbar-brand col-md-6 px-0" style="padding-top:10px">
							<a style="color:<?php echo !empty($header_contactTextColor) ? $header_contactTextColor : '#000000'; ?>" href="tel:<?php echo $header_contactText; ?>">
							<h5 class="mb-0">
								<i class="fa fa-phone" aria-hidden="true" style="font-weight: 900"></i>
								<?php echo $header_contactText; ?>
							</h5>
							</a>
						</div>
					<?php endif; ?>
					<?php
					// social media
					$media_repeater = get_theme_mod('header_social_media_repeater');
					if(!empty($media_repeater) && isset($media_repeater)):
					?>
						<div class="navbar-brand col-md-6 px-0 py-0 social-menu">
							<?php
							foreach($media_repeater as $social_media):
								$select_media = $social_media['header_social_media_select'];
								$link_media = $social_media['header_social_media_link'];
								$social_classes = '';
								if($select_media == 'fb'){
									$social_classes = 'fa-facebook social-icon-fb';
								}
								elseif($select_media == 'instagram'){
									$social_classes = 'fa-instagram social-icon-instagram';
								}
								elseif($select_media == 'twitter'){
									$social_classes = 'fa-twitter ocial-icon-twitter';
								}
								elseif($select_media == 'pinterest'){
									$social_classes = 'fa-pinterest social-icon-pinterest';
								}
								elseif($select_media == 'linkedin'){
									$social_classes = 'fa-linkedin-square social-icon-linkedin';
								}
							?>
								<a href="<?php echo $link_media; ?>" target="_blank"> <i class="social-icon fa <?php echo $social_classes; ?>" aria-hidden="true"></i></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</nav>

		<nav class="navbar navbar-expand-md nav-bottom" style="background-color: #343a40">
			<div class="container">
				<button class="navbar-toggler collapsed navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar top-bar"></span>
					<span class="icon-bar middle-bar"></span>
					<span class="icon-bar bottom-bar"></span>
				</button>
				<?php
				wp_nav_menu( array(
					'theme_location'    => 'primary',
					'depth'             => 2, // 1 = no dropdowns, 2 = with dropdowns.
					'container'         => 'div',
					'container_class'   => 'navbar-collapse collapse',
					'container_id'      => 'navbarToggler',
					'menu_class'        => 'nav navbar-nav mx-auto mt-3 mt-md-0',
					'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
					'walker'            => new WP_Bootstrap_Navwalker(),
					'add_li_class'  => '', // set classes in li tag
					'add_a_class'  => 'nav-link px-md-4 ml-2 ml-md-0', // set classes in a tag
				) );
				?>
			</div>
		</nav>

	</header>
	<main id="primary" class="content-area main-wrapper">