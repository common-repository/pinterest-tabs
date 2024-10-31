<?php
/**
 * @package Pinteresttab
 */
/*
Plugin Name: Pinterest Tab
Plugin URI: http://corp.wishpond.com/pinterest-tab/
Description: Showcase your boards & pins on your Wordpress site for free. You can also show the plugin on your Facebook fan page as well as mobile website. Can be set up in minutes.
Version: 1.1
Author: Wishpond
Author URI: http://www.wishpond.com
*/

include_once dirname( __FILE__ ) . '/pinterest_tabs_widget.php';
include_once dirname( __FILE__ ) . '/common.php';

/**************
Global
**************/

//Admin Page
function wishpond_pinterest_page()
{
  ob_start();?>
  <div class="wrap">
    <script language="javascript"> 
      function scrollToTop() { 
        scroll(0,0); 
      } 
    </script>
    <?php 
    $current_user = wp_get_current_user();
    $signup_url = WISHPOND_SITE_URL . "/central/merchant_signups/new?type=wp_campaigns&plain=true&referral=wordpress&autologin=true&utm_campaign=campaigns&utm_source=wordpress&utm_medium=pinteresttab&email=" . $current_user->user_email . "&key=" . urlencode(php_uname("n") . site_url()) . "&redirect_to=" . WISHPOND_SITE_URL . "/central/page_tabs";
 /* $signup_url = WISHPOND_SITE_URL . "/central/merchant_signups/new?type=wp_campaigns&plain=true&referral=wordpress&autologin=true&utm_campaign=campaigns&utm_source=wordpress&utm_medium=pinteresttab&email=jordangk@fem.com&key=" . urlencode(php_uname("n") . site_url()) . "&type=pinterest_tab";*/?>
<?php

//echo $signup_url;
?>
    <iframe src="<?php echo $signup_url ?>" width="100%" height="2000" frameBorder="0" onload="scrollToTop()">
    </iframe>
  </div>
  <?php
  echo ob_get_clean();
}

//Admin Tab
function wishpond_pinterest_menu()
{
  add_options_page("Pinterest Tab Options", "Pinterest Tab", "manage_options", WISHPOND_ADMIN_OPTIONS, "wishpond_pinterest_page");
  add_menu_page("Pinterest Tab Options", "Pinterest Tab", "manage_options", WISHPOND_ADMIN_MENU, "wishpond_pinterest_page","",30);
                                            
}
add_action("admin_menu","wishpond_pinterest_menu");

//Add settings menu
function wishpond_pinterest_admin_action_links($links, $file) {
    static $my_plugin;
    if (!$my_plugin) {
        $my_plugin = plugin_basename(__FILE__);
    }
    if ($file == $my_plugin) {
        $settings_link = '<a href="options-general.php?page='. WISHPOND_ADMIN_OPTIONS .'">Settings</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}
add_filter('plugin_action_links', 'wishpond_pinterest_admin_action_links', 10, 2);

//Automatically redirect after activation
register_activation_hook(__FILE__, 'wishpond_pinterest_plugin_activate');
add_action('admin_init', 'wishpond_pinterest_plugin_redirect');

function wishpond_pinterest_plugin_activate() {
  add_option('wishpond_plugin_do_activation_redirect', true);
}

function wishpond_pinterest_plugin_redirect() {
  if (get_option('wishpond_plugin_do_activation_redirect', false)) {
    delete_option('wishpond_plugin_do_activation_redirect');
    wp_redirect('options-general.php?page='. WISHPOND_ADMIN_OPTIONS);
  }
}

//For WP e-commerce
if (is_admin()) {
  function wppinterest_add_modules_admin_pages($page_hooks, $base_page) {
  $page_hooks[] = add_submenu_page($base_page, __('Pinterest Tab','wpsc'), __('Pinterest Tab','wpsc'), 7, 'wishpond-pinterest-menu', 'wpsc_display_admin_pages');
  return $page_hooks;
}
add_filter('wpsc_additional_pages', 'wpsc_add_modules_admin_pages',10, 2);
}
?>