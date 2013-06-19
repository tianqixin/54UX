<div id="sidebar">
	<ul>
		<?php if(is_home() || is_front_page()) {?>
		<li><h2>置顶文章</h2>
		<ul>
		<?php
			$sticky = get_option('sticky_posts');
			rsort( $sticky );//对数组逆向排序，即大ID在前
			$sticky = array_slice( $sticky, 0, 10);//输出置顶文章数，读取最近5篇置顶文章
			query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1 ) );
			if (have_posts()) :
			while (have_posts()) : the_post();
		?>
			 <li>
			  <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
				  <?php the_title(); ?>
			  </a>
			 </li>
		<?php endwhile; endif; ?>
		</ul>
		</li>
		<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_homesidebar')){} ?>
		<?php } else {?>
		<li><h2>最新日志</h2>
			<?php 
				$args = array(
					'order'   => DESC,		    
					'caller_get_posts' => 1,
					'paged' => $paged,
					'showposts'=>10
				);
				query_posts($args);		
		?>
			<ul>
				<?php while (have_posts()) : the_post(); ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile;?>
			</ul>
		</li>
		<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_postsidebar')){}?>
		<?php }?>
			
		<li><h2>最新评论</h2>
			<?php
			global $wpdb;
			$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
			comment_post_ID, comment_author, comment_date_gmt, comment_approved,
			comment_type,comment_author_url,
			SUBSTRING(comment_content,1,35) AS com_excerpt
			FROM $wpdb->comments
			LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
			$wpdb->posts.ID)
			WHERE comment_approved = '1' AND comment_type = '' AND
			post_password = ''
			ORDER BY comment_date_gmt DESC
			LIMIT 10";
			$comments = $wpdb->get_results($sql);
			$output = $pre_HTML;
			$output .= "\n<ul>";
			foreach ($comments as $comment) {
			$output .= "\n<li>".strip_tags($comment->comment_author)
			.":" . "<a href=\"" . get_permalink($comment->ID) .
			"#comment-" . $comment->comment_ID . "\" title=\"on " .
			$comment->post_title . "\">" . strip_tags($comment->com_excerpt)
			."</a></li>";
			}
			$output .= "\n</ul>";
			$output .= $post_HTML;
			echo $output;?>
		</li>
	
		<li><h2>标签云</h2>
			<div class="tags">
				<?php wp_tag_cloud('unit=px&smallest=12&largest=20'); ?>
			</div>
		</li>
	</ul>
</div>
