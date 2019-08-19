			</div><!--.site-content-->
		</div><!--.page-container-->
		
		<!-- footer -->
		<footer id="site-footer">
			<div class="top-footer">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-md-3 col-s-3">
							<?php
							$footer_logo_alt_text = get_field('footer_logo_alt_text', 'option');
							$blog_name = get_bloginfo('name', 'display');
							?>
							<div class="footer-logo">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($blog_name); ?>" rel="home"><img src="<?php echo get_field('footer_logo', 'option'); ?>" alt="<?php echo (!empty($footer_logo_alt_text)) ? $footer_logo_alt_text : esc_attr($blog_name); ?>"/></a>
							</div>
							<div class="footer-description"><?php dynamic_sidebar('footer-top-1'); ?></div>
						</div>
						<div class="col-sm-6 col-md-3 col-s-3">
							<?php dynamic_sidebar('footer-top-2'); ?>
						</div>
						<div class="col-sm-6 col-md-3 col-s-3">
							<?php dynamic_sidebar('footer-top-3'); ?>
						</div>
						<div class="col-sm-6 col-md-3 col-s-3">
							<?php dynamic_sidebar('footer-top-4'); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="colophon" class="bottom-footer">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-s-6 footer-left copyrights">
							<?php echo get_field('footer_copyrights', 'option'); ?>
						</div>
						<div class="col-sm-6 col-s-6 footer-right text-right website-by">
							<?php echo get_field('footer_site_credits', 'option'); ?>
						</div>
					</div>
				</div>
			</div>
		</footer>
		
		<?php if(get_field('enable_floating_cta', 'options')) {
			get_template_part( 'template-parts/content', 'floating-cta' );
		} ?>

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
