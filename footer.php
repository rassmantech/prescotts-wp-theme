    <footer>
        <div id="contact-wrap">
            <div id="contact" class="container">
                <div class="twelve columns">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-contact')) : ?><?php endif; ?>
                </div>
            </div>
        </div>
        <div>
        <div id="footer-wrap">
            <div id="footer" class="container">
                <div class="three columns">
                    <div class="footer-widget">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-1')) : ?><?php endif; ?>
                    </div>
                </div>
                <div class="three columns">
                    <div class="footer-widget">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-2')) : ?><?php endif; ?>
                    </div>
                </div>
                <div class="three columns">
                    <div class="footer-widget">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-3')) : ?><?php endif; ?>
                    </div>
                </div>
                <div class="three columns">
                    <div class="footer-widget">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-4')) : ?><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>

<div id="mobilenav">
    <?php wp_nav_menu(array('theme_location' => 'mobile')); ?>
</div>

<?php wp_footer(); ?>

<!-- jQuery Plug-ins -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.mmenu.min.all.js"></script>
<?php if (is_singular('products')): ?>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.smoothproducts.min.js"></script>
<?php endif; ?>

<?php if (is_singular('products')): ?>
<script type="text/javascript">
    jQuery(window).load(function() {
        jQuery('.sp-wrap').smoothproducts();
    });
</script>
<?php endif; ?>

</body>
</html>
