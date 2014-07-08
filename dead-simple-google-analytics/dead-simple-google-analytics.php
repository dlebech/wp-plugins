<?php
/*
 * Plugin Name: Dead Simple Google Analytics
 * Description: Adds the Google Analytics JavaScript to the Wordpress blog. Support both classic analytics and the newer universal analytics.
 * Version: 1.0
 * Author: David Volquartz Lebech
 * Author URI: https://davidlebech.com
 * License: Public Domain
*/


// Security recommendation from wordpress.org
defined('ABSPATH') or die('No script kiddies please!');

/*
 * Initialize settings for the plugin.
 */
function dsga_init_settings() {
    register_setting('dsga-group', 'dsga_tracking_id');
    register_setting('dsga-group', 'dsga_tracking_type');
    register_setting('dsga-group', 'dsga_tracking_domain');
}

/*
 * Deactivation hook. Un-registers the setting options.
 */
function dsga_unregister_settings() {
    if ( !current_user_can('activate_plugins') )
        return;
    unregister_setting('dsga-group', 'dsga_tracking_id');
    unregister_setting('dsga-group', 'dsga_tracking_type');
    unregister_setting('dsga-group', 'dsga_tracking_domain');
}

/*
 * Initialize within the admin.
 */
function dsga_admin_init() {
    dsga_init_settings();
}

/*
 * Iniatilize the settings menu.
 */
function dsga_add_settings_menu() {
    add_options_page(
        'Dead Simple Google Analytics Settings', 'Dead Simple GA',
        'manage_options', 'dsga_settings', 'dsga_settings_page' );
}

/*
 * Include the settings page if permissions allow.
 */
function dsga_settings_page() {
    if ( !current_user_can('manage_options') ) {
        wp_die(__('No permission to access this page'));
    }

    include(dirname(__FILE__).'/settings.php');
}


function dsga_ga_footer() {
    $ga_id = get_option('dsga_tracking_id');
    // If the tracking id is not present, do nothing
    if ($ga_id != '') {

        // Fetch tracking type and tracking domain.
        $ga_tt = get_option('dsga_tracking_type');
        $ga_domain = get_option('dsga_tracking_domain');

        if ($ga_tt == 'classic') {
            echo "<script type=\"text/javascript\">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '$ga_id']);
_gaq.push(['_trackPageview']);
(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>";
        }
        elseif ($ga_tt == 'universal' && $ga_domain != '') {
            echo "<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', '$ga_id', '$ga_domain');
ga('send', 'pageview');
</script>";

        }
    }
}

// Register options, settings page and the analytics tracking code in the 
// footer.
add_action( 'admin_init', 'dsga_admin_init' );
add_action( 'admin_menu', 'dsga_add_settings_menu' );
add_action( 'wp_footer', 'dsga_ga_footer' );

// Register deactivation hook
register_deactivation_hook( __FILE__, 'dsga_unregister_settings' );

?>
