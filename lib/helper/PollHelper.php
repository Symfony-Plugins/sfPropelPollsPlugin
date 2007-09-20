<?php
/**
 * Get the bar width corresponding to a poll vote performance 
 * 
 * @param  int  $percent
 * @return string
 */
function poll_get_bar_width($percent)
{
  $percent = (int) $percent;
  $max_bar_width = sfConfig::get('app_sfPolls_bar_max_width', 400);
  return $max_bar_width / 100 * $percent;
}