<?php

/**
 * Get formatted complate smarty date : YYYY-MM-DD HH:MI:SS
 * @param string $prefix_name
 */
function get_formated_date_from_post($prefix_name)
{
	$CI =& get_instance();
	$post = $CI->input->post();

	return "{$post[$prefix_name.'Year']}-{$post[$prefix_name.'Month']}-{$post[$prefix_name.'Day']} " .
		"{$post[$prefix_name.'HMS']}";
}
