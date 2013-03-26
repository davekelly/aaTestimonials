<?php
/**
 *  Competition Settings Page
 */


if ( ! class_exists( 'AATestimonial_Admin' ) ) {
    
    class AATestimonial_Admin extends Aa_Testimonial_Admin {

        var $hook           = 'aa-testimonial';
        var $filename       = 'aa-testimonial/aa-testimonial.php';
        var $longname       = 'AA Testimonial Settings';
        var $shortname      = 'AAComp';
        var $currentoption  = 'aacomp';
        var $ozhicon        = 'tag.png';
        
        function AATestimonial_Admin() {
            add_action( 'init', array(&$this, 'init') );
        }
        
        function init() {
        // if ( $this->grant_access() ) {
            add_action( 'admin_init', array(&$this, 'options_init') );
            add_action( 'admin_menu', array(&$this, 'register_settings_page') );
            
            add_filter( 'plugin_action_links', array(&$this, 'add_action_link'), 10, 2 );

            // Make sure we have thumbnails...
            add_theme_support('post-thumbnails');
            add_image_size( 'aa-testimonial-logo', 225, 75, false );
            add_image_size( 'aa-testimonial-listing-logo', 140, 47, false);
        }

        function options_init() {
            register_setting( 'aa_testimonial_options', 'aa_testimonial_date_allowed' );                        
            register_setting( 'aa_testimonial_options', 'aa_testimonial_name_allowed' );         
            register_setting( 'aa_testimonial_options', 'aa_testimonial_linkedin_allowed' );         
            register_setting( 'aa_testimonial_options', 'aa_testimonial_location_allowed' );         
            register_setting( 'aa_testimonial_options', 'aa_testimonial_job_allowed' );    
            register_setting( 'aa_testimonial_options', 'aa_testimonial_profile_image_allowed' );         
            register_setting( 'aa_testimonial_options', 'aa_testimonial_quote_allowed' );         
        }
        
        
        function aa_testimonial_settings() {           
            $content = '';                                        
            
            if (!current_user_can('manage_options')){
                wp_die( __('You do not have sufficient permissions to access this page.') );
            }
                                    
            
            ?>
            <div class="wrap">
                <h1>Testimonial Settings</h1>

                <table class="form-table">                           
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <form method="post" action="options.php">    
                                <?php
                                    settings_fields( 'aa_testimonial_options' );                    
                                    do_settings_fields( 'aa_testimonial_options', 'aa_testimonial_settings' );
                                ?>
                                <p>
                                    This allows you to enable or disable certain fields in the 
                                    Testimonial editor screen. It does not affect the display of
                                    content to users of the site.
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                          <td>
                            <label for="aa_testimonial_date_allowed">Collect Testimonial Date?</label>
                          </td>
                          <td>
                            <input name="aa_testimonial_date_allowed" id="aa_testimonial_date_allowed" type="checkbox" value="1" <?php checked( get_option( 'aa_testimonial_date_allowed' ), '1', $echo = true )?> />  
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <label for="aa_testimonial_name_allowed">Collect Name?</label>
                          </td>
                          <td>
                            <input name="aa_testimonial_name_allowed" id="aa_testimonial_name_allowed" type="checkbox" value="1" <?php checked( get_option('aa_testimonial_name_allowed'), '1', $echo = true )?> />  
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <label for="aa_testimonial_linkedin_allowed">Collect LinkedIn Profile?</label>
                          </td>
                          <td>
                            <input name="aa_testimonial_linkedin_allowed" id="aa_testimonial_linkedin_allowed" type="checkbox" value="1" <?php checked( get_option('aa_testimonial_linkedin_allowed'), '1', $echo = true )?> />  
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <label for="aa_testimonial_location_allowed">Collect Location?</label>
                          </td>
                          <td>
                            <input name="aa_testimonial_location_allowed" id="aa_testimonial_location_allowed" type="checkbox" value="1" <?php checked( get_option('aa_testimonial_location_allowed'), '1', $echo = true )?> />  
                          </td>
                        </tr>
                       
                        <tr>
                          <td>
                            <label for="aa_testimonial_job_allowed">Collect Job Title?</label>
                          </td>
                          <td>
                            <input name="aa_testimonial_job_allowed" id="aa_testimonial_job_allowed" type="checkbox" value="1" <?php checked( get_option('aa_testimonial_job_allowed'), '1', $echo = true )?> />  
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <label for="aa_testimonial_profile_image_allowed">Collect Profile Image URL</label>
                          </td>
                          <td>
                            <input name="aa_testimonial_profile_image_allowed" id="aa_testimonial_profile_image_allowed" type="checkbox" value="1" <?php checked( get_option('aa_testimonial_profile_image_allowed'), '1', $echo = true )?> />  
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <label for="aa_testimonial_quote_allowed">Collect Pull-Quote?</label>
                          </td>
                          <td>
                            <input name="aa_testimonial_quote_allowed" id="aa_testimonial_quote_allowed" type="checkbox" value="1" <?php checked( get_option('aa_testimonial_quote_allowed'), '1', $echo = true )?> />  
                          </td>
                        </tr>

                       <tr valign="top">
                            <td colspan="2">
                                <p class="submit">
                                    <input type="submit" class="button-primary" value="Save Changes" />
                                </p>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr valign="top">
                            <th scope="row">
                                &nbsp;
                            </th>
                            <td style="text-align: right;">
                                Plugin developed by <a href="http://www.ambientage.com">Ambient Age</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>                           
                
        </div>
        <?php 
        }
        
    } // end class
        
    $aaTestimonial_admin = new AATestimonial_Admin();
}
