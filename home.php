<?php get_header(); ?>
<div class="w970">
	<div id="main">	
		<?php 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
		    'order'   => DESC,		    
		    'caller_get_posts' => 1,
		    'paged' => $paged
		);
   		query_posts($args);		
		if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="media">
              <div class="media-body">
                 <h2 class="media-heading"><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
                 <div class="row">
				  <div class="span1"><span class="label label-info"><?php the_time('m-d');?></span></div>
				  <div class="span1"><span class="label label-info"><?php comments_number('0', '1', '%'); ?>人评论</span></div>
				  <div class="span1"><span class="label label-info"><?php if(function_exists('the_views')) echo the_views(); ?></span></div>
				 </div>
                <?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 136, '...'); ?><br />
                <?php dm_the_thumbnail();?>
              </div>
            </div>
		<?php endwhile; else: ?>
		<div class="post">你还没开始写你的日志吧，赶紧去后台写一篇试试吧。<a title="Home" class="active" href="<?php echo get_option('home'); ?>/">这里</a>回首页看看吧</div>
		<?php endif; ?>
		<div class="pagination">
			<ul><?php par_pagenavi(9); ?></ul>
		</div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>