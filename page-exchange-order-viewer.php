
<?php get_header('exchange');

$user = wp_get_current_user();
$role = '';
if (in_array('regional_manager', (array) $user->roles)):
    $role = 'Regional Manager';
endif;

$id = sanitize_text_field($_GET['id']);
$rows = exchange_part_query($id, $role);

?>

<main>
    <div class="content">
        <div class="no-builder">
            <div class="container">
                <div class="twelve columns">
                    <?php if (is_user_logged_in()): ?>
                        <div class="row">
                                <h1>Order #<span id="order-id"><?php echo $id;?></span></h1>
                            </div>
                            <div class="row">
                                <table class="exchange-table" id="list" cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <thead>
                                        <th>Quantity</th>
                                        <th>Part Number</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <?php if (!in_array('regional_manager', (array) $user->roles)): ?>
                                            <th><span class="sort-disabled">Actions</span></th>
                                        <?php endif; ?>
                                    </thead>
                                    <tbody>
                                        <?php echo $rows; ?>
                                    </tbody>
                                </table>
                                <div class="exchange-pdf-button">
                                    <a class="fl-button" href="/exchange/exchange-pdf-viewer/?id=<?php echo $id; ?>" target="_blank">View Order PDF</a>
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
