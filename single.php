<?php get_header(); ?>
<div class="w970">
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post_nav">
				<span class="alignleft"><?php previous_post_link('&laquo; %link') ?></span>
				<span class="alignright"><?php next_post_link('%link &raquo;') ?></span>
			</div>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

					<h2><?php the_title(); ?></h2>
					<div class="post-meta">发表于：<?php the_date(); ?> | <?php if(get_the_tags($post->ID)) : ?>标签： <?php the_tags(__(' '), ' '); ?> |<?php endif;?> <?php if(function_exists('the_views')) the_views();?></div>
					<?php the_content(); ?>
			</div>
			<div id="post_metadata">
				<h3>日志信息 &raquo;</h3>
				<div class="content">
					该日志于<?php the_time('Y-m-d H:i') ?>由 <?php the_author() ?> 发表在<?php the_category(', ') ?>分类下，
					<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Both Comments and Pings are open ?>
					你可以<a href="#respond">发表评论</a>。除了可以将这个日志以保留<a href="<?php the_permalink() ?>" rel="bookmark">源地址</a>及作者的情况下<a href="<?php trackback_url(); ?>" rel="trackback">引用</a>到你的网站或博客，还可以通过<?php post_comments_feed_link('RSS 2.0'); ?>订阅这个日志的所有评论。
					<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
					// Only Pings are Open ?>
					留言已关闭，但你可以将这个日志<a href="<?php trackback_url(); ?> " rel="trackback">引用</a>到你的网站或博客。
					<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Comments are open, Pings are not ?>
					通告目前不可用，你可以至底部留下评论。
					<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
					// Neither Comments, nor Pings are open ?>
					评论已关闭。
					<?php } ?>
				</div>
			</div>
			<?php comments_template(); ?>
			<?php endwhile; endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>