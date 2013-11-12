<?php
/**
 * @package WordPress
 * @subpackage Gurustu
 * @since Gurustu
 */
?><!doctype html>

<!--[if lt IE 7 ]> <html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ie-lt10 ie-lt9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 ie-lt10 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. --> 

<head>
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

	<meta charset="<?php bloginfo('charset'); ?>">
	<?php if (is_search()) echo '<meta name="robots" content="noindex, nofollow" />'; ?>
	<title><?php wp_title( '|', true, 'right' ); ?><?php echo bloginfo('title');?></title>
	<meta name="title" content="<?php wp_title( '|', true, 'right' ); ?>">
	<meta name="Copyright" content="Copyright &copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?>. All Rights Reserved.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
	<header id="header" role="header" class="row">
		<div class="columns large-12">
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div>
	</header>

	<nav id="nav" class="access row" role="navigation">
		<div class="columns large-12">
			<?php wp_nav_menu( array('menu' => 'primary') ); ?>
		</div>
	</nav>

	<div id="main" class="site-main">