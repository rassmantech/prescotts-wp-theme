<?php
/***
 * Prescott Exchange Functions
 * @package prescotts
*
**/

// Html2PDF utility ============================================================
// See https://github.com/spipu/html2pdf for details

require get_template_directory() . '/inc/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

function prescott_create_pdf($html) {
    $html2pdf = new Html2Pdf('P','USLETTER','en', false, 'UTF-8', array(16, 16, 16, 16));
    $output = '<h1>ERROR</h1>There has been a problem, please go back and try again.';
    !empty($html) ? $output = $html : $output;
    $html2pdf->writeHTML($output);
    return $html2pdf->output();
}


// New Exchange Form to add to DB ============================================================
function prescotts_new_exchange_form($postVal) {

// Get values
    $order_date_stamp = date('U', strtotime('now'));
    $order_date = date('m-d-Y', strtotime('now'));
    $business_works = sanitize_text_field($postVal['businessWorks']);
    $part_type = sanitize_text_field($postVal['partType']);
    $customer_account = sanitize_text_field($postVal['customerAccount']);
    $facility_name = sanitize_text_field($postVal['facilityName']);
    $mailing_address = sanitize_text_field($postVal['mailingAddress']);
    $mailing_city = sanitize_text_field($postVal['mailingCity']);
    $mailing_state = sanitize_text_field($postVal['mailingState']);
    $mailing_zip = sanitize_text_field($postVal['mailingZip']);
    $biomed_name = sanitize_text_field($postVal['biomedName']);
    $biomed_phone = sanitize_text_field($postVal['biomedPhone']);
    $biomed_email = sanitize_text_field($postVal['biomedEmail']);
    $rep_name = sanitize_text_field($postVal['repName']);
    $rep_email = sanitize_email($postVal['repEmail']);
    $rep_region = sanitize_text_field($postVal['repRegion']);

    function filter_post($str, $post_array){
        $array = array_filter($post_array, function ($key) use ($str)
        {
            if (stripos($key, $str) !== false)
            {
                return $key;
            }
        }, ARRAY_FILTER_USE_KEY);
        return $array;
    }

    // Gather POST vals that start with part string
    $part_quantity_array = filter_post('partQty', $postVal);
    $part_number_array = filter_post('partNumber', $postVal);
    $part_description_array = filter_post('partDescription', $postVal);

    // Get keys of each part array
    $quantity_keys = array_keys($part_quantity_array);
    $number_keys = array_keys($part_number_array);
    $description_keys = array_keys($part_description_array);

    // Insert into DB
    $i = 0;
    foreach ($part_quantity_array as $part => $val) {

        // Use keys to reference arrays
        $q_key = $quantity_keys[$i];
        $n_key = $number_keys[$i];
        $d_key = $description_keys[$i];

        $part_quantity = $part_quantity_array[$q_key];
        $part_number = $part_number_array[$n_key];
        $part_description = $part_description_array[$d_key];

        // Create table
        global $wpdb;
        $dbname = $wpdb->dbname;
        $charset_collate = $wpdb->get_charset_collate();
        $table = "wp_exchanges";

        $sql = "CREATE TABLE IF NOT EXISTS $table (
        `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
        `order_date_stamp` LONGTEXT NOT NULL,
        `order_date` LONGTEXT NOT NULL,
        `business_works` LONGTEXT NOT NULL,
        `customer_account` LONGTEXT NOT NULL,
        `facility_name` VARCHAR(255) NOT NULL,
        `mailing_address` LONGTEXT NOT NULL,
        `mailing_city` LONGTEXT NOT NULL,
        `mailing_state` LONGTEXT NOT NULL,
        `mailing_zip` LONGTEXT NOT NULL,
        `biomed_name` LONGTEXT NOT NULL,
        `biomed_phone` LONGTEXT NOT NULL,
        `biomed_email` LONGTEXT NOT NULL,
        `rep_name` LONGTEXT NOT NULL,
        `rep_email` LONGTEXT NOT NULL,
        `rep_region` LONGTEXT NOT NULL,
        `part_quantities` LONGTEXT NOT NULL,
        `part_numbers` LONGTEXT NOT NULL,
        `part_descriptions` LONGTEXT NOT NULL,
        `status` LONGTEXT NOT NULL,
        `archived` TINYTEXT NOT NULL,
        UNIQUE (`id`)
        ) $charset_collate;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        // Insert into table
        $data = array(
            'order_date_stamp' => $order_date_stamp,
            'order_date' => $order_date,
            'business_works' => $business_works . '-' . $part_type,
            'customer_account' => $customer_account,
            'facility_name' => $facility_name,
            'mailing_address' => $mailing_address,
            'mailing_city' => $mailing_city,
            'mailing_state' => $mailing_state,
            'mailing_zip' => $mailing_zip,
            'biomed_name' => $biomed_name,
            'biomed_phone' => $biomed_phone,
            'biomed_email' => $biomed_email,
            'rep_name' => $rep_name,
            'rep_email' => $rep_email,
            'rep_region' => $rep_region,
            'part_quantities' => $part_quantity,
            'part_numbers' => $part_number,
            'part_descriptions' => $part_description,
            'status' => 'Shipped',
            'archived' => 'false',
        );

        $wpdb->insert($table, $data);

        prescotts_build_qr($business_works . '-' . $part_type);

        // Get row count, set to ID and send a notif
        $ID = $wpdb->query("SELECT * FROM ".$dbname.".wp_exchanges");
        $data_id = $data;
        $data_id['ID'] = $ID;
        prescotts_send_initial_notification($data_id);

        $i++;
    }

    return $data;
}

// Returns site url and protocol for PDF based linking ============================================================
function siteURL() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}

// Builds QR code for PDF ==================================================================
use Endroid\QrCode\QrCode;
function prescotts_build_qr($id) {
    $qrCode = new QrCode(siteURL().'exchange/exchange-order-viewer/?id='.$id);
    $uploads = wp_upload_dir();
    header('Content-Type: '.$qrCode->getContentType());
    error_log('created '.$uploads['basedir'].'/qr/'.$id.'.png');
    error_log('location: '. $uploads['baseurl'] . '/qr/' . $id . '.png');
    $qrCode->writefile($uploads['basedir'].'/qr/'.urlencode($id).'.png');
    return $uploads['baseurl'].'/qr/'.$id.'.png';
}

// Builds HTML for PDF ==================================================================
function prescotts_build_html($post_array, $parts_body) {
    $uploads = wp_upload_dir();
    $qr_url = $uploads['baseurl'] . '/qr/' . urlencode($post_array['business_works']) . '.png';
    $order_date = str_replace('-','/',$post_array['order_date']);
    $return_date = date('m-d-Y', strtotime('+30 days', strtotime($order_date)));

    $html = '
    <style type="text/css">
        h1 { font-size: 22px; margin: 0; padding: 0; }
        h2 { font-size: 19px; margin: 0; padding: 0; }
        h3 { font-size: 13px;    margin: 0 0 5px 0; padding: 0; }
        p { margin: 0 0 10px 0; padding: 0; line-height: 1.4; font-size: 10px; }
        td { font-size: 10px; line-height: 1.4; }
        .callout { padding: 12px 0px; background: #005F9E; text-align: center; }
        .callout h2 { color: #fff; margin: 0; }
        .logo { padding-top: 40px; width: 80%; }
        .contact { padding-top: 40px; width: 20%; }
        .title { padding-top: 25px; padding-bottom: 20px; }
        .top-info { border: 1px solid #ccc; width: 44%; }
        .top-info-label { background: #eee; padding: 6px; width: 45%; border-bottom: 1px solid #ccc; font-weight: bold; }
        .top-info-content { width: 55%; padding: 6px; border-bottom: 1px solid #ccc; }
        .top-policy { border: 1px solid #ccc; border-left: 0px; width: 28%; padding: 10px; }
        .date { width: 100%; padding: 10px 8px 5px 8px; background: #005F9E; color: #fff; font-weight: border: 0px; bold; text-align: center; }
        .date p { font-weight: bold; font-size: 10px; margin-bottom: 2px; }
        .date h3 { color: #fff; font-size: 20px; margin: 0; }
        .top-internal { border: 1px solid #ccc; border-left: 0px; width: 28%; padding: 10px; text-align: center; }
        .number-label { margin-bottom: 0; }
        .number { margin-bottom: 10px; }
        .parts-table { padding-top: 25px; }
        .parts th { font-weight: bold; padding: 6px; color: #fff; background: #3B4652; border: 0; }
        .parts td { padding: 6px; border-bottom: 1px solid #ccc; border-left: 1px solid #ccc; }
        .parts td.part-problem { padding: 0; border-right: 1px solid #ccc; }
        .parts td.part-problem table td { border: none; font-size: 10px; }
        .parts td.part-problem td.box { padding: 0 4px; border: 1px solid #777; }
        .parts td.part-problem td.label { padding: 0 10px 0 3px; color: #777; }
        .parts-notes { padding-top: 20px; }
        .notes td { border-bottom: 1px solid #ccc; height: 20px; }
        .footer { padding-left: 10px; font-weight: bold; }
    </style>
    <page>
        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="callout" style="width:100%;">
                    <h2>Include this sheet with your returned parts</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td class="logo" valign="top">
                                <img src="' . siteURL() . 'wp-content/themes/prescotts/img/prescotts-logo.png" width="240" />
                            </td>
                            <td class="contact" valign="top">
                                <h3>Prescott\'s Inc.</h3>
                                <p style="margin-bottom:5px;>18940 Microscope Way<br />
                                Monument, CO, 80132<br />
                                800-438-3937 <span>Tel</span><br />
                                719-488-2268 <span>Fax</span></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="title">
                    <h1>Exchange Parts Return Form</h1>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td class="top-info" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td class="top-info-label">Order Date:</td>
                                        <td class="top-info-content">' . $post_array['order_date'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Business Works S/O#:</td>
                                        <td class="top-info-content">' . $post_array['business_works'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Customer Account#:</td>
                                        <td class="top-info-content">' . $post_array['customer_account'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Facility Name:</td>
                                        <td class="top-info-content">' . $post_array['facility_name'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Mailing Address:</td>
                                        <td class="top-info-content">
                                                ' . $post_array['mailing_address'] . '<br />
                                                ' . $post_array['mailing_city'] . ', ' . $post_array['mailing_state'] . ' ' . $post_array['mailing_zip'] . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Biomed Name:</td>
                                        <td class="top-info-content">' . $post_array['biomed_name'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Biomed Phone:</td>
                                        <td class="top-info-content">' . $post_array['biomed_phone'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Biomed Email:</td>
                                        <td class="top-info-content">' . $post_array['biomed_email'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label">Prescott\'s Rep:</td>
                                        <td class="top-info-content">' . $post_array['rep_name'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="top-info-label" style="border-bottom: 0;">Rep Email:</td>
                                        <td class="top-info-content" style="border-bottom: 0">' . $post_array['rep_email'] . '</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="top-policy" valign="top">
                                <h3>Exchange Parts Policy:</h3>
                                <p>Exchange parts must be returned within 30 days of original invoice date. You must include a copy of Exchange Parts Return Form with returned parts. If exchange parts are not received within 30 days of initial order Customer will be charged "FULL RETAIL PRICE" of the part purchased.</p>
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td class="date">
                                        <p>For full credit, exchange parts must be returned by:</p>
                                        <h3>' . $return_date . '</h3>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="top-internal" valign="top">
                                <p>For internal use:</p>
                                <p class="number-label"><strong>Exchange Number:</strong></p>
                                <h2 class="number">' . $post_array['business_works'] . '</h2>
                                <img src="' . $qr_url . '" width="150" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="parts-table">
                    <table class="parts" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                            <tr>
                                <th style="width:5%;">Qty</th>
                                <th style="width:25%;">Part#</th>
                                <th style="width:70%;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . $parts_body . '
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="parts-notes">
                    <p style="margin-bottom: 0;"><strong>Part Failure Details:</strong></p>
                    <table class="notes" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                            <tr><td style="width: 100%;"></td></tr>
                            <tr><td style="width: 100%;"></td></tr>
                            <tr><td style="width: 100%;"></td></tr>
                            <tr><td style="width: 100%;"></td></tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <page_footer>
            <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td class="bug" valign="middle">
                        <img src="'.siteURL().'/wp-content/themes/prescotts/img/iso-13485-bug.png" width="60" />
                    </td>
                    <td class="footer" valign="middle">
                        Thanks you for choosing Prescott\'s Inc!
                    </td>
                </tr>
            </table>
        </page_footer>
    </page>
    ';
    return $html;
}

function prescotts_get_post_array($id) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE business_works="'.$id.'"');
    prescotts_build_qr($id);
    return get_object_vars($result[0]);
}


function get_order_status($id) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE business_works="'.$id.'"');
    $container = '<table class="order-status"><tr>';
    $active_rows = '';
    $inactive_rows = '';
    for ($i=0; $i < count($result); $i++) {
        if ($result[$i]->status=='Complete') {
            $active_rows .= '<td class="status-active">&nbsp;</td>';
        } else {
            $inactive_rows .= '<td class="status-inactive">&nbsp;</td>';
        }
    }
    $container .= $active_rows . $inactive_rows . '</tr></table>';
    return $container;
}


// Builds pagination ============================================================
function build_exchange_pagination($total, $page_size) {
  $total_pages = ceil($total / $page_size);

  $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $page = 1;
  $page_query_var = get_query_var('expage');
  if ($page_query_var) {
    $page = $page_query_var;
  }

  $output = '';
  $output .= '<div class="exchange-pagination">';
  $output .= '  <ul>';

  if ($page > 1) {
    $output .= '    <li class="prev"><a href="' . $url . '?expage=' . ($page - 1) . '">&laquo;</a></li>';
  }

  if ($page > 4) {
    $output .= '    <li><a href="' . $url . '?expage=1">1</a></li>';
  }

  if ($page > 5) {
    $output .= '    <li class="dots">...</li>';
  }

  if ($page - 3 > 0) {
    $output .= '    <li><a href="' . $url . '?expage=' . ($page - 3) . '">' . ($page - 3) . '</a></li>';
  }
  if ($page - 2 > 0) {
    $output .= '    <li><a href="' . $url . '?expage=' . ($page - 2 ). '">' . ($page - 2 ). '</a></li>';
  }
  if ($page - 1 > 0) {
    $output .= '    <li><a href="' . $url . '?expage=' . ($page - 1) . '">' . ($page - 1) . '</a></li>';
  }

  $output .= '    <li><span>' . $page . '</span></li>';

  if ($page + 1 < ($total_pages + 1)) {
    $output .= '    <li><a href="' . $url . '?expage=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';
  }
  if ($page + 2 < ($total_pages + 1)) {
    $output .= '    <li><a href="' . $url . '?expage=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
  }
  if ($page + 3 < ($total_pages + 1)) {
    $output .= '    <li><a href="' . $url . '?expage=' . ($page + 3) . '">' . ($page + 3) . '</a></li>';
  }

  if ($page < ($total_pages - 4)) {
    $output .= '    <li class="dots">...</li>';
  }

  if ($page < $total_pages - 3) {
    $output .= '    <li><a href="' . $url . '?expage=' . $total_pages . '">' . $total_pages . '</a></li>';
  }

  if ($page < $total_pages) {
    $output .= '    <li class="next"><a href="' . $url . '?expage=' . ($page + 1) . '">&raquo;</a></li>';
  }

  $output .= '  </ul>';
  $output .= '</div>';

  return $output;
}


// Returns active orders ============================================================
function get_exchanges($region, $status) {
    global $wpdb;
    $dbname = $wpdb->dbname;

    $page_size = 50;
    $current_page = get_query_var('expage');

    $sql = 'SELECT * FROM wp_exchanges';
    $total_sql = 'SELECT COUNT(DISTINCT business_works) FROM wp_exchanges';

    if ($status == 'active') {
      $sql .= ' WHERE status<>"Complete"';
      $total_sql .= ' WHERE status<>"Complete"';
    } else {
      $sql .= ' WHERE status="Complete"';
      $total_sql .= ' WHERE status="Complete"';
    }

    if ($region && $region != '') {
      $sql .= ' AND rep_region="' . $region . '"';
      $total_sql .= ' AND rep_region="' . $region . '"';
    }

    $sql .= ' GROUP BY business_works ORDER BY order_date_stamp DESC LIMIT ' . $page_size;

    if ($current_page) {
      $offset = $page_size * ($current_page - 1);
      $sql .= ' OFFSET ' . $offset;
    }

    $rows = $wpdb->get_results($sql);
    $total_rows = $wpdb->get_var($total_sql);

    return [
      'rows' => $rows,
      'total' => $total_rows,
      'page_size' => $page_size,
    ];
}

function get_active_requests($region) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    if ($region):
        $result = $wpdb->get_results('SELECT * FROM ' . $dbname . '.wp_exchanges WHERE status<>"Complete" AND rep_region="'.$region.'"');
    else:
        $result = $wpdb->get_results('SELECT * FROM ' . $dbname . '.wp_exchanges WHERE status<>"Complete"');
    endif;

    return $result;
}

// Creates Parts Array Body for PDF ============================================================
function parts_array_body_pdf($post_array) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE business_works="'.$post_array['business_works'].'"');
    $body = '';

    for($i=0; $i<count($result); $i++){
        //hide update on completed orders

        $body .= '<tr class="row" data-id="'.$result[$i]->ID.'">
                    <td style="border-bottom: none;">' . $result[$i]->part_quantities . '</td>
                    <td>' . $result[$i]->part_numbers . '</td>
                    <td style="border-right: 1px solid #ccc;">' . $result[$i]->part_descriptions . '</td>
                </tr>
                <tr class="row">
                    <td></td>
                    <td colspan="2" class="part-problem">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td><table><tr><td class="box"></td><td class="label">NEW Part Unused</td></tr></table></td>
                                <td><table><tr><td class="box"></td><td class="label">NEW Part Used for Testing</td></tr></table></td>
                                <td><table><tr><td class="box"></td><td class="label">Exchange Part Damaged</td></tr></table></td>
                                <td><table><tr><td class="box"></td><td class="label">Exchange Part Intermittent Failure</td></tr></table></td>
                            </tr>
                        </table>
                    </td>
                </tr>';
    }

    return $body;
}

// Creates Parts Array Body for tables ============================================================
function parts_array_body($post_array, $role) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE business_works="'.$post_array['business_works'].'"');
    $body = '';

    for ($i=0; $i<count($result); $i++) {
        //hide update on completed orders
        $result[$i]->status !== 'Complete' ? $update = '<a class="update" href="#">Update</a>': $update='<a class="update" href="#">Un-archive</a>';

        $body .= '<tr class="row" data-id="'.$result[$i]->ID.'">
                    <td>' . $result[$i]->part_quantities . '</td>
                    <td>' . $result[$i]->part_numbers . '</td>
                    <td>' . $result[$i]->part_descriptions . '</td>
                    <td class="status">' . $result[$i]->status . '</td>';
                    if ($role != 'Regional Manager'):
                        $body .= '<td class="actions">
                            '.$update.'
                        </td>';
                    endif;
                $body .= '</tr>';
    }

    return $body;
}

// Creates Parts Array Body for tables ============================================================
function parts_array_body_email($post_array) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE ID="'.$post_array['ID'].'"');
    $body = '';

    for ($i=0; $i<count($result); $i++) {
        //hide update on completed orders
        $body .= '<tr class="row" data-id="'.$result[$i]->ID.'">
                    <td>' . $result[$i]->part_quantities . '</td>
                    <td>' . $result[$i]->part_numbers . '</td>
                    <td>' . $result[$i]->part_descriptions . '</td>
                    <td class="status">' . $result[$i]->status . '</td>
                </tr>';
    }

    return $body;
}


// Returns parts associated with BW order
function exchange_part_query($id, $role) {
global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE business_works="'.$id.'"');
    $parts = parts_array_body(get_object_vars($result[0]), $role);

    return $parts;
}




// Returns single order to be updated ========================================================
function update_query($id) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE business_works="'.$id.'"');
    $body = '';
    $body = '<div id="exchange-update" data-id="'.$id.'" data-status="'.$result[0]->status.'">
        <a class="button" data-status="Shipped" href="#">Parts Shipped</a>
        <a class="button" data-status="Shipped Back" href="#">Parts Shipped Back</a>
        <a class="button" data-status="Received" href="#">Parts Received</a>
        <a class="button" data-status="Complete" href="#">Exchange Complete</a>
    </div>';
    return $body;
}

// Checks for archivable content ========================================================
function archive_check($id) {
    global $wpdb;
    $dbname = $wpdb->dbname;
    //get bw number by part ID
    $query_array = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE ID="'.$id.'"');
    $bw_number = $query_array[0]->business_works;

    //get bw number rows and filter by not complete
    $bw_array = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE business_works="'.$bw_number.'"');

    function find_complete($val){
        $status = $val->status;
        return ($status !== 'Complete');
    }

    $filtered = array_filter($bw_array, 'find_complete');

    $count = count($filtered);
    //update all to archived if all complete
    if ($count == 0) {
        $update = $wpdb->query("UPDATE ".$dbname.".wp_exchanges SET archived='true' WHERE business_works='".$bw_number."';");
    } else {
        $update = $wpdb->query("UPDATE ".$dbname.".wp_exchanges SET archived='false' WHERE business_works='".$bw_number."';");
    }

}


// Updates item status ========================================================
function prescott_update_exchange_status() {
    // check_ajax_referer('prescott_nonce', 'security');
    $id = sanitize_text_field($_POST['data']['id']);
    $status = sanitize_text_field($_POST['data']['status']);
    global $wpdb;
    $dbname = $wpdb->dbname;
    $resp = $wpdb->query("UPDATE ".$dbname.".wp_exchanges SET status = '".$status."' WHERE ID='".$id."';");
    archive_check($id);
    echo 'Success!';
    wp_die();
}
add_action('wp_ajax_prescott_update_exchange_status', 'prescott_update_exchange_status');
add_action('wp_ajax_nopriv_prescott_update_exchange_status', 'prescott_update_exchange_status');

// Set custom query var for exchange id ============================================================
function custom_query_vars_filter($vars) {
    $vars[] .= 'id';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars_filter');



// Pulls incomplete orders, builds csv and mails it ============================================================
function prescott_incomplete_order_report() {
    //get incomplete orders
    global $wpdb;
    $dbname = $wpdb->dbname;

    // Get all regional manager users
    //
    //
    // foreach ($managers as $manager):
    //     $region = $manager->$rep_region;
    //     $incomplete = $wpdb->get_results('SELECT * FROM '.$dbname.'.wp_exchanges WHERE status<>"Complete" AND rep_region="'.$region.'"');
    //
    // endforeach;


    // Get all users w/role of regional managers
    $managerargs = array(
        'role' => 'regional_manager',
    );
    $managers = get_users($managerargs);

    // Loop through manager managers
    foreach ($managers as $manager):

        // Get the manager region
        $region = get_user_meta($manager->ID, 'region', true);
        // Set variable for manager email address
        $manager_email = $manager->user_email;
        // Set variable for manager username
        $manager_login = $manager->user_nicename;

        // Query through wp_exchanges table to find exchanges that are active and in the user's region
        $incomplete = $wpdb->get_results('SELECT * FROM ' . $dbname . '.wp_exchanges WHERE status<>"Complete" AND rep_region="' . $region . '"');

        // Create CSV file
        $uploads = wp_upload_dir();
        $date_stamp = date('m-d-Y', strtotime('today'));
        $file = $uploads['basedir'] . '/reports/surgicalmicroscopes-incomplete-orders-' . $manager_login  . '-' . $date_stamp . '.csv';
        $csv_url = $uploads['baseurl'] . '/reports/surgicalmicroscopes-incomplete-orders-' . $manager_login  . '-' . $date_stamp . '.csv';
        // Create CSV file on server
        $fp = fopen($file, 'w');
        // Create new empty array
        $csv_fields = array();
        // Defin keys within the array
        $csv_fields[] = 'Exchange Number';
        $csv_fields[] = 'Part Number';
        $csv_fields[] = 'Order Date';
        $csv_fields[] = 'Rep Name';
        $csv_fields[] = 'Order Status';
        // Add the array to the first row of the CSV file
        fputcsv($fp, $csv_fields);
        // Loop through all of the incomplete entries for this region in the wp_exchanges table
        foreach ($incomplete as $fields) {
            // Create an array for each entry
            $fields_array = array(
                $fields->business_works,
                $fields->part_numbers,
                $fields->order_date,
                $fields->rep_name,
                $fields->status
            );
            // Write the entry as a new line in the CSV file
            fputcsv($fp, $fields_array);
        }
        // Close the CSV file
        fclose($fp);

        // Set subject for email
        $subject = 'Your weekly part status report from surgicalmicroscopes.com';
        $email_list = array(
            $manager_email,
            'djdijulio@surgicalmicroscopes.com',
            'jdoldja@surgicalmicroscopes.com'
        );

        // Set content for email
        $admin_message .= '<h2>Weekly Report</h2><p>Hello,<br>Please see your weekly order status report from surgicalmicroscopes.com attached.</p><p><strong><a href="'.$csv_url.'" target="_blank">Or download your CSV file here</a></strong>';

        // Send email using address, subject, message, headers, and file
        wp_mail($email_list, $subject, $admin_message, $headers = "", array($file));

        // Echo function worked correctly
        echo('Email sent to ' . $manager_email . ' with file link: ' . $file);

    endforeach;

    // End function
    wp_die();

}

add_action('wp_ajax_prescott_incomplete_order_report', 'prescott_incomplete_order_report');
add_action('wp_ajax_nopriv_prescott_incomplete_order_report', 'prescott_incomplete_order_report');
