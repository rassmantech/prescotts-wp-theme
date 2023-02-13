<?php

/**
*
* Theme Setup
* @package prescotts
*
**/
add_action('after_setup_theme', 'prescotts_theme_setup');
function prescotts_theme_setup(){
    /* Add theme support for automatic feed links. */
    add_theme_support('automatic-feed-links');
    /* Add theme support for post thumbnails (featured images). */
    add_theme_support('post-thumbnails');
    /* Add your nav menus function to the 'init' action hook. */
    add_action('init', 'prescotts_register_menus');
    /* Add your sidebars function to the 'widgets_init' action hook. */
    add_action('widgets_init', 'prescotts_widgets_init');
    /* Load JavaScript files on the 'wp_enqueue_scripts' action hook. */
    add_action('wp_enqueue_scripts', 'prescotts_load_scripts');
}


/**
*
* Register Menu Areas
* @package prescotts
*
**/
function prescotts_register_menus(){
    register_nav_menus(array(
        'main'      => __('Main Menu', 'prescotts'),
        'mobile'    => __('Mobile Menu', 'prescotts'),
        'exchange'  => __('Exchange Menu', 'prescotts'),
    ));
}


/**
*
* Register Widget Areas
* @package prescotts
*
**/
function prescotts_widgets_init(){
    register_sidebar(array(
        'name'          => __('Footer Contact', 'prescotts'),
        'id'            => 'footer-contact',
        'description'   => __('The top footer area.', 'prescotts'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Featured Product Video', 'prescotts'),
        'id'            => 'product-video',
        'description'   => __('The video on individual product pages.', 'prescotts'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'prescotts'),
        'id'            => 'footer-1',
        'description'   => __('One of four areas in the site footer.', 'prescotts'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => __('Footer Column 2', 'prescotts'),
        'id'            => 'footer-2',
        'description'   => __('One of four areas in the site footer.', 'prescotts'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => __('Footer Column 3', 'prescotts'),
        'id'            => 'footer-3',
        'description'   => __('One of four areas in the site footer.', 'prescotts'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => __('Footer Column 4', 'prescotts'),
        'id'            => 'footer-4',
        'description'   => __('One of four areas in the site footer.', 'prescotts'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}


/**
*
* Customize Excerpt Length
* @package prescotts
*
**/
function custom_excerpt_length($length){
    return 25;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);


/**
*
* Customize Excerpt Read More
* @package prescotts
*
**/
function new_excerpt_more($more){
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


/**
*
* Styles and Scripts Enqueue
* @package prescotts
*
**/
function prescotts_load_scripts(){
    // Javascript Files
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC0pVmTypD3anb77CvfNJPLIGfv0ivDlVA', array(), false, true);
    wp_enqueue_script('reps-map', get_template_directory_uri() . '/js/map.js', array('google-maps'), '1.0.0', true);
    wp_enqueue_script('prescotts-js', get_template_directory_uri() . '/js/prescotts.js', array('google-maps'), '1.0.0', true);
    wp_register_script('slick-slider', get_template_directory_uri() . '/js/jquery.slick.min.js', array(), '1.0.0', true);
    // AJAX Variables
    $ajax_params = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('prescott_nonce'),
    );
    wp_localize_script('prescotts-js', 'ajax_object', $ajax_params);
    // Stylesheets
    wp_enqueue_style( 'reset', get_template_directory_uri() . '/css/reset.css');
    wp_enqueue_style( 'skeleton', get_template_directory_uri() . '/css/skeleton.css');
    wp_enqueue_style( 'jquery', get_template_directory_uri() . '/css/jquery.mmenu.all.css');
    wp_enqueue_style( 'smoothproducts', get_template_directory_uri() . '/css/jquery.smoothproducts.css');
    wp_enqueue_style( 'slick-slider', get_template_directory_uri() . '/css/jquery.slick.css');
    wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/css/jquery.slick-theme.css');
	
    wp_enqueue_style( 'theme-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap');
    wp_enqueue_style( 'surgicalmicroscopes', get_stylesheet_uri(), array(), null );
}
add_action('wp_enqueue_scripts', 'prescotts_load_scripts');


/**
*
* Admin Enqueue
* @package prescotts
*
**/
function prescotts_admin_scripts(){
    wp_enqueue_script('prescotts-admin-js', get_template_directory_uri() . '/js/prescotts-admin.js', array(), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'prescotts_admin_scripts');


/**
*
* Custom Color Presets for Page Builder
* @package prescotts
*
**/
function prescotts_builder_color_presets($colors){
    $colors[] = '195277';
    $colors[] = '005F9E';
    $colors[] = '3B4652';
    $colors[] = '888888';
    $colors[] = 'EEEEEE';
    $colors[] = 'FFB621';
    return $colors;
}
add_filter('fl_builder_color_presets', 'prescotts_builder_color_presets');


/**
*
* Add Custom Image Sizes
* @package prescotts
*
**/
add_image_size('watermark', 150, 150);
add_filter('image_size_names_choose', 'prescotts_custom_sizes');
function prescotts_custom_sizes($sizes){
    return array_merge($sizes, array(
        'watermark' => __('Watermark'),
    ));
}


/**
*
* Add Products Custom Post Type
* @package prescotts
*
**/
function products_init(){
    $args = array(
        'label'             => 'Products',
        'public'            => true,
        'show_ui'           => true,
        'capability_type'   => 'post',
        'hierarchical'      => false,
        'rewrite'           => array('slug' => 'product'),
        'query_var'         => true,
        'menu_icon'         => 'dashicons-products',
        'show_in_nav_menus' => true,
        'supports'          => array(
            'title',
            'editor',
            'revisions',
            'page-attributes'),
    );
    register_post_type('products', $args);
}
add_action('init', 'products_init');


/**
*
* Add Products Custom Taxonomy
* @package prescotts
*
**/
function products_cat_init(){
    $labels = array(
        'name'              => _x('Product Categories', 'taxonomy general name'),
        'singular_name'     => _x('Product Category', 'taxonomy singular name'),
        'search_items'      => __('Search Product Categories'),
        'all_items'         => __('All Product Categories'),
        'parent_item'       => __('Parent Product Category'),
        'parent_item_colon' => __('Parent Product Category:'),
        'edit_item'         => __('Edit Product Category'),
        'update_item'       => __('Update Product Category'),
        'add_new_item'      => __('Add New Product Category'),
        'new_item_name'     => __('New Product Category'),
        'menu_name'         => __('Product Categories'),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array(
            'slug'          => 'products',
            'with_front'    => true,
            'hierarchical'  => true,
        ),
    );
    register_taxonomy('product_categories', 'products', $args);
}
add_action('init', 'products_cat_init', 0);


/**
*
* Add Sales Reps Custom Post Type
* @package prescotts
*
**/
function sales_reps_init(){
    $args = array(
        'label'               => 'Sales/Service Reps',
        'public'              => true,
        'show_ui'             => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'rewrite'             => array('slug' => 'sales-service-reps'),
        'query_var'           => true,
        'exclude_from_search' => true,
        'menu_icon'           => 'dashicons-businessman',
        'show_in_nav_menus'   => true,
        'supports'            => array(
            'title',
            'editor',
            'revisions',
            'page-attributes'),
    );
    register_post_type('sales_reps', $args);
}
add_action('init', 'sales_reps_init');


/**
*
* Add Sales Reps Custom Traxonomy
* @package prescotts
*
**/
function rep_categories_init(){
    $labels = array(
        'name'              => _x('Rep Categories', 'taxonomy general name'),
        'singular_name'     => _x('Rep Category', 'taxonomy singular name'),
        'search_items'      => __('Search Rep Categories'),
        'all_items'         => __('All Rep Categories'),
        'parent_item'       => __('Parent Rep Category'),
        'parent_item_colon' => __('Parent Rep Category:'),
        'edit_item'         => __('Edit Rep Category'),
        'update_item'       => __('Update Rep Category'),
        'add_new_item'      => __('Add New Rep Category'),
        'new_item_name'     => __('New Rep Category'),
        'menu_name'         => __('Rep Categories'),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
    );
    register_taxonomy('rep_categories', 'sales_reps', $args);
}
add_action('init', 'rep_categories_init', 0);


/**
*
* Add Testimonials Custom Post Type
* @package prescotts
*
**/
function testimonials_init(){
    $args = array(
        'label'             => 'Testimonials',
        'public'            => true,
        'show_ui'           => true,
        'capability_type'   => 'post',
        'hierarchical'      => false,
        'rewrite'           => array('slug' => 'testimonials'),
        'query_var'         => true,
        'menu_icon'         => 'dashicons-format-quote',
        'show_in_nav_menus' => true,
        'supports'          => array(
            'title',
            'editor',
            'revisions',
            'page-attributes'),
    );
    register_post_type('testimonials', $args);
}
add_action('init', 'testimonials_init');


/**
*
* Breadcrumb Shortcode
* @package prescotts
*
**/
function page_breadcrumbs(){
    $showOnHome  = 0;
    $delimiter   = '<li>&nbsp;>&nbsp;</li>';
    $home        = 'Home';
    $showCurrent = 1;
    $before      = '<li class="current">';
    $after       = '</li>';
    global $post;
    $homeLink = get_bloginfo('url');
    $output   = '';
    if (is_home() || is_front_page()) {
        if ($showOnHome == 1) {
            $output .= '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
        }

    } else {
        $output .= '<div id="crumbs"><ul><li><a href="' . $homeLink . '">' . $home . '</a></li> ' . $delimiter . ' ';
        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $output .= get_category_parents($thisCat->parent, true, ' ' . $delimiter . ' ');
            }

            $output .= $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
        } elseif (is_search()) {
            $output .= $before . 'Search results for "' . get_search_query() . '"' . $after;
        } elseif (is_day()) {
            $output .= '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
            $output .= '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
            $output .= $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            $output .= '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
            $output .= $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            $output .= $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug      = $post_type->rewrite;
                $output .= '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
                if ($showCurrent == 1) {
                    $output .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                }

            } else {
                $cat  = get_the_category();
                $cat  = $cat[0];
                $cats = get_category_parents($cat, true, ' ' . $delimiter . ' ');
                if ($showCurrent == 0) {
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                }

                $output .= $cats;
                if ($showCurrent == 1) {
                    $output .= $before . get_the_title() . $after;
                }

            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            $output .= $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat    = get_the_category($parent->ID);
            $cat    = $cat[0];
            $output .= get_category_parents($cat, true, ' ' . $delimiter . ' ');
            $output .= '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
            if ($showCurrent == 1) {
                $output .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }

        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1) {
                $output .= $before . get_the_title() . $after;
            }

        } elseif (is_page() && $post->post_parent) {
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page          = get_page($parent_id);
                $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id     = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                $output .= $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1) {
                    $output .= ' ' . $delimiter . ' ';
                }

            }
            if ($showCurrent == 1) {
                $output .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }

        } elseif (is_tag()) {
            $output .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            $output .= $before . 'Articles posted by ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            $output .= $before . 'Error 404' . $after;
        } elseif (is_archive()) {
            $output .= 'Test Archive Output';
        }
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                $output .= ' (';
            }

            $output .= __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                $output .= ')';
            }

        }
        $output .= '</ul></div>';
    }
    return $output;
}
add_shortcode('breadcrumb', 'page_breadcrumbs');


/**
*
* International Page Sidebar Shortcode
* @package prescotts
*
**/
function intl_menu(){
    global $post;
    return '<div class="translate"><ul>' . wp_list_pages('echo=0&depth=1&title_li=&child_of=' . $post->post_parent . '&exclude=' . $post->ID) . '</ul></div>';
}
add_shortcode('translate', 'intl_menu');


/**
*
* Map Shortcode
* @package prescotts
*
**/
function display_map($atts){
    extract(shortcode_atts(array(
        'categories' => 'rep',
    ), $atts));
    $output          = '';
    $categoriesArray = explode(',', $categories);
    // Enqueue javascript files
    wp_enqueue_script('google-maps');
    wp_enqueue_script('reps-map');
    // Output map canvas div
    $output .= '<div id="map-canvas"></div>';
    // For each category referenced in the shortcode attribute
    // Pass argument for sales reps posts within category
    $args = array(
        'post_type'      => 'sales_reps',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'rep_categories',
                'field'    => 'slug',
                'terms'    => $categoriesArray,
            ),
        ),
    );
    // Query sales rep posts
    $repQuery = new WP_Query($args);
    if ($repQuery->have_posts()):
        $output .= '<script type="text/javascript">';
        // Output start of Markers array
        $output .= 'var markers = [';
        while ($repQuery->have_posts()): $repQuery->the_post();
            // Setup variables to use
            $name        = get_the_title();
            $coords      = get_geocode_latlng(get_the_ID());
            $cleanCoords = str_replace(array('(', ')', ' '), '', $coords);
            // Add individual post to Markers array
            $output .= '[\'' . $name . '\', ' . $cleanCoords . '],';
        endwhile;
        $output .= '];';
        // Output start of infoWindow array
        $output .= 'var infoWindowContent = [';
        while ($repQuery->have_posts()): $repQuery->the_post();
            // Setup variables to use
            $name     = get_the_title();
            $link     = get_the_permalink();
            $photo    = get_field('sales_photo');
            $phone    = get_field('sales_phone');
            $email    = get_field('sales_email');
            $linkedin = get_field('sales_linkedin');
            // Add individual post to infoWindow array
            $output .= '[\'<div class="info_content"><div class="info-window">' .
                '<h2><a href="' . $link . '">' . $name . '</a></h2>';
            if ($photo != ''):
                $output .= '<div class="contact-photo" style="background-image:url(' . $photo . ');"><a href="' . $link . '"></a></div><div class="contact-info with-photo">';
            else:
                $output .= '<div class="contact-info">';
            endif;
            if ($phone != ''):
                $output .= '<p><strong>Phone:</strong><br />' . $phone . '</p>';
            endif;
            if ($email != ''):
                $output .= '<p><strong>Email:</strong><br /><a href="mailto:' . $email . '">' . $email . '</a></p>';
            endif;
            if (have_rows('sales_service_areas')):
                $output .= '<p><strong>Coverage Area:</strong><br />';
                $rowCount = 1;
                while (have_rows('sales_service_areas')): the_row();
                    if ($rowCount == 1):
                        $output .= get_sub_field('sales_service_area');
                    else:
                        $output .= ', ' . get_sub_field('sales_service_area');
                    endif;
                    $rowCount++;
                endwhile;
                $output .= '</p>';
            endif;
            if ($linkedin != ''):
                $output .= '<p><a href="' . $linkedin . '" target="_blank" class="linkedin">View LinkedIn Profile</a></p>';
            endif;
            $output .= '</div>';
            $output .= '</div></div>\'],';
        endwhile;
        $output .= '];';
        $output .= '</script>';
    endif;
    wp_reset_postdata();
    return $output;
}
add_shortcode('map', 'display_map');


/**
*
* Custom filter for category titles
* @package prescotts
*
**/
add_filter('get_the_archive_title', function ($title) {
    if (is_category()):
        $title = single_cat_title('', false);
    endif;
    return $title;
});


/**
*
* Disable admin bar for all users who aren't admins
* @package prescotts
*
**/
function remove_admin_bar(){
    if (!current_user_can('administrator') && !is_admin()):
        show_admin_bar(false);
    endif;
}
add_action('after_setup_theme', 'remove_admin_bar');


/**
*
* Add custom query variables
* @package prescotts
*
**/
function add_query_vars_filter($vars){
    $vars[] = 'serial';
    $vars[] = 'product';
    return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');


/**
*
* Populate Department in Hidden Field
* @package prescotts
*
**/
function populate_department($default_value, $field_type, $field_settings){
    $product = get_query_var('product');
    if ($product != ''):
        $product_post = get_post($product);
        if ($field_settings['key'] == 'i_m_interested_in_1533243352254'):
            $default_value = $product_post->post_title;
        endif;
    else:
        if ($field_settings['key'] == 'i_m_interested_in_1533243352254'):
            $default_value = '';
        endif;
    endif;
    return $default_value;
}
add_filter('ninja_forms_render_default_value', 'populate_department', 10, 3);



/**
*
* Includes Section, reduces functions.php complexity
* @package prescotts
*
**/
require_once get_template_directory() . '/inc/exchange.php';
require_once get_template_directory() . '/inc/email-options.php';
require_once get_template_directory() . '/inc/email-handler.php';


/**
*
* Setup User Type for Return/Exchange
* @package prescotts
*
**/
add_role(
    'exchange_user',
    __( 'Exchange User' ),
    array(
        'read'          => true,
        'edit_posts'    => true,
    )
);


/**
*
* Custom User Type for Regional Manager
* @package prescotts
*
**/
add_role(
    'regional_manager',
    __( 'Regional Manager' ),
    array(
        'read'          => true,
        'edit_posts'    => true,
    )
);


/**
*
* Add regional fields to user in back end user file
* @package prescotts
*
**/
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Manager Region", "blank"); ?></h3>
        <?php $user_region = esc_attr(get_the_author_meta('region', $user->ID)); ?>
        <select name="region" id="region">
            <option value="">- Select a Region -</option>
            <option <?php if ($user_region == 'midwest'): echo 'selected '; endif; ?>value="midwest">Midwest</option>
            <option <?php if ($user_region == 'northeast'): echo 'selected '; endif; ?>value="northeast">Northeast</option>
            <option <?php if ($user_region == 'south'): echo 'selected '; endif; ?>value="south">South</option>
            <option <?php if ($user_region == 'southeast'): echo 'selected '; endif; ?>value="southeast">Southeast</option>
            <option <?php if ($user_region == 'west'): echo 'selected '; endif; ?>value="west">West</option>
			<option <?php if ($user_region == 'uk'): echo 'selected '; endif; ?>value="uk">UK</option>
        </select>
<?php }


/**
*
* Save regional fields to user meta data
* @package prescotts
*
**/
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    update_user_meta( $user_id, 'region', $_POST['region'] );
}


/**
*
* Testimonials Carousel Shortcode
* @package prescotts
*
**/
function testimonials_carousel() {
    wp_enqueue_script('slick-slider');
    $output = '<div class="testimonials-carousel">';
    $args = array(
        'post_type' => 'testimonials',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    );
    $testimonials_query = new WP_Query($args);
    if ($testimonials_query->have_posts()):
        $output .= '<hr /><div class="slider">';
        while ($testimonials_query->have_posts() ) : $testimonials_query->the_post();
            $quote = get_the_content();
            $source = get_field('testimonial_source_name');
            $company = get_field('testimonial_source_company');
            $title = get_field('testimonial_source_title');
            $output .= '<div class="slide"><blockquote>'. $quote . '</blockquote>';
                if ($source != ''):
                    $output .= '<cite><span class="name">' . $source . '</span>';
                endif;
                if ($title != ''):
                    $output .= '<span class="title">' . $title;
                endif;
                    if ($company != ''):
                        $output .= ', ' . $company;
                    endif;
                    if ($title != ''):
                        $output .= '</span>';
                    endif;
                if ($source != ''):
                    $output .= '</cite>';
                endif;
            $output .= '</div>';
        endwhile;
        $output .= '</div>';
    endif;
	wp_reset_postdata();
    return $output;
}
add_shortcode('testimonials_carousel', 'testimonials_carousel');
