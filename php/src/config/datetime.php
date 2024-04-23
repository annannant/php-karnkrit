<?php
function convertDate($date, $format = 'Y-m-d H:i:s') {
  date_default_timezone_set('UTC');
  $datetime = new DateTime($date);
  $asia_time = new DateTimeZone('Asia/Bangkok');
  $datetime->setTimezone($asia_time);
  return $datetime->format($format);
}
?>
