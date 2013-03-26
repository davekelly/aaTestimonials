<?php
/**
 * Create a custom post type for Competions
 *
 * @package AACompetiton
 * @author Ambient Age, (http://www.ambientage.com)
 */


// let's create the function for the custom type
function register_aa_testimonial_type() { 
	// creating (registering) the custom type 
	register_post_type( 'testimonial', 
	 	
		array('labels' => array(
        			'name' => __('Case Studies', 'post type general name'), 
        			'singular_name' => __('Case Study', 'post type singular name'), 
        			'add_new' => __('Add New', 'custom post type item'),
        			'add_new_item' => __('Add New Case Study'), 
        			'edit' => __( 'Edit' ), 
        			'edit_item' => __('Edit Case Study'), 
        			'new_item' => __('New Case Study'), 
        			'view_item' => __('View Case Studies'),
        			'search_items' => __('Search Case Studies'), 
        			'not_found' =>  __('No Case Studies found.'), 
        			'not_found_in_trash' => __('Nothing found in Trash'), 
        			'parent_item_colon' => ''
			), /* end of arrays */			
			'public'               => true,
			'publicly_queryable'   => true,
			'exclude_from_search'  => true,
			'show_ui'              => true,
			'query_var'            => true,
			'menu_position'        => 4, 
			'rewrite'              => array(
        'slug'        => 'case-study',
        'with_front'  => true,
      ),
			'capability_type'      => 'post',
			'hierarchical'         => false,			
			'supports'             => array( 'title', 'editor', 'excerpt', 'thumbnail')
	 	) /* end of options */
	); /* end of register post type */
	
	
	
} 



	// adding the function to the Wordpress init
add_action( 'init', 'register_aa_testimonial_type');
add_action("admin_init", "aa_testimonial_admin_init");

function aa_testimonial_admin_init(){
  // Context:
  // add_meta_box( $id, $title, $callback, $page, $context, $priority );
  add_meta_box("testimonial-meta", "Testimonial Details", "aa_testimonial_details", "testimonial", "normal", "high");
}


/**
 * Functions to change the link text within the Featured 
 * Image meta box on Testimonial admin page
 */
function change_thumbnail_html( $content ) {
    if ('testimonial' == $GLOBALS['post_type'])
      add_filter('admin_post_thumbnail_html','aa_tesimonial_update_thumbnail_text');
}
function aa_tesimonial_update_thumbnail_text($content){
   return str_replace(__('Set featured image'), __('Add Company Logo (recommended: 300px x 120px)'),$content);
}
add_action('admin_head-post-new.php','change_thumbnail_html');
add_action('admin_head-post.php','change_thumbnail_html');


/**
 * Replace the heading on the Featured Image
 * Meta box in Testimonial Admin
 */
function aa_testimonial_change_image_box()
{
    remove_meta_box( 'postimagediv', 'testimonial', 'side' );
    add_meta_box('postimagediv', __('Company Logo'), 'post_thumbnail_meta_box', 'testimonial', 'side', 'default');
}
add_action('do_meta_boxes', 'aa_testimonial_change_image_box');

function aa_testimonial_details(){

  echo '<input type="hidden" name="aa_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

  global $post;
  $custom  = get_post_custom($post->ID);
  $testimonial = new AATestimonial( $post->ID );
  $aa_testimonial_is_featured   = ( $testimonial->getIsFeatured() ? '1' : '0');
  $aa_testimonial_date          = $testimonial->getTestimonialDate();
  $aa_testimonial_name          = $testimonial->getTestimonialName();
  $aa_testimonial_linkedin      = $testimonial->getTestimonialLinkedIn();
  $aa_testimonial_location      = $testimonial->getTestimonialLocation();
  $aa_testimonial_job           = $testimonial->getTestimonialJob();
  $aa_testimonial_profile_image = $testimonial->getTestimonialProfileImage(); ;
  $aa_testimonial_quote         = $testimonial->getTestimonialQuote();
  $aa_testimonial_pdf           = $testimonial->getTestimonialPdf();

  ?>

  <table>
    <tr valign="top">
      <td>
        <label for="aa_testimonial_is_featured">Is this Testimonial "Featured"?</label>
      </td>
      <td>
        <input name="aa_testimonial_is_featured" id="aa_testimonial_is_featured" type="checkbox" value="1" <?php checked( $aa_testimonial_is_featured, '1', $echo = true )?> />  
      </td>
    </tr>
    <?php if( get_option( 'aa_testimonial_date_allowed' )): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_date">Date:</label>
        </td>
        <td>
          <input name="aa_testimonial_date" id="aa_testimonial_date" size="60" value="<?php echo $aa_testimonial_date; ?>" />  
        </td>
      </tr>
    <?php endif; ?>

    <?php if(get_option( 'aa_testimonial_name_allowed') ): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_name">
              Name
            </label>
          </td>
          <td>
            <input name="aa_testimonial_name" id="aa_testimonial_name" size="60" value="<?php echo $aa_testimonial_name; ?>" />  
          </td>
      </tr>
    <?php endif; ?>

    <?php if(get_option( 'aa_testimonial_linkedin_allowed') ): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_linkedin">
              LinkedIn Profile URL
            </label>
          </td>
          <td>
            <input name="aa_testimonial_linkedin" id="aa_testimonial_linkedin" size="60" value="<?php echo $aa_testimonial_linkedin; ?>" />  
          </td>
      </tr>
    <?php endif; ?>

    <?php if(get_option( 'aa_testimonial_location_allowed') ): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_location">
            Location
          </label>
        </td>
        <td>
          <input name="aa_testimonial_location" id="aa_testimonial_location" size="60" value="<?php echo $aa_testimonial_location; ?>" />  
        </td>
      </tr>
    <?php endif; ?>

    <?php if(get_option( 'aa_testimonial_job_allowed') ): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_job">
            Job
          </label>
          <br/>
          <small>(Add the person's job title)
        </td>
        <td>
          <input name="aa_testimonial_job" id="aa_testimonial_job" size="60" value="<?php echo $aa_testimonial_job; ?>" />  
        </td>
      </tr>
    <?php endif; ?>

    <?php if(get_option( 'aa_testimonial_profile_image_allowed') ): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_profile_image">
            Person's Profile Image URL
          </label>
          <br/>
          <small>Image should be sized to 60px x 60px and <br/>uploaded to the Media Library first</small>
        </td>
        <td>
          <input name="aa_testimonial_profile_image" id="aa_testimonial_profile_image" size="60" value="<?php echo $aa_testimonial_profile_image; ?>" />  
        </td>
      </tr>
    <?php endif; ?>
  
    <?php if(get_option( 'aa_testimonial_quote_allowed') ): ?>
    <tr valign="top">
      <td>
        <label for="aa_testimonial_quote">
            Quote
          </label>
          <br/>
          <small>
            You can include a short "pull-quote" from the full testimonial here.
          </small>
        </td>
        <td>
          <textarea name="aa_testimonial_quote" id="aa_testimonial_quote" rows="4" cols="60"><?php echo $aa_testimonial_quote; ?></textarea>
        </td>
      </tr>
    <?php endif; ?>

    <tr valign="top">
      <td>
        <label for="aa_testimonial_pdf">
            Case Study PDF file
          </label>
          <br/>
          <small>
            Upload this to the Media Library and paste the link to it here
          </small>
        </td>
        <td>
          <textarea name="aa_testimonial_pdf" id="aa_testimonial_pdf" rows="4" cols="60"><?php echo $aa_testimonial_pdf; ?></textarea>
        </td>
      </tr>
  </table>
  <?php
}


/**
 * Save all custom fields
 *
 * @global <type> $post
 */
function aa_save_testimonial_details(){
  global $post;
  // verify nonce
    if (!isset($_POST['aa_meta_box_nonce']) || !wp_verify_nonce($_POST['aa_meta_box_nonce'], basename(__FILE__)) ) {
        if(isset($post->ID)){
            return $post->ID;            
        }
        return;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post->ID;
    }

  update_post_meta($post->ID, "aa_testimonial_is_featured", $_POST["aa_testimonial_is_featured"]);
  update_post_meta($post->ID, "aa_testimonial_date", $_POST["aa_testimonial_date"]);
  update_post_meta($post->ID, "aa_testimonial_name", $_POST["aa_testimonial_name"]);
  update_post_meta($post->ID, "aa_testimonial_linkedin", $_POST["aa_testimonial_linkedin"]);
  update_post_meta($post->ID, "aa_testimonial_location", $_POST["aa_testimonial_location"]);
  update_post_meta($post->ID, "aa_testimonial_job", $_POST["aa_testimonial_job"]);
  update_post_meta($post->ID, "aa_testimonial_profile_image", $_POST["aa_testimonial_profile_image"]);
  update_post_meta($post->ID, "aa_testimonial_quote", $_POST["aa_testimonial_quote"]);
  update_post_meta($post->ID, "aa_testimonial_pdf", $_POST["aa_testimonial_pdf"]);
  

}
add_action('save_post', 'aa_save_testimonial_details');