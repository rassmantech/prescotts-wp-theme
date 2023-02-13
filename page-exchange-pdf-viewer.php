<?php
/**
 *    Takes a $_GET value, shows pdf
 *
 *
 **/

$post_array = prescotts_get_post_array(sanitize_text_field($_GET['id']));
$parts_body = parts_array_body_pdf($post_array);
$html = prescotts_build_html($post_array, $parts_body);
ob_end_clean();
echo prescott_create_pdf($html);
