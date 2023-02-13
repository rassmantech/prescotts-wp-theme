<!DOCTYPE html>
<html lang="en">
<head>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5BDDB28');</script>
<!-- End Google Tag Manager -->

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/img/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php bloginfo('template_directory'); ?>/img/favicon/manifest.json">
<link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/img/favicon/safari-pinned-tab.svg" color="#9a7f42">
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon/favicon.ico?v=1" />
<meta name="theme-color" content="#ffffff">

<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!-- Theme Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">

<!-- Theme Stylesheets -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/reset.css" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/skeleton.css" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/jquery.mmenu.all.css" />
<?php if (is_singular('products')): ?><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/jquery.smoothproducts.css" /><?php endif; ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?v=1.2" />

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?php wp_head(); ?>

<!-- jQuery NoConflict -->
<script>
    var $j = jQuery.noConflict();
</script>

</head>
<body class="exchange-body">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BDDB28"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="page-wrap">

    <?php if (is_user_logged_in() && !is_page('Update')): ?>
        <header>
            <div id="header-wrap" class="exchange-header">
                <div class="container">
                    <div class="exchange-nav">
                        <?php wp_nav_menu(array('theme_location' => 'exchange')); ?>
                    </div>
                </div>
            </div>
        </header>
        <div class="exchange-logout">
            <div class="container">
                <div class="twelve columns">
                    <div class="logout">
                        <a href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']); ?>" title="Logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
