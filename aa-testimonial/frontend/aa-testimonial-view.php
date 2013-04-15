<?php
/**
 * Frontend view related functions. All relate to 
 * how the plugin outputs info
 */


/**
 * Set up a custom template for Single Posts of type aatestimonial
 * This template can be overridden by adding a aa-testimonial-single.php file into 
 * the current theme directory
 * 
 * @global Object $wp_query
 * @global type $post
 * @param String $single_template
 * @return String $single_template
 */
function aa_testimonial_type_single_template( $single_template ){
    global $wp_query, $post;

    if( !file_exists( get_template_directory() . '/aa-testimonial-single.php')){
        
        if ($post->post_type === "testimonial"){
            if(file_exists(AA_TESTIMONIAL_PATH. 'frontend/aa-testimonial-single.php'))
                $single_template = AA_TESTIMONIAL_PATH . 'frontend/aa-testimonial-single.php';
        }
    }
    return $single_template;
}
add_filter('single_template', 'aa_testimonial_type_single_template');


/**
 * Echo case studies testimonials marked as featured
 *  for dispay on the homepage.
 * 
 * @param  integer $showFeaturedCount [optional - default 3] number of testimonials to show
 * @return Void
 */
function aa_testimonial_featured( $showFeaturedCount = 3 )
{
	$query = new WP_Query(array(
					'post_type' 		=> 'testimonial', 
					'nopaging' 			=> true, 
					'post_status' 		=> 'publish',
					'posts_per_page' 	=> $showFeaturedCount,
					'meta_key'			=> 'aa_testimonial_is_featured',
					'meta_value'		=> '1'
				));

	?>
	<div class="aa-testimonial-featured">
		<?php if( $query->have_posts()): ?>
			<ul>
				<?php while( $query->have_posts()): $query->the_post(); ?>
					<?php 
					$testimonial = new AATestimonial( get_the_ID() );
					echo '<li class="aa-testimonial-feature">'; ?>
						<a href="<?php the_permalink(); ?>">
							<h3 class="aa-testimonial-logo-holder">
								<?php 
								if( has_post_thumbnail()){
									the_post_thumbnail( 'aa-testimonial-logo', $default_attr = array(
															'alt'	=> trim(strip_tags( get_the_title() )),
															'title'	=> trim(strip_tags( get_the_title() )),
									));	
								}
								?>
							</h3>
						</a>
						<?php if( $testimonial->getTestimonialQuote()): ?>
							<blockquote class="aa-testimonial-quote" cite="<?php the_permalink(); ?>">
								<?php echo $testimonial->getTestimonialQuote(); ?>
							</blockquote>
						<?php endif; ?>
						<div class="aa-testimonial-attribution">
							<div class="aa-testimonial-profile-img">
								<?php if( $testimonial->getTestimonialProfileImage() ): ?>
									<img src="<?php echo $testimonial->getTestimonialProfileImage(); ?>" alt="n" class="img-circle" />
								<?php else: ?>
									<img src="http://placehold.it/60x60" class="img-circle" />
								<?php endif; ?>
							</div>

							<small>
								<?php if( $testimonial->getTestimonialName()): ?>
									<span class="testimonial-author">
										<?php if( $testimonial->getTestimonialLinkedIn()): ?>
												<a href="<?php echo $testimonial->getTestimonialLinkedIn(); ?>" title="LinkedIn Profile" rel="nofollow"><?php echo $testimonial->getTestimonialName(); ?></a>
										<?php else: ?>
												<?php echo $testimonial->getTestimonialName(); ?>
										<?php endif; ?>
									</span>, 
								<?php endif; ?>
								<?php if( $testimonial->getTestimonialJob()): ?>
									<span class="testimonial-job-title"><?php echo $testimonial->getTestimonialJob(); ?></span>, 
								<?php endif; ?>
								<strong>
									<?php the_title(); ?>
								</strong>
							</small>
						</div>	

					<?php
						echo '</li>';
					?>

				<?php endwhile; ?>
			</ul>
		<?php endif; ?>
	</div>
	<?php
}	


/**
 * Display a single testimonial chosen at random. Testimonials
 * can be selected when the case study has a Quote attached to it.
 *
 * @param  $case_studies_page_id WordPress $id for the main listing page
 * @return [type] [description]
 */
function aa_testimonial_random( $case_studies_page_id = null, )
{
	$query = new WP_Query( array(	
						'post_type' 		=> 'testimonial',
						'posts_per_page' 	=> 1,
						'post_status'		=> 'publish',
						'orderby'			=> 'rand',
						'meta_query' => array(
						    array(
						        'key' => 'aa_testimonial_quote',
						        'value'   => array(''),
						        'compare' => 'NOT IN'
						    )
						)
				)
			);
	if( !$case_studies_page_id ){
		$case_studies_page_id = 1; // 
	}
	while( $query->have_posts()): $query->the_post(); 
		$testimonial = new AATestimonial( get_the_ID() );
	?>

		<div class="secondary-callout aa-testimonial-random">
			<div class="aa-testimonial-random-quote">
				<blockquote>
					<?php echo $testimonial->getTestimonialQuote(); ?>
				</blockquote>
				<small>
					<?php if( $testimonial->getTestimonialName()): ?>
						<span class="testimonial-author">
							<?php if( $testimonial->getTestimonialLinkedIn()): ?>
									<a href="<?php echo $testimonial->getTestimonialLinkedIn(); ?>" title="LinkedIn Profile" rel="nofollow"><?php echo $testimonial->getTestimonialName(); ?></a>
							<?php else: ?>
									<?php echo $testimonial->getTestimonialName(); ?>
							<?php endif; ?></span>, 
					<?php endif; ?>
					<?php if( $testimonial->getTestimonialJob()): ?>
						<span class="testimonial-job-title"><?php echo $testimonial->getTestimonialJob(); ?></span>, 
					<?php endif; ?>
					<strong>
						<?php the_title(); ?>
					</strong>
				</small>
			</div>
			<?php if( $case_studies_page_id ): ?>
				<div class="callout-button">
	                <a class="btn btn-primary btn-large" href="<?php echo get_permalink( $case_studies_page_id ); // Case Studies ?>">
	                    View Testimonials &raquo;
	                </a>
	            </div>
	        <?php endif; ?>
		</div>

	<?php
	endwhile;
}

add_shortcode('aa_testimonial_random', 'aa_testimonial_random');



/**
 * View an archive listing of all previous
 * testimonials.
 *
 * Uses the shortcode [aa_casestudy_listing] to
 * display listing
 * 
 * @return Void
 */
function aa_testimonial_listing( $echo = false )
{
	$query = new WP_Query(array(
					'post_type' 	=> 'testimonial', 
					'nopaging' 		=> true, 
					'post_status' 	=> 'publish'
				));

		$html = '<div class="aa-testimonial-archive">'; ?>
			<?php if( $query->have_posts()): ?>
				<?php $counter = 0; ?>

				<?php 
				$html .= '<div>' ;?>
				<?php while( $query->have_posts()): $query->the_post(); ?>
					<?php 
						$testimonial = new AATestimonial( get_the_ID() );
					
					$html .= '<div class="aa-testimonial-indiv">
						<div class="aa-testimonial-list-logo">
							<div class="aa-testimonial-list-logo-holder">'; ?>
								<?php
								if( has_post_thumbnail()){
									$html .= '<a href=" '.  get_permalink() . '">';
									$html .= get_the_post_thumbnail( get_the_ID(), 'aa-testimonial-listing-logo', $default_attr = array(
															'alt'	=> trim(strip_tags( get_the_title() )),
															'title'	=> trim(strip_tags( get_the_title() ))

										));	
									
									$html .= '</a>';
								}
								
							$html .= '</div>
							<p>
								<a href="'. get_permalink() . '">
									Full Case Study &raquo;
								</a>
							</p>
						</div>
						<div class="aa-testimonial-list-details">
							<h3>
								<a href="' . get_permalink() . '">
									'. get_the_title() . '
								</a>
							</h3>
							<p>
								' . get_the_excerpt( ) . '
							</p>
						</div>	<!-- .aa-testimonial-list-details -->
						
					</div> <!-- .aa-testimonial-list -->';

					if( $counter % 2 === 0): 
						$html .= '</div><div>'; 
					endif; 
					$counter++;
				endwhile;
				$html .= '</div>'; 
			else: 
				$html .= '<div class="alert alert-warning">
					<h3>No Testimonials found</h3>
				</div>';
			endif; 
		$html .= '</div>	<!-- .aa-testimonial-archive -->'; 

		if( !$echo ){
			return $html;
		}
		echo $html;
}
add_shortcode('aa_casestudy_listing', 'aa_testimonial_listing');


