<?php
function print_svg($url) {
  $before_wp_content = strstr($url, '/wp-content', false);
  return file_get_contents($_SERVER['DOCUMENT_ROOT'] . $before_wp_content);
}

function cut_p_tags($dirty_html) {
  $nice_html = $dirty_html;
  $nice_html = str_replace("<p>", "", $nice_html);
  $nice_html = str_replace("</p>", "", $nice_html);
  return $nice_html;
}
