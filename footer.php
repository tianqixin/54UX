<footer class="footer">
	<div class="container">
		<p>© 2013－2014 <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>, all rights reserved. </p>
		<!-- 请支持作者，保留出处。-->
		<p>Powered by <a href="http://cn.wordpress.org/" target="_blank"> WordPress.</a>Theme by <a href="http://www.54ux.com/">wordpress教程网</a>.</p>
	</div>	 
    <a id="scrollUp" href="#top" title="回到顶部"></a>
	<script src="<?php bloginfo('template_url'); ?>/assets/js/jquery.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/assets/js/jquery.scrollUp.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/bootstrap/js/bootstrap.min.js"></script>
	<?php if( dopt('d_footcode_b') != '' ) echo dopt('d_footcode'); ?>
	<div style="display:none">
		<?php if( dopt('d_track_b') ) echo dopt('d_track'); ?>
	</div>
</footer>
</body>
</html>