<?php /* The page template */ ?>

<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <main>
        <div class="content">
            <?php if (FLBuilderModel::is_builder_enabled()): ?>
                <div class="builder-wrap">
                    <?php the_content(); ?>
                </div>
            <?php else: ?>
                <div class="no-builder">
                    <div class="container">
                        <div class="twelve columns">
                            <div class="fl-row-content-wrap">
                                <div class="fl-module-content breadcrumb">
                                    <?php echo do_shortcode('[breadcrumb]'); ?>
                                </div>
                                <div class="fl-module-content page-title">
                                    <h1><?php the_title(); ?></h1>
                                </div>
                            </div>
                            <div class="fl-row-content-wrap main-content">
                                <div class="fl-module-content">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php endwhile; ?>

<?php get_footer(); ?>
