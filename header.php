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

$custom_logo_id = get_theme_mod( 'custom_logo' );
$header_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<title>
		<?php
		bloginfo('name'); 
		wp_title('|', true, 'left'); 
		?>
	</title>

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<!-- Navigation -->
	<header class="nav-header">
	<nav class="navbar navbar-dark nav-top" style="background-color: <?php
    if(class_exists( 'Kirki' )){
		$header_bg = get_theme_mod('header_background_field_setting');
		if(isset($header_bg) && !empty($header_bg)):
			echo $header_bg;
		else:
			echo '#ffffff';
		endif;
    }else{
		echo '#ffffff';
    }
    ?>">
		<div class="container px-sm-0">
			<div class="navbar-nav">
				<?php
				if(has_custom_logo()):
					echo '<img alt="'.esc_attr( get_bloginfo( 'name' ) ).'" src="'.$header_logo[0].'" height="40px" width="100px">';
				else:
				?>
					<a class="navbar-brand col-md-6 px-0" style="color:<?php
					if(class_exists( 'Kirki' )){
						$header_logoTitleColor = get_theme_mod('header_logoColorTitle_field_setting');
						if(isset($header_logoTitleColor) && !empty($header_logoTitleColor)):
							echo $header_logoTitleColor;
						else:
							echo '#000000';
						endif;
					}else{
						echo '#000000';
					}
					?>" class="navbar-brand" href="<?php echo esc_url( home_url( '/' )); ?>">
						<h3 class="font-weight-bold" style="margin-bottom:0.3rem;"><?php esc_url(bloginfo('name')); ?></h3>
						<?php
						if(get_bloginfo('description')){
						?>
							<h6 class="mb-0" style="color:<?php
							if(class_exists( 'Kirki' )){
								$header_logoSubtitleColor = get_theme_mod('header_logoColorSubTitle_field_setting');
								if(isset($header_logoSubtitleColor) && !empty($header_logoSubtitleColor)):
									echo $header_logoSubtitleColor;
								else:
									echo '#000000';
								endif;
							}else{
								echo '#000000';
							}
							?>"><?php echo get_bloginfo('description'); ?></h6>
						<?php
						}
						?>
					</a>
				<?php
				endif;
				?>
			</div>
			
			<?php
			if(class_exists( 'Kirki' )){
			$media_repeater = get_theme_mod('header_social_media_repeater');
			$header_contactText = get_theme_mod('header_contactText_field_setting');
			$header_contactTextColor = get_theme_mod('header_contactColor_field_setting');

				if(!empty($header_contactText) && isset($header_contactText) || !empty($media_repeater) && isset($media_repeater)) {
			?>
					<div class="navbar-nav ml-sm-auto social-media">
						<?php
						if(!empty($header_contactText) && isset($header_contactText)){
						?>
						<div class="navbar-brand col-md-6 px-0" style="padding-top:10px">
							<a style="color:<?php
							if(isset($header_contactTextColor) && !empty($header_contactTextColor)):
								echo $header_contactTextColor;
							else:
								echo '#000000';
							endif;
							?>" href="tel:<?php echo $header_contactText; ?>">
							<h5 class="mb-0">
								<i class="fa fa-phone" aria-hidden="true" style="font-weight: 900"></i>
								<?php echo $header_contactText; ?>
							</h5>
							</a>
						</div>
						<?php
						}
						if(!empty($media_repeater) && isset($media_repeater)){
							echo '<div class="navbar-brand col-md-6 px-0 py-0 social-menu">';
							foreach($media_repeater as $social_media):
								$select_media = $social_media['header_social_media_select'];
								$link_media = $social_media['header_social_media_link'];
								$html = '';
								if($select_media == 'fb'){
									$html .= '<a href="'.$link_media.'"> <i class="fa fa-facebook-official social-icon-fb" aria-hidden="true"></i></a>';
								}
								elseif($select_media == 'instagram'){
									$html .= '<a href="'.$link_media.'"> <i class="fa fa-instagram social-icon-instagram" aria-hidden="true"></i></a>';
								}
								elseif($select_media == 'twitter'){
									$html .= '<a href="'.$link_media.'"> <i class="fa fa-twitter social-icon-twitter" aria-hidden="true"></i></a>';
								}
								elseif($select_media == 'pinterest'){
									$html .= '<a href="'.$link_media.'"> <i class="fa fa-pinterest social-icon-pinterest" aria-hidden="true"></i></a>';
								}
								elseif($select_media == 'linkedin'){
									$html .= '<a href="'.$link_media.'"> <i class="fa fa-linkedin-square social-icon-linkedin" aria-hidden="true"></i></a>';
								}
								echo $html;
							endforeach;
							echo '</div>';
						}
						?>
					</div>
			<?php
				}
			}
			?>
		</div>
    </nav>

    <nav class="navbar navbar-expand-md navbar-dark nav-bottom" 
    style="background-color: #343a40">

		<div class="container">
			<button class="navbar-toggler collapsed navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
				'container_id'      => 'navbarResponsive',
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