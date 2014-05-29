<?php
/*
Plugin Name: Exit Pop widget for WP
Plugin URI: http://www.storeya.com/public/exitpop
Description: A plugin that converts your visitor when they show intent of abandoning your site by offering targeted promotions.
Version: 1.1
Author: StoreYa
Author URI: http://www.storeya.com/

=== VERSION HISTORY ===
01.11.13 - v1.0 - The first version

=== LEGAL INFORMATION ===
Copyright © 2013 StoreYa Feed LTD - http://www.storeya.com/

License: GPLv2 
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

$plugurldir = get_option('siteurl') . '/' . PLUGINDIR . '/storeya-exit-pop/';
$sep_domain = 'StoreYaExitPop';
add_action('init', 'sep_init');
add_action('wp_footer', 'sep_insert');
add_action('admin_notices', 'sep_admin_notice');
add_filter('plugin_action_links', 'sep_plugin_actions', 10, 2);

function sep_init()
{
    if (function_exists('current_user_can') && current_user_can('manage_options'))
        add_action('admin_menu', 'sep_add_settings_page');
    if (!function_exists('get_plugins'))
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $options = get_option('scpDisable');
}
function sep_settings()
{
    register_setting('storeya-exit-pop-group', 'sepID');
    register_setting('storeya-exit-pop-group', 'scpDisable');
    add_settings_section('storeya-exit-pop', "StoreYa Exit Pop", "", 'storeya-exit-pop-group');

}
function sep_plugin_get_version()
{
    if (!function_exists('get_plugins'))
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
    $plugin_file   = basename((__FILE__));
    return $plugin_folder[$plugin_file]['Version'];
}
function sep_insert()
{
    global $current_user;
    if (get_option('sepID')) {
            
        $script = str_replace("\"","\"",get_option('sepID'));
        echo $script; 
    }
}

function sep_admin_notice()
{
    if (!get_option('sepID'))
        echo ('<div class="error"><p><strong>' . sprintf(__('StoreYa Exit Pop  is disabled. Please go to the <a href="%s">plugin page</a> and enter a valid Exit Pop script to enable it.'), admin_url('options-general.php?page=storeya-exit-pop')) . '</strong></p></div>');
}
function sep_plugin_actions($links, $file)
{
    static $this_plugin;
    if (!$this_plugin)
        $this_plugin = plugin_basename(__FILE__);
    if ($file == $this_plugin && function_exists('admin_url')) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=storeya-exit-pop') . '">' . __('Settings', $sep_domain) . '</a>';
        array_unshift($links, $settings_link);
    }
    return ($links);
}

    function sep_add_settings_page()
    {
        function sep_settings_page()
        {
            global $sep_domain, $plugurldir, $storeya_options;
?>
      <div class="wrap">
        <?php
            screen_icon();
?>
        <h2><?php
            _e('StoreYa Exit Pop ', $sep_domain);
?> <small><?
            echo sep_plugin_get_version();
?></small></h2>
        <div class="metabox-holder meta-box-sortables ui-sortable pointer">
          <div class="postbox" style="float:left;width:30em;margin-right:20px">
            <h3 class="hndle"><span><?php
            _e('StoreYa Exit Pop  - Settings', $sep_domain);
?></span></h3>
            <div class="inside" style="padding: 0 10px">
              <p style="text-align:center"><a href="http://www.storeya.com/public/exitpop" target="_blank" title="<?php
            _e('Convert your visitors to paying customers with StoreYa!', $sep_domain);
?>"><img src="<?php
            echo (plugins_url( 'storeya_exit_pop.png', __FILE__ ));
?>" height="200" width="200" alt="<?php
            _e('StoreYa Logo', $sep_domain);
?>" /></a></p>
              <form method="post" action="options.php">
                <?php
            settings_fields('storeya-exit-pop-group');
?>
                <p><label for="sepID"><?php
            printf(__('
Enter Exit Pop script you got from %1$sIncrease your online sales today with StoreYa!%2$sStoreYa%3$s.', $sep_domain), '<strong><a href="http://www.storeya.com/public/exitpop" target="_blank"  title="', '">', '</a></strong>');
?></label></p>

                  <p><textarea rows="11" cols="42" name="sepID" ><?php echo get_option('sepID');?></textarea></p>
                    <p class="submit">
                      <input type="submit" class="button-primary" value="<?php
            _e('Save Changes');
?>" />
                    </p>
                  </form>
</p>
                  <p style="font-size:smaller;color:#999239;background-color:#ffffe0;padding:0.4em 0.6em !important;border:1px solid #e6db55;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px"><?php
            printf(__('Don&rsquo;t have a Exit Pop? No problem! %1$sKeep your visitors engaged with you in all social networks you are active on!%2$sCreate a <strong>FREE</strong> StoreYa Exit Pop  Now!%3$s', $sep_domain), '<a href="http://www.storeya.com/public/exitpop" target="_blank" title="', '">', '</a>');
?></p>
                  </div>
                </div>

                </div>
              </div>			 
			  <img src="http://www.storeya.com/widgets/admin?p=WpExitPop"/>
              <?php
        }
        add_action('admin_init', 'sep_settings');
        add_submenu_page('options-general.php', __('StoreYa Exit Pop ', $sep_domain), __('StoreYa Exit Pop ', $sep_domain), 'manage_options', 'storeya-exit-pop', 'sep_settings_page');
    }

?>