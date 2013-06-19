<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]> <html class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
<head>
	<meta charset="UTF-8">	
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<title><?php  wp_title('|', true, 'right'); if (is_home ()) echo get_option('blogname'); else bloginfo("name"); if (is_home ()&&get_option('blogdescription')) echo " - ", get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?><?php if ( is_single() ) { 	if (get_query_var('page')) 	{ echo '-第'; echo get_query_var('page'); echo '页';}}?></title>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap.min.css" media="all">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap-responsive.min.css" media="all">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/bootstrap/css/todc-bootstrap.css" media="all">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<script src="<?php bloginfo('template_url'); ?>/assets/js/html5.js"></script>
	<![endif]-->
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php if( dopt('d_headcode_b') != '' ) echo dopt('d_headcode'); ?>
</head>
<body>
<div id="top">
	<div class="w970">
		<ul>
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'menu', 'echo' => false)) )); ?>
		</ul>
		<?php bloginfo('description'); ?>
	</div>
</div>
<div id="header">
	<div class="w970">
		<span class="header-title"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></span>
		<div id="search">
			<form  class="form-search" id="searchform" method="get" action="<?php bloginfo('home'); ?>">
			  <div class="input-append">
				<input type="text" value="<?php the_search_query(); ?>" placeholder="输入关键字搜索"<?php if( is_search() ){ echo ' value="'.$s.'"'; } ?> autofocus="" x-webkit-speech="" class="span2 search-query" name="s" id="s" size="20" />
				<input type="submit" class="btn" value="搜索" />
				</div>
			</form>
		</div>
	</div>
</div>
<div id="nav">
	<div class="w970">
		<ul>
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
			<?php
            if(is_single()){
                $parent = get_the_category();
                $parent = $parent[0];
                $id = $parent->term_id;
            }
            ?>			
		</ul>
		<div id="rss">
			<a id="rss_icon" title="RSS订阅" href="<?php bloginfo('rss2_url'); ?>"></a>
		</div>
	</div>
</div>
