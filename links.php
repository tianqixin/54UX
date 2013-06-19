<?php 
/*
	template name: links
*/
get_header();
?>
<div class="w970">
	
<div style="border-bottom:1px solid #e6e6e6;padding-bottom:40px;"><h1><?php echo get_the_title(); ?><strong>Friend links</strong></h1></div>
	
	<?php while (have_posts()) : the_post(); ?>
		<div class="row" style="margin-left:30px;display: inline;">
			<div class="span12"><?php the_content(); ?></div>
		
		<div class="row" style="display:inline;">
			<?php my_list_bookmarks('categorize=1&amp;category_orderby=id&amp;before=<div class="row12">&amp;after=&amp;show_images=1&amp;show_description=1&amp;orderby=name&amp;title_before=<div class="span2">&amp;title_after=</div>'); ?>
		</div>
		</div>
	<?php comments_template('', true); ?>	
	<?php endwhile;  ?>
	
</div>
<?php
function my_bookmarks($bookmarks, $args = '' ) {
	$defaults = array(
		'show_updated' => 0, 'show_description' => 0,
		'show_images' => 1, 'show_name' => 0,
		'before' => '<div class="span2">', 'after' => '</div>', 'between' => "\n",
		'show_rating' => 0, 'link_before' => '', 'link_after' => '','nofollow' =>0
	);
	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );
	$output = ''; // Blank string to start with.
	foreach ( (array) $bookmarks as $bookmark ) {
		if ( !isset($bookmark->recently_updated) )
			$bookmark->recently_updated = false;
		$output .= $before;
		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_prepend');
		$the_link = '#';
		if ( !empty($bookmark->link_url) )
			$the_link = esc_url($bookmark->link_url);
		$rel = ' rel="external';
		if ($nofollow)
			$rel .= ' nofollow';
		if ( '' != $bookmark->link_rel )
			$rel .= ' ' . $bookmark->link_rel;
		$rel .= '"';
		$desc = esc_attr(sanitize_bookmark_field('link_description', $bookmark->link_description, $bookmark->link_id, 'display'));
		$name = esc_attr(sanitize_bookmark_field('link_name', $bookmark->link_name, $bookmark->link_id, 'display'));
 		$title = $desc;
		if ( $show_updated )
			if ( '00' != substr($bookmark->link_updated_f, 0, 2) ) {
				$title .= ' (';
				$title .= sprintf(__('Last updated: %s'), date(get_option('links_updated_date_format'), $bookmark->link_updated_f + (get_option('gmt_offset') * 3600)));
				$title .= ')';
			}
		if ( '' != $title )
			$title = ' title="' . $title . '"';
		$alt = ' alt="' . $name . '"';
		$target = $bookmark->link_target;
		if ( '' != $target )
			$target = ' target="' . $target . '"';
		$output .= '<a href="' . $the_link . '"' . $rel . $title . $target. '>';
		$output .= $link_before;
		if ( $show_images ) {
			if ( $bookmark->link_image != null) {
				if ( strpos($bookmark->link_image, 'http') !== false )
					$output .= "<img width='16' height='16' src=\"$bookmark->link_image\" $alt $title />";
				else // If it's a relative path
					$output .= "<img width='16' height='16' src=\"" . get_option('siteurl') . "$bookmark->link_image\" $alt $title />";
			} else {//否则显示网站的Favicon
				if (preg_match('/^(https?:\/\/)?([^\/]+)/i',$the_link,$URI)) {//提取域名
					$domains = $URI[2];
				}else{//域名提取失败，显示默认小地球
					$domains = "example.com";
				}
				$output .= "<img width='16' height='16' src=\"http://www.google.com/s2/favicons?domain=$domains\" $alt $title />";
			}
		}
		$output .= $name;
		$output .= $link_after;
		$output .= '</a>';
		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_append');
		if ( $show_description && '' != $desc )
			$output .= $between . $desc;
		if ($show_rating) {
			$output .= $between . sanitize_bookmark_field('link_rating', $bookmark->link_rating, $bookmark->link_id, 'display');
		}
		$output .= "$after\n";
	} // end while
	return $output;
}
function my_list_bookmarks($args = '') {
	$defaults = array(
		'orderby' => 'name',
		'order' => 'ASC',
		'limit' => -1,
		'category' => '',
		'exclude_category' => '',
		'category_name' => '',
		'hide_invisible' => 1,
		'show_updated' => 0,
		'echo' => 1,
		'categorize' => 1,
		'title_li' => __('Bookmarks'),
		'title_before' => '<div class="span12" style="display: inline-block;border-bottom: 1px solid #e6e6e6;padding: 6px;font-weight: bold;margin-bottom: 10px;margin-left: 0;">',
		'title_after' => '</div>',
		'category_orderby' => 'name',
		'category_order' => 'ASC',
		'class' => 'linkcat',
		'category_before' => '',
		'category_after' => '',
		'nofollow' => 0
	);
	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );
	$output = '';
	if ( $categorize ) {
		//Split the bookmarks into ul's for each category
		$cats = get_terms('link_category', array('name__like' => $category_name, 'include' => $category, 'exclude' => $exclude_category, 'orderby' => $category_orderby, 'order' => $category_order, 'hierarchical' => 0));
		foreach ( (array) $cats as $cat ) {
			$params = array_merge($r, array('category'=>$cat->term_id));
			$bookmarks = get_bookmarks($params);
			if ( empty($bookmarks) )
				continue;
			$output .= str_replace(array('%id', '%class'), array("linkcat-$cat->term_id", $class), $category_before);
			$catname = apply_filters( "link_category", $cat->name );
			$output .= "$title_before$catname$title_after\n\t<div class='row'>\n";
			$output .= my_bookmarks($bookmarks, $r);
			$output .= "\n\t</div>\n$category_after\n";
		}
	} else {
		//output one single list using title_li for the title
		$bookmarks = get_bookmarks($r);
		if ( !empty($bookmarks) ) {
			if ( !empty( $title_li ) ){
				$output .= str_replace(array('%id', '%class'), array("linkcat-$category", $class), $category_before);
				$output .= "$title_before$title_li$title_after\n\t<div>\n";
				$output .= my_bookmarks($bookmarks, $r);
				$output .= "\n\t</div>\n$category_after\n";
			} else {
				$output .= my_bookmarks($bookmarks, $r);
			}
		}
	}
	$output = apply_filters( 'wp_list_bookmarks', $output );
	if ( !$echo )
		return $output;
	echo $output;
}
?>
<?php get_footer(); ?>