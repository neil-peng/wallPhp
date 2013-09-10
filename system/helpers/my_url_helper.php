<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('css_url'))
{
	function css_url($uri = '')
 	{
 		$CI =&get_instance();
 		$css_string= $CI->config->base_url("/public/css/".$uri);
 		echo $css_string;
 	}
}

if ( ! function_exists('js_url'))
{
 	function js_url($uri = '')
 	{
 		$CI =&get_instance();
 		$javascript_string = $CI->config->base_url("/public/js/".$uri);
 		echo $javascript_string;
	}
}

if ( ! function_exists('img_url'))
{
 	function img_url($uri = '')
 	{
 		$CI =&get_instance();
 		$img_string = $CI->config->base_url("/relData/baseImg/".$uri);
 		return $img_string;
	}
}



?>