<?php /* Template Name: Password */ ?>

<?php $serial = get_query_var('serial'); ?>

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
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?php wp_head(); ?>

<!-- jQuery NoConflict -->
<script>
    var $j = jQuery.noConflict();
</script>

</head>
<body class="pass">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BDDB28"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php while (have_posts()) : the_post(); ?>

    <main>
        <div id="pass-wrap">
            <div id="pass" class="container">
                <div class="twelve columns">
                    <?php if (is_user_logged_in()): ?>
                        <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log Out" class="logout">Log Out</a>
                        <?php if ($serial != ''):

                            // Set variable for return button
                            $returnbutton = '<p><a href="'.home_url().'/password/" class="return-button">Enter Another Serial Number</a></p>';

                            // Clean entered serial
                            $serialclean = str_replace("-", "", $serial);
                            $serialmodel = substr($serialclean, 0, 5);

                            // Verify only numbers were entered
                            if (!preg_match("/^[0-9]+$/", $serialclean)):
                                echo '<h2>Input Error</h2><p class="error">The serial number can only contain numbers. Please try again.</p><p class="entered">You entered: ' . $serial . '</p>' . $returnbutton;
                            else:

                                // Verify exactly 10 digits were entered
                                $serialcount = strlen((string)$serialclean);
                                if ($serialcount != 10):
                                    echo '<h2>Input Error</h2><p class="error">The number entered should be 10 digits. Please try again.</p><p class="entered">You entered: ' . $serial . '</p>' . $returnbutton;
                                else:

                                    // Calculation for 800/900 models
                                    if ($serialmodel == 66371 || $serialmodel == 66417):

                                        $firstin = substr($serialclean, 4, 2);
                                        $secondin = substr($serialclean, 6, 2);
                                        $thirdin = substr($serialclean, 8, 2);

                                        // Apply math to the first, second and third sets
                                        $firstout = $firstin * 8;
                                        $secondout = $secondin * 15;
                                        $thirdout = $thirdin * 42;

                                        // Combine the three sets back together
                                        $combined = $firstout . $secondout . $thirdout;

                                        // Check the number of digits in the combined set
                                        $check = strlen((string)$combined);

                                        // Append the correct combination to the check
                                        if ($check == 10):
                                            $pretotal = $combined . "51015";
                                        elseif ($check ==9):
                                            $pretotal = $combined . "612182";
                                        elseif ($check ==8):
                                            $pretotal = $combined . "7142128";
                                        else:
                                            echo '<h2>Password Error</h2><p class="error">You\'ve encountered an unusual serial number that doesn\'t process correctly.</p><p>Please utilize the Service User password if available. If no password is available, contact the main office.</p>' . $returnbutton;
                                        endif;

                                        $total = substr($pretotal, 0, 5) . '-' . substr($pretotal, 5, 5) . '-' . substr($pretotal, 10, 5);

                                        echo '<p class="entered">You entered: ' . $serial . '</p><p>Password:</p>' . '<h2 class="total">' . $total . '</h2>' . $returnbutton;


                                    // Calculation for all other models
                                    elseif ($serialmodel == 66314):

                                        $firstin = substr($serialclean, 5, 1);
                                        $secondin = substr($serialclean, 6, 2);
                                        $thirdin = substr($serialclean, 8, 2);

                                        // Assign the correct number to the first set
                                        if ($firstin == 0):
                                            $firstout = 320;
                                        elseif ($firstin == 2):
                                            $firstout = 336;
                                        elseif ($firstin == 4):
                                            $firstout = 352;
                                        elseif ($firstin == 6):
                                            $firstout = 368;
                                        elseif ($firstin == 8):
                                            $firstout = 384;
                                        else:
                                            echo '<h2>Input Error</h2><p class="error">Your sixth digit entered should be a 0, 2, 4, 6 or 8.</p><p class="entered">You entered: ' . $serial . '</p>' . $returnbutton;
                                        endif;

                                        // Verify sixth digit is 0, 2, 4, 6, or 8
                                        if ($firstin == 0 || $firstin == 2 || $firstin == 4 || $firstin == 6 || $firstin == 8):

                                            // Apply math to the second and third sets
                                            $secondout = $secondin * 15;
                                            $thirdout = $thirdin * 42;

                                            // Combine the three sets back together
                                            $combined = $firstout . $secondout . $thirdout;

                                            // Check the number of digits in the combined set
                                            $check = strlen((string)$combined);

                                            // Append the correct combination to the check
                                            if ($check == 10):
                                                $pretotal = $combined . "51015";
                                            elseif ($check == 9):
                                                $pretotal = $combined . "612182";
                                            elseif ($check == 8):
                                                $pretotal = $combined . "7142128";
                                            else:
                                                echo '<h2>Password Error</h2><p class="error">You\'ve encountered an unusual serial number that doesn\'t process correctly.</p><p>Please utilize the Service User password if available. If no password is available, contact the main office.</p>' . $returnbutton;
                                            endif;

                                            if ($check == 10 || $check == 9 || $check == 8):

                                                $total = substr($pretotal, 0, 5) . '-' . substr($pretotal, 5, 5) . '-' . substr($pretotal, 10, 5);
                                                echo '<p class="entered">You entered: ' . $serial . '</p><p>Password:</p>' . '<h2 class="total">' . $total . '</h2>' . $returnbutton;

                                            endif;

                                    endif;

                                    // Error message if serial doesn't match any model
                                    else:
                                        echo '<h2>Password Error</h2><p class="error">This doesn\'t appear to be a valid serial number. The serial number should begin with the digits 66314, 66371 or 66417.</p><p>Please utilize the Service User password if available. If no password is available, contact the main office.</p>' . $returnbutton;
                                    endif;

                                endif;

                            endif;

                        else: ?>
                            <h1>Password Generator</h1>
                            <div class="password-form">
                                <form action="" method="GET">
                                    <div class="serial">
                                        <label>Enter Serial Number</label>
                                        <input type="text" name="serial" value="">
                                    </div>
                                    <div class="submit">
                                        <input type="submit" value="Generate Password">
                                    </div>
                                </form>
                            </div>
                        <?php endif;?>
                    <?php else: ?>
                        <h1>Log In</h1>
                        <p>You must be logged in to view this page.</p>
                        <div class="login-form">
                            <?php
                                $loginargs = array(
                                    'echo'           => true,
                                    'redirect'       => site_url($_SERVER['REQUEST_URI']),
                                    'label_username' => __( 'Username' ),
                                    'label_password' => __( 'Password' ),
                                    'label_remember' => __( 'Remember Me' ),
                                    'remember'       => true,
                                    'value_username' => NULL,
                                    'value_remember' => true
                                );
                                wp_login_form($loginargs);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

<?php endwhile; ?>

<?php wp_footer(); ?>

</body>
</html>
