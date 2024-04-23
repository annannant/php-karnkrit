<?php
function convertDate($date, $format = 'Y-m-d H:i:s') {
  $datetime = new DateTime($date);
  return $datetime->format($format);
}
?>
