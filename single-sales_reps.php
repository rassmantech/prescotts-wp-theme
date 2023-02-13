<?php /* The page template */ ?>

<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php
        // Get custom fields for rep
        $photo = get_field('sales_photo');
        $phone = get_field('sales_phone');
        $email = get_field('sales_email');
        $linkedin = get_field('sales_linkedin');
    ?>

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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if ($photo != ''): ?>
                            <div class="three columns">
                                <div class="fl-row-content-wrap">
                                    <div class="fl-module-content">
                                        <div class="profile-photo">
                                            <img src="<?php echo $photo; ?>" alt="<?php the_title(); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nine columns">
                        <?php else: ?>
                            <div class="twelve columns">
                        <?php endif; ?>
                                <div class="fl-row-content-wrap main-content">
                                    <div class="fl-module-content">
                                        <?php if ($phone != ''): ?>
                                            <p><strong>Phone:</strong><br /><?php echo $phone; ?></p>
                                        <?php endif; ?>
                                        <?php if ($email != ''): ?>
                                            <p><strong>Email:</strong><br /><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                                        <?php endif; ?>
                                        <?php if (have_rows('sales_service_areas')): $rowCount = 1; ?>
                                            <p><strong>Coverage Area:</strong><br />
                                                <?php while (have_rows('sales_service_areas')) : the_row(); ?>
                                                    <?php
                                                        if ($rowCount == 1):
                                                            echo get_sub_field('sales_service_area');
                                                        else:
                                                            echo ', '.get_sub_field('sales_service_area');
                                                        endif;
                                                    ?>
                                                <?php $rowCount++; endwhile; ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ($linkedin != ''): ?>
                                            <p><a href="<?php echo $linkedin; ?>" target="_blank" class="linkedin">View LinkedIn Profile</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php endwhile; ?>

<?php get_footer(); ?>
