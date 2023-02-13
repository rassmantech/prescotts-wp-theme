<?php

function schedule_reminder_cron(){
    wp_clear_scheduled_hook('prescott_reminder_email');
    wp_schedule_event(time(), 'hourly', 'prescott_reminder_email');
    echo 'Suceess!';
    wp_die();
}

add_action('wp_ajax_schedule_reminder_cron', 'schedule_reminder_cron');
add_action('wp_ajax_nopriv_schedule_reminder_cron', 'schedule_reminder_cron');

function list_reminder_cron(){
    $list = get_option('cron');
    $container = '';
    foreach ($list as $l => $val) {
        if (!empty($list[$l]['prescott_reminder_email'])) {
            $container .= '<strong>Email task: scheduled at ' . date('m-d-Y H:i', $l) . ' </strong>' . print_r($list[$l]['prescott_reminder_email'], 1);
        }
    }
    return $container;
}

function prescott_reminder_email(){
    // Get all exchanges
    global $wpdb;
    $dbname = $wpdb->dbname;
    $result = $wpdb->get_results('SELECT * FROM ' . $dbname . '.wp_exchanges');
    // Loop through exchanges
    for ($i = 0; $i < count($result); $i++) {
        // If date is more than multiple of 7 days, send email
        $order_date = $result[$i]->order_date_stamp;
        $today_formatted = date('m-d-Y', strtotime('now'));
        $today = date('U', strtotime('now'));
        $diff = floor(($today - $order_date) / 86400);
        $hitpoints = [7, 14, 21, 28];
        // Set headers for email sent
        $headers = array(
            'Reply-To: Prescott\'s Surgical Microscopes <jdoldja@surgicalmicroscopes.com>',
        );
        // Get all exchanges with status of shipped
        if($result[$i]->status=='Shipped'){
            if (in_array($diff, $hitpoints)){
                // Set content for email
                $parts_body = parts_array_body_email(get_object_vars($result[$i]));
                $pdf = siteURL().'/exchange/exchange-pdf-viewer/?id='.urlencode($result[$i]->business_works);
                // Set to address for email to rep email address
                $to = $result[$i]->rep_email;
                // If final notice
                $diff == 28 ? $note = 'final' : $note = $diff. ' day';
                $diff == 28 ? $final = '<h2>Final Notice</h2>' : $final = '';
                // Set subject and message
                $subject = 'Your ' . $note . ' reminder from surgicalmicroscopes.com';
                $message = $final.'Hello,<br>This is a friendly reminder that the following exchange part(s) need to be returned. <br>Our records indicate your part(s) shipped '. $diff .' days ago. <br><br>Please return exchange parts within 30 days of the invoice date, exchange parts must be received by Prescott’s no later than the recorded return date on the attached exchange form. When shipping exchange part(s) back please click the link below and print off the Prescott’s part exchange form. <br><br>Please include exchange form in return shipping box with exchange parts. <br><br><span style="text-decoration:underline!important">“All parts MUST be returned with the attached exchange form for returned parts to be received as valid.  If exchange parts are not received within 30 day, you will be billed the full retail price of the parts purchased as per Prescott’s exchange parts policy."</span><br><table border="1" cellpadding="5" style="border:1px solid black; width:100%!important;" width="600"><thead><th>Qty</th><th>Part#</th><th>Description</th><th>Status</th></thead>' . $parts_body . '</table> <br> <a href="'.$pdf.'">View the Exchange</a>';
                // Send email
                wp_mail($to, $subject, $message, $headers, $attachments = array());
                // If final notice
                if($diff==28){
                    $admin_message = '<h2>Notice to Invoice</h2> <p>Hello,<br>This is a friendly reminder that the following exchange part(s) need to be returned. <br>Our records indicate your part(s) shipped '. $diff .' days ago. <br><br>Please return exchange parts within 30 days of the invoice date, exchange parts must be received by Prescott’s no later than the recorded return date on the attached exchange form. When shipping exchange part(s) back please click the link below and print off the Prescott’s part exchange form. <br><br> Please include exchange form in return shipping box with exchange parts. <span style="text-decoration:underline!important">“All parts MUST be returned with the attached exchange form for returned parts to be received as valid.  If exchange parts are not received within 30 day, you will be billed the full retail price of the parts purchased as per Prescott’s exchange parts policy."</span></p> <br><br><table border="1" cellpadding="5" style="border:1px solid black; width:100%!important;" width="600"><thead><th>Qty</th><th>Part#</th><th>sDescription</th><th>Status</th></thead>' . $parts_body . '</table> <br> <a href="'.$pdf.'">View the Exchange</a>';
                    // Send email
                    wp_mail($to, $subject, $admin_message, $headers, $attachments = array());
                }
                error_log("sending email reminder to " . $to . ' on ' . $today_formatted);
            }
        }
    }

    //crontab:  */10 * * * * /usr/local/bin/wget -q -O - http://local.prescott.com/wp-admin/admin-ajax.php?action=prescott_reminder_email
    echo 'hola';
    wp_die();
}

add_action('wp_ajax_prescott_reminder_email', 'prescott_reminder_email');
add_action('wp_ajax_nopriv_prescott_reminder_email', 'prescott_reminder_email');

/**
*
* Sends email to admins once pdf is created
* @package prescotts
*
**/
function prescotts_send_initial_notification($data){
    $today_formatted = date('m-d-Y', strtotime('now'));
    $parts_body = parts_array_body_email($data);
    $pdf = siteURL().'/exchange/exchange-pdf-viewer/?id='.urlencode($data['business_works']);
    $subject = 'A part has been marked shipped on surgicalmicroscopes.com';
    $message = 'Hello,<br> This is a reminder that the following exchange part(s) have been shipped<br><table border="1" cellpadding="5" style="border:1px solid black;width:100%!important;" width="600"><thead><th>Qty</th><th>Part#</th><th>Description</th><th>Status</th></thead>' . $parts_body . '</table> <br> <a href="'.$pdf.'">Link to Part PDF</a>';
    $to = $data['rep_email'];
    $headers = array(
        'Reply-To: Prescott\'s Surgical Microscopes <jdoldja@surgicalmicroscopes.com>',
    );
    error_log($message);
    error_log("sending email reminder to " . $to . ' on ' . $today_formatted);
    wp_mail($to, $subject, $message, $headers, $attachments = array());
}
