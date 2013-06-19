<?php 
/*
	template name: readers
*/

get_header();
?>
<div class="w970">
<div style="border-bottom:1px solid #e6e6e6;"><h2><?php the_title('',' &raquo;'); ?></h2></div>
<div class="row" style="padding-top: 10px;">
<?php
function readers_wall( $outer='1',$timer='100',$limit='200' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( now(), interval $timer month ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$c_url = $count->comment_author_url;
		if ($c_url == '') $c_url = '';
		$type .= '<div  class="span3"><img class="avatar" src="'.default_avatar_url($count->comment_author_email).'"><a class="btn" target="_blank" href="'. $c_url . '">' . $count->comment_author . '</a><span class="badge badge-success" style="float:right">'. $count->cnt . '</span></div>';
	}
	echo $type;
};

?>
<?php while (have_posts()) : the_post(); ?>	
		<?php readers_wall(); ?>
	
<?php endwhile;  ?>
</div>
</div>

<?php get_footer(); ?>