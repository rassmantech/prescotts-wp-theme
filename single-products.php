<?php /* The page template */ ?>

<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <main>
        <div class="content">
            <div class="no-builder">
                <div class="container">
                    <div class="row">
                        <div class="twelve columns">
                            <div class="fl-row-content-wrap">
                                <div class="fl-module-content breadcrumb">
                                    <?php echo do_shortcode('[breadcrumb]'); ?>
                                </div>
                                <div class="fl-module-content page-title">
                                    <h1><?php the_title(); ?></h1>
                                    <?php if (get_field('product_subhead')): ?>
                                        <h2><?php the_field('product_subhead'); ?></h2>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if(have_rows('product_photos')): ?>
                            <div class="three columns">
                                <div class="fl-row-content-wrap">
                                    <div class="fl-module-content">
                                        <div class="product-photos">
                                            <div class="sp-loading"><img src="https://www.surgicalmicroscopes.com/wp-content/uploads/2022/07/img-loading.gif" alt=""></div>
                                            <div class="sp-wrap">
                                                <?php while (have_rows('product_photos')) : the_row(); ?>
                                                    <?php
                                                        $image_id = get_sub_field('product_photo');
                                                        $image_size = 'full';
                                                        $image_array = wp_get_attachment_image_src($image_id, $image_size);
                                                        $image_url = $image_array[0];
                                                    ?>
                                                    <a href="<?php echo $image_url; ?>">
                                                        <img src="<?php echo $image_url; ?>" />
                                                    </a>
                                                <?php endwhile; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nine columns">
                        <?php else: ?>
                            <div class="twelve columns">
                        <?php endif; ?>
                                <div class="fl-row-content-wrap">
                                    <div class="fl-module-content">
                                        <div class="stick-here"></div>
                                        <div class="product-cta-wrap">
                                            <div class="product-cta-info cf">
                                                <?php if(have_rows('product_photos')): $i = 1; ?>
                                                    <?php while (have_rows('product_photos')) : the_row(); ?>
                                                        <?php if ($i == 1): ?>
                                                            <div class="product-cta-image">
                                                                <?php
                                                                    $image_id = get_sub_field('product_photo');
                                                                    $image_size = 'full';
                                                                    $image_array = wp_get_attachment_image_src($image_id, $image_size);
                                                                    $image_url = $image_array[0];
                                                                ?>
                                                                <img src="<?php echo $image_url; ?>" />
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php $i++; endwhile; ?>
                                                <?php endif; ?>
                                                <div class="product-cta-title">
                                                    <?php the_title(); ?>
                                                </div>
                                            </div>
                                            <div class="product-cta">
                                                <div class="quote">
                                                    <h2>Ready to Rent or Buy?</h2>
                                                    <a href="<?php echo home_url(); ?>/request-a-quote?product=<?php echo get_the_ID(); ?>">Request a Quote Today</a>
                                                </div>
                                                <div class="rent-buy">
                                                    <h2>More Questions? Contact Our Sales Team</h2>
                                                    <a href="<?php echo home_url(); ?>/sales-service/u-s-sales-service" class="u-s">Find a Sales Rep in your Area (U.S.)</a>
                                                    <a href="<?php echo home_url(); ?>/sales-service/international" class="intl">Contact Our International Sales Team</a>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="product-description">
                                                <?php if (get_field('product_description')): ?>
                                                    <?php the_field('product_description'); ?>
                                                <?php endif; ?>
                                                <?php if (get_field('product_brochure')): ?>
                                                    <p><a href="<?php the_field('product_brochure'); ?>" target="_blank" class="fl-button">Download Brochure</a></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
						// get specs data before we do the shortcode
						$specs = get_field('product_specs');
						?>
					
                        <div class="row">
                            <div class="twelve columns">
                                <div class="product-testimonials">
                                    <?php echo do_shortcode('[testimonials_carousel]'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-specs">
                        <div class="container">
                            <div class="row">
                                <div class="six columns">
                                    <div class="product-video">
                                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('product-video')) : ?><?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($specs): ?>
                                    <div class="six columns">
                                        <div class="fl-row-content-wrap">
                                            <div class="fl-module-content">
                                                <?php echo $specs; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php endwhile; ?>

<?php get_footer(); ?>
