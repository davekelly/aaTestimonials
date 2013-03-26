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
        			'name' => __('Testimonials', 'post type general name'), 
        			'singular_name' => __('Testimonial', 'post type singular name'), 
        			'add_new' => __('Add New', 'custom post type item'),
        			'add_new_item' => __('Add New Testimonial'), 
        			'edit' => __( 'Edit' ), 
        			'edit_item' => __('Edit Testimonial'), 
        			'new_item' => __('New Testimonial'), 
        			'view_item' => __('View Testimonials'),
        			'search_items' => __('Search Testimonials'), 
        			'not_found' =>  __('No Testimonials found.'), 
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

    <?php if( !$testimonial->anyAdditionalFieldsAllowed()): ?>
      <tr>
        <td colspan="2">
          <p>No additional fields required...</p>
        </td>
      </tr>
    <?php endif; ?>
    <?php if( $testimonial->isOptionAllowed('featured')): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_is_featured">Is this Testimonial "Featured"?</label>
        </td>
        <td>
          <input name="aa_testimonial_is_featured" id="aa_testimonial_is_featured" type="checkbox" value="1" <?php checked( $aa_testimonial_is_featured, '1', $echo = true )?> />  
        </td>
      </tr>
    <?php endif; ?>

    <?php if( $testimonial->isOptionAllowed('date') ): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_date">Date:</label>
        </td>
        <td>
          <input name="aa_testimonial_date" id="aa_testimonial_date" size="60" value="<?php echo $aa_testimonial_date; ?>" />  
        </td>
      </tr>
    <?php endif; ?>

    <?php if($testimonial->isOptionAllowed('name') ): ?>
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

    <?php if($testimonial->isOptionAllowed('linkedin') ): ?>
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

    <?php if($testimonial->isOptionAllowed('location') ): ?>
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

    <?php if($testimonial->isOptionAllowed('job') ): ?>
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

    <?php if($testimonial->isOptionAllowed('profile_image') ): ?>
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
  
    <?php if($testimonial->isOptionAllowed('quote') ): ?>
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

    <?php if( $testimonial->isOptionAllowed('pdf') ): ?>
      <tr valign="top">
        <td>
          <label for="aa_testimonial_pdf">
              Testimonial PDF file
            </label>
            <br/>
            <small>
              Upload this to the Media Library and paste the link to it here
            </small>
          </td>
          <td>
            <input name="aa_testimonial_pdf" id="aa_testimonial_pdf" size="60" value="<?php echo $aa_testimonial_pdf; ?>" />
          </td>
        </tr>
      <?php endif; ?>
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

    $testimonial = new AATestimonial( $post->ID );

    if( $testimonial->isOptionAllowed('featured') ){
      update_post_meta($post->ID, "aa_testimonial_is_featured", $_POST["aa_testimonial_is_featured"]);    
    }
  
    if( $testimonial->isOptionAllowed('date')){
      update_post_meta($post->ID, "aa_testimonial_date", $_POST["aa_testimonial_date"]);    
    }

    if( $testimonial->isOptionAllowed('name')){
      update_post_meta($post->ID, "aa_testimonial_name", $_POST["aa_testimonial_name"]);    
    }

    if( $testimonial->isOptionAllowed('linkedin')){
      update_post_meta($post->ID, "aa_testimonial_linkedin", $_POST["aa_testimonial_linkedin"]);    
    }
    if( $testimonial->isOptionAllowed('location')){
      update_post_meta($post->ID, "aa_testimonial_location", $_POST["aa_testimonial_location"]);    
    }

    if( $testimonial->isOptionAllowed('job')){
      update_post_meta($post->ID, "aa_testimonial_job", $_POST["aa_testimonial_job"]);    
    }

    if( $testimonial->isOptionAllowed('profile_image')){
      update_post_meta($post->ID, "aa_testimonial_profile_image", $_POST["aa_testimonial_profile_image"]);    
    }
  
    if( $testimonial->isOptionAllowed('quote')){
      update_post_meta($post->ID, "aa_testimonial_quote", $_POST["aa_testimonial_quote"]);    
    }

    if( $testimonial->isOptionAllowed('pdf')){
      update_post_meta($post->ID, "aa_testimonial_pdf", $_POST["aa_testimonial_pdf"]);    
    }
  

}
add_action('save_post', 'aa_save_testimonial_details');