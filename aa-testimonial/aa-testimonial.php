<?php
/*
Plugin Name: AA Testimonial 
Plugin URI: http://www.ambientage.com/plugins/wordpress-testimonials-plugin/
Description: Dispaly client testimonails on your site.
Author: Dave Kelly
Version: 0.1
Author URI: http://www.ambientage.com/
 
Copyright 2013  David Kelly (email : plugins@ambientage.com)

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 
 */


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo "Wha'sup. Not much happening here. Sorry ;)";
    exit;
}

define( 'AA_TESTIMONIAL', '0.1' );

$pluginurl = plugin_dir_url(__FILE__);
if ( preg_match( '/^https/', $pluginurl ) && !preg_match( '/^https/', get_bloginfo('url') ) )
    $pluginurl = preg_replace( '/^https/', 'http', $pluginurl );
define( 'AA_TESTIMONIAL_FRONT_URL', $pluginurl );

define( 'AA_TESTIMONIAL_URL', plugin_dir_url(__FILE__) );
define( 'AA_TESTIMONIAL_PATH', plugin_dir_path(__FILE__) );
define( 'AA_TESTIMONIAL_BASENAME', plugin_basename( __FILE__ ) );


require AA_TESTIMONIAL_PATH.'frontend/aa-testimonial-class.php';
require AA_TESTIMONIAL_PATH.'inc/aa-testimonial-post-type.php';

if(is_admin()){    
    // admin side stuff...
    require AA_TESTIMONIAL_PATH.'inc/aa-testimonial-plugin-admin.php';
    require AA_TESTIMONIAL_PATH.'inc/aa-testimonial-settings-admin.php';
}else{
    require AA_TESTIMONIAL_PATH. 'frontend/aa-testimonial-view.php';
}


/**
 * Enqueue front-end scripts / style
 * @return [type] [description]
 */
function aa_testimonial_enqueue_scripts(){
    wp_enqueue_style('aa-competition', AA_TESTIMONIAL_FRONT_URL . 'frontend/style/aa-testimonial.css');
    wp_enqueue_script('jquery');
    // wp_enqueue_script('aa-testimonial', AA_TESTIMONIAL_FRONT_URL . 'frontend/js/testimonial.js', array('jquery'), AA_TESTIMONIAL, true );
}
add_action('wp_enqueue_scripts', 'aa_testimonial_enqueue_scripts');


// When activated...
register_activation_hook(__FILE__, array( 'AATestimonial_Plugin_Admin', 'on_activate' ) );

// Get rid of everything on de-activation / deletion
register_deactivation_hook( __FILE__, array( 'AATestimonial_Plugin_Admin', 'on_deactivate' ) );
register_uninstall_hook( __FILE__, array( 'AATestimonial_Plugin_Admin', 'on_uninstall' ) );
