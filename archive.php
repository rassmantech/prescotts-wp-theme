<?php /* The product listing template */ ?>

<?php get_header(); ?>

<?php
    // Get current category
    $currentCat = get_queried_object();
    $currentID = $currentCat->term_id;
    $catID = 'product_categories_'.$currentCat->term_id;
    $currentParent = $currentCat->parent;
?>

    <main>
        <div class="content">
            <div class="no-builder">
                <div class="container">
                    <div class="row">
                        <div class="twelve columns">
                            <div class="fl-row-content-wrap">
                                <div class="fl-module-content breadcrumb">
                                    <div id="crumbs">
                                        <div class="product-breadcrumb">
                                            <a href="<?php echo home_url(); ?>">Home</a>&nbsp;&nbsp;>&nbsp;&nbsp;
                                            <a href="<?php echo home_url(); ?>/products">Products</a>&nbsp;&nbsp;>&nbsp;&nbsp;
                                            <?php echo get_term_parents_list($currentID, 'product_categories', $args = array('separator' => '&nbsp;&nbsp;>&nbsp;&nbsp;', 'inclusive' => false,)); ?>
                                            <?php echo single_cat_title(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="fl-module-content page-title">
                                    <h1><?php echo single_cat_title(); ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="three columns">
                            <div class="sidebar">
                                <?php
                                    // If current category is top level
                                    if ($currentParent == 0):
                                        $productCats = get_terms(array(
                                            'taxonomy' => 'product_categories',
                                            'parent' => $currentCat->term_id,
                                            'hide_empty' => true,
                                        ));
                                    // If current category is a child category
                                    else:
                                        $productCats = get_terms(array(
                                            'taxonomy' => 'product_categories',
                                            'parent' => $currentParent,
                                            'hide_empty' => true,
                                        ));
                                    endif;
                                    // Loop through product categories
                                    foreach ($productCats as $productCat):
                                        $productCatLink = get_term_link($productCat);
                                        // For the active category
                                        if ($productCat->term_id == $currentCat->term_id):
                                            echo '<div class="category-wrap active">';
                                                echo '<a href="javascript:void();" class="category">'.$productCat->name.'</a>';
                                                // Pass arguments for brands
                                                $brandCats = get_terms(array(
                                                    'taxonomy' => 'product_categories',
                                                    'parent' => 52,
                                                    'hide_empty' => true,
                                                ));
                                                // Loop through brands
                                                echo '<ul class="products">';
                                                    foreach ($brandCats as $brandCat):
                                                        // Pass arguments for products in the current product category and brand
                                                        $args = array(
                                                            'post_type'      => 'products',
                                                            'posts_per_page' => -1,
                                                            'orderby'        => 'menu_order',
                                                            'order'          => 'ASC',
                                                            'post_status'    => 'publish',
                                                            'tax_query' => array(
                                                                'relation' => 'AND',
                                                                array (
                                                                    'taxonomy' => 'product_categories',
                                                                    'field' => 'id',
                                                                    'terms' => $productCat->term_id,
                                                                ),
                                                                array (
                                                                    'taxonomy' => 'product_categories',
                                                                    'field' => 'id',
                                                                    'terms' => $brandCat->term_id,
                                                                ),
                                                            ),
                                                        );
                                                        // Query products
                                                        $productsQuery = new WP_Query($args);
                                                        // If products exist in the brand and product category
                                                        if ($productsQuery->have_posts()):
                                                            echo '<li>';
                                                                // Echo the name of the brand
                                                                echo'<img src="'.get_bloginfo('template_directory').'/img/icon-arrow.svg" /><a href="javascript:void();">'.$brandCat->name.'</a>';
                                                                    echo '<ul>';
                                                                    // Echo the names of the products
                                                                while ($productsQuery->have_posts()): $productsQuery->the_post();
                                                                    echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
                                                                endwhile;
                                                                echo '</ul>';
                                                            echo '</li>';
                                                        // If no products meet the current brand and category criteria
                                                        else:
                                                            $args = array(
                                                                'post_type'      => 'products',
                                                                'posts_per_page' => -1,
                                                                'orderby'        => 'menu_order',
                                                                'order'          => 'ASC',
                                                                'post_status'    => 'publish',
                                                                'tax_query' => array(
                                                                    'relation' => 'AND',
                                                                    array (
                                                                        'taxonomy' => 'product_categories',
                                                                        'field' => 'id',
                                                                        'terms' => $productCat->term_id,
                                                                    ),
                                                                    array (
                                                                        'taxonomy' => 'product_categories',
                                                                        'field' => 'id',
                                                                        'terms' => array(53, 54, 55, 56),
                                                                        'operator' => 'NOT IN',
                                                                    ),
                                                                ),
                                                            );
                                                            $noProductsQuery = new WP_Query($args);
                                                            if ($noProductsQuery->have_posts()):
                                                                echo '<li>';
                                                                    echo '<ul>';
                                                                        while ($noProductsQuery->have_posts()): $noProductsQuery->the_post();
                                                                            echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
                                                                        endwhile;
                                                                    echo '</ul>';
                                                                echo '</li>';
                                                            endif;
                                                        endif;
                                                    endforeach;
                                                echo '</ul>';
                                                // Loop through brands
                                                wp_reset_postdata();
                                            echo '</div>';
                                        // For inactive categories
                                        else:
                                            echo '<div class="category-wrap">';
                                                echo '<a href="'.$productCatLink.'" class="category">'.$productCat->name.'</a>';
                                            echo '</div>';
                                        endif;
                                    endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="nine columns">
                            <div class="fl-row-content-wrap main-content product-listing">
                                <div class="fl-module-content">
                                    <?php
                                        // Set variables for content above and below product listing
                                        $topContent = get_the_archive_description();
                                        $bottomContent = get_field('product_category_bottom', $catID);
                                    ?>
                                    <?php if ($topContent != ''): ?>
                                        <div class="category-description">
                                            <?php echo $topContent; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                        $args = array(
                                            'post_type'      => 'products',
                                            'posts_per_page' => -1,
                                            'orderby'        => 'menu_order',
                                            'order'          => 'ASC',
                                            'post_status'    => 'publish',
                                            'tax_query'      => array(
                                                array(
                                                    'taxonomy' => 'product_categories',
                                                    'field'    => 'id',
                                                    'terms'    => $currentID,
                                                ),
                                            ),
                                        );
                                        $productQuery = new WP_Query($args);
                                    ?>
                                    <?php if ($productQuery->have_posts()): ?>
                                        <div class="listing-wrap">
                                            <?php while ($productQuery->have_posts()): $productQuery->the_post(); ?>
                                                <?php
                                                    $rows = get_field('product_photos');
                                                    $firstRow = $rows[0];
                                                    $firstImage = $firstRow['product_photo'];
                                                    $image_size = 'full';
                                                    $image_array = wp_get_attachment_image_src($firstImage, $image_size);
                                                    $image_url = $image_array[0];
                                                ?>
                                                <a href="<?php the_permalink(); ?>" class="listing" title="<?php the_title(); ?>">
                                                    <div class="image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                                                    <div class="title">
                                                        <h2><?php the_title(); ?>
                                                    </div>
                                                </a>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($bottomContent != ''): ?>
                                        <div class="category-bottom-description">
                                            <?php echo $bottomContent; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>
