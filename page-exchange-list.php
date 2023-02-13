<?php /* Template Name: Exchange List */ ?>
<?php get_header('exchange'); ?>

<main>
    <div class="content">
        <div class="no-builder">
            <div class="container">
                <div class="twelve columns">
                    <?php if (is_user_logged_in()): ?>
                        <?php
                            $user = wp_get_current_user();
                            $region = '';
                            $user_region = get_user_meta($user->ID, 'region');
                            if ($user_region):
                                $region = $user_region[0];
                            endif;
                            $rows = '';
                            if (is_page('Active')):
                                $rows = active_row_query($region);
                            else:
                                $rows = inactive_row_query($region);
                            endif;
                        ?>
                    <div class="row">
                        <?php if (is_page('Active')): ?>
                        <h1>Active Exchanges</h1>
                        <?php else: ?>
                        <h1>Archived Exchanges</h1>
                        <?php endif; ?>
                        <div class="filter-wrap">
                            <?php if (!in_array('regional_manager', (array) $user->roles)): ?>
                                <select class="region-filter">
                                    <option value="all">- Select Region -</option>
                                    <option value="all">All</option>
                                    <option value="west">West</option>
                                    <option value="midwest">Midwest</option>
                                    <option value="south">South</option>
                                    <option value="northeast">Northeast</option>
                                    <option value="southeast">Southeast</option>
                                    <option value="uk">UK</option>
                                </select>
                            <?php endif; ?>
                            <select class="exchange-filter">
                                <option value="all">- Select Part -</option>
                                <option value="all">All</option>
                                <option value="INV">Inventory Part</option>
                                <option value="BIL">Billable Part</option>
                                <option value="WAR">Warranty Part</option>
                                <option value="SCP">Service Contract Part</option>
                            </select>
                            <?php if (is_page('Active')): ?>
                            <button class="csv-export">Export All to CSV</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <table class="exchange-table" id="list" cellpadding="0" cellspacing="0" border="0" width="100%">
                            <thead>
                                <th>Exchange#</th>
                                <th>Date</th>
                                <th>Rep Name</th>
                                <th>Facility Name</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php echo $rows; ?>
                            </tbody>
                        </table>
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

<script type="text/javascript">

    var activeRequests = [];
    <?php if (is_user_logged_in() && is_page('Active')): ?>
    activeRequests = <?= json_encode(get_active_requests($region)) ?>;
    <?php endif; ?>

    jQuery('.csv-export').click(function() {
        createCSV(activeRequests);
    });

    function createCSV(data) {
        var headerColumns = [
            'business_works',
            'status',
            'order_date',
            'rep_name',
            'rep_region',
            'rep_email',
            'part_numbers',
            'part_quantities',
            'part_descriptions',
            'facility_name',
            'customer_account',
            'biomed_name',
            'biomed_email',
            'biomed_phone',
            'mailing_address',
            'mailing_state',
            'mailing_zip',
        ];

        var columnNamesMap = {
            business_works: 'Exchange #',
            status: 'Status',
            order_date: 'Date',
            rep_name: 'Rep Name',
            rep_region: 'Region',
            rep_email: 'Rep Email',
            part_numbers: 'Part Numbers',
            part_quantities: 'Part Quantities',
            part_descriptions: 'Part Descriptions',
            facility_name: 'Facility Name',
            customer_account: 'Customer Account',
            biomed_name: 'Biomed Name',
            biomed_email: 'Biomed Email',
            biomed_phone: 'Biomed Phone',
            mailing_address: 'Address',
            mailing_state: 'State',
            mailing_zip: 'Zip',
        };

        // Build header row for CSV
        var csvContent = '';
        headerColumns.forEach(function(col, i) {
            csvContent += '"' + columnNamesMap[col] + '",';
            if (i == headerColumns.length - 1) {
                csvContent += '\r\n';
            }
        });


        data.sort(function(a, b) {
          return b.order_date_stamp - a.order_date_stamp;
        });

        // Push exchange rows to csv
        data.forEach(function(row) {
            headerColumns.forEach(function(col, i) {
                var colVal = '';
                if (row[col]) {
                    colVal = row[col];
                }
                // Sanitize double quotes in column strings
                colVal = colVal.replace(/"/g, '""');
                // Wrap all columns in double quotes to preserve commas
                csvContent += '"' + colVal + '",';
                if (i == headerColumns.length - 1) {
                    csvContent += '\r\n';
                }
            });
        });

        // Append link to body, click it and remove it
        var blob = new Blob([csvContent], { type: 'text/csv' });
        var url = window.URL.createObjectURL(blob)
        var link = document.createElement('a')
        link.setAttribute('href', url)
        link.setAttribute('download', 'active-exchanges.csv');
        link.click();
        link.remove();

    }

</script>

<?php get_footer('exchange'); ?>
