<?php
/**
 * @package Wishpond
 */

define('WISHPOND_SITE_URL', 'http://www.wishpond.com');
define('WISHPOND_ADMIN_MENU', 'wishpond-pinterest-menu');
define('WISHPOND_ADMIN_OPTIONS', 'wishpond-pinterest-options');

//Shortcode [wpoffer id="YY" mid="XX" width="810" height="650"]



//Shortcode [wpsweepstakes id="YY" mid="XX" width="810" height="650"]
function wppinteresttab_func($attrs)
{
  extract(shortcode_atts(array(
    'id' => '',
    'mid' => '',
    'width' => '100%',
    'height' => '650'
  ), $attrs));
  
  if($mid=='')
    return "Missing pinterest contest mid";
  else
    return "<iframe width='".$width."' height='".$height."' frameborder='0' src='".WISHPOND_SITE_URL."/pt/".$mid."?container=false&type=Merchant'></iframe>";
}
add_shortcode('wppinterest', 'wppinterest_func');

?>