<?php
/**
 *    Takes a $_POST value, adds to the wp_exchanges table,
 *   and returns the data as an array
 *
 **/

$post_array = prescotts_new_exchange_form($_POST);
$parts_body = parts_array_body_pdf($post_array);
$html = prescotts_build_html($post_array, $parts_body);
ob_end_clean();
echo prescott_create_pdf($html);
