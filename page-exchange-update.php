<?php /* Template Name: Exchange Update */ ?>

<?php get_header('exchange'); ?>

<?php
    $id = get_query_var('id');
    $content = '';
    $content = update_query($id);
?>

<main>
    <div class="content">
        <div class="no-builder">
            <div class="container">
                <div class="twelve columns">
                    <?php if (is_user_logged_in()): ?>
                        <div class ="exchange-update">
                            <div class="row">
                                <h1>Update Status</h1>
                            </div>
                            <?php ?>
                            <div class="row">
                                <?php echo $content; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="exchange-login">
                            <div class="row">
                                <h1>Log In</h1>
                            </div>
                            <div class="row">
                                <h3>You must be logged in to access the Return/Exchange system.</h3>
                                <?php
                                    $loginargs = array(
                                        'echo' => true,
                                        'redirect' => site_url($_SERVER['REQUEST_URI']),
                                        'remember' => true,
                                        'form_id' => 'exchange-login',
                                    );
                                    wp_login_form($loginargs);
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer('exchange'); ?>
