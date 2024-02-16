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

<!-- jQuery -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->

<?php wp_head(); ?>

<!-- jQuery NoConflict -->
<script>
    var $j = jQuery.noConflict();
</script>

<?php if (is_page('international')): ?>
    <script type="text/javascript">
        $j(document).ready(function(){
            var userLang = navigator.language || navigator.userLanguage;
            if (userLang == "en") {
                window.location.href = "http://surgicalmicroscopes.com/sales-service/international/english"
            } else if (userLang == "es") {
                window.location.href = "http://surgicalmicroscopes.com/sales-service/international/espanol"
            } else if (userLang == "fr") {
                window.location.href = "http://surgicalmicroscopes.com/sales-service/international/francais"
            } else if (userLang == "it") {
                window.location.href = "http://surgicalmicroscopes.com/sales-service/international/italiano"
            } else {
                window.location.href = "http://surgicalmicroscopes.com/sales-service/international/english"
            }
        });
    </script>
<?php endif; ?>

</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BDDB28"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="page-wrap">

    <header>
        <div id="header-wrap">
            <div id="header" class="container">
                <div class="logo">
                    <a href="<?php echo home_url(); ?>" title="Home">
                        <img src="<?php bloginfo('template_directory'); ?>/img/prescotts-logo.svg" />
                    </a>
                </div>
                <div class="mobilenav">
                    <a href="#mobilenav"></a>
                </div>
                <div class="header-content cf">
                    <div class="header-search">
                        <div class="language">
                            <div class="select">Select Language</div>
                            <div id="google_translate_element"></div>
                            <script type="text/javascript">
                                function googleTranslateElementInit() {
                                    new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
                                }
                            </script>
                            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                        </div>
                        <div class="mobilenav">
                            <a href="#mobilenav"></a>
                        </div>
                    </div>
                    <div class="header-iso">
                        <a href="#">
                            <img src="https://www.surgicalmicroscopes.com/wp-content/uploads/2023/02/iso-logo.png" />
                        </a>
                    </div>
                    <div class="header-contact">
                        <ul>
                            <!-- {if segment_2 == "uk-service-repair"}<li class="phone"><a href="tel:0770-210-4599">0770 210 4599</a></li> -->
                            <li class="phone"><a href="tel:1-800-438-3937">1-800-438-3937</a></li>
                            <li class="email"><a href="mailto:prescott@surgicalmicroscopes.com">prescott@surgicalmicroscopes.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="nav-wrap">
            <div id="nav" class="container">
                <?php wp_nav_menu(array('theme_location' => 'main')); ?>
            </div>
        </div>
    </header>
