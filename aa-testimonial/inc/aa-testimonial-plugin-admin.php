<?php
/**
 * Testimonial Admin Settings & Setup
 * 
 */
if ( !class_exists('Aa_Testimonial_Admin') ) {
    
    class Aa_Testimonial_Admin {

            var $hook       = '';
            var $filename   = '';
            var $longname   = '';
            var $shortname  = '';
            var $ozhicon    = '';
            var $optionname = '';
            var $homepage   = '';       
            var $accesslvl  = 'manage_options';
            var $adminpages = array( 'aa_testimonial');

            function __construct() {
            }

            function config_page_styles() {
                global $pagenow;
                if ( $pagenow == 'admin.php' && isset($_GET['page']) && in_array($_GET['page'], $this->adminpages) ) {
                    wp_enqueue_style('dashboard');
                    wp_enqueue_style('global');
                    wp_enqueue_style('wp-admin');               
                }
            }

            
            function register_settings_page() {                
                add_submenu_page('options-general.php','Case Study Settings','Case Study Settings',$this->accesslvl, 'aa_testimonial_settings', array(&$this,'aa_testimonial_settings'));                   
            }

            function plugin_options_url() {
                return admin_url( 'options-general.php?page=aa_testimonial_settings' );
            }

            /**
             * Add a link to the settings page to the plugins list
             */
            function add_action_link( $links, $file ) {
                static $this_plugin;
                if( empty($this_plugin) ) $this_plugin = $this->filename;
                if ( $file == $this_plugin ) {
                        $settings_link = '<a href="' . $this->plugin_options_url() . '">' . __('AA Case Study Settings') . '</a>';
                        array_unshift( $links, $settings_link );
                }
                return $links;
            }

        
            function config_page_scripts() {
                global $pagenow;

                if ( $pagenow == 'admin.php' && isset($_GET['page']) && in_array($_GET['page'], $this->adminpages) ) {
                    wp_enqueue_script( 'postbox' );
                    wp_enqueue_script( 'dashboard' );
                    // wp_enqueue_script( 'thickbox' );
                }
            }
            
            function on_activate()
            {

                // ATTENTION: This is *only* done during plugin activation hook in this example!
                // You should *NEVER EVER* do this on every page load!!
                flush_rewrite_rules();
            }
            
            
            /**
             * All settings are left, except the username & password            
             */
            function on_deactivate(){

            }

            /**
             * Remove/Delete everything 
             */
            function on_uninstall()
            {
                // important: check if the file is the one that was registered 
                // with the uninstall hook (function)
                if ( __FILE__ != WP_UNINSTALL_PLUGIN )
                    return;

                // delete the stored settings
                delete_option('aa_testimonial_gravity_form');
                delete_option('aa_testimonial_facebook_app_id');
                delete_option('aa_testimonial_use_facebook_open_graph');
                delete_option('aa_testimonial_use_plugin_facebook_js');
                delete_option('aa_testimonial_use_plugin_twitter_js');
            }


            /**
             * trigger_error()
             * 
             * @param (string) $error_msg
             * @param (boolean) $fatal_error | catched a fatal error - when we exit, then we can't go further than this point
             * @param unknown_type $error_type
             * @return void
             */
            function error( $error_msg, $fatal_error = false, $error_type = E_USER_ERROR )
            {
                if( isset( $_GET['action'] ) && 'error_scrape' == $_GET['action'] ) 
                {
                    echo "{$error_msg}\n";
                    if ( $fatal_error )
                        exit;
                }
                else 
                {
                    trigger_error( $error_msg, $error_type );
                }
            }
            
        }
}