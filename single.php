<?php /* The single post template */ ?>

<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<main>
    <div class="content">
        <div class="no-builder">
            <div class="container">
                <div class="fl-row-content-wrap">
                    <div class="row">
                        <div class="twelve columns">
                            <div class="fl-module-content">
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fl-row-content-wrap">
                    <div class="row">
                        <div class="twelve columns">
                            <?php $image = get_field('post_photo'); ?>
                            <?php $size = 'full'; ?>
                            <?php if($image): ?>
                                <div class="post-feature">
                                    <?php echo wp_get_attachment_image( $image, $size ); ?>
                                </div>
                            <?php endif; ?>
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
