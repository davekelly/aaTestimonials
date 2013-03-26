<?php get_header(); ?>

	<div id="content" class="aa-testimonial-single">
		
		<?php while ( have_posts() ) : the_post(); ?>

				<?php
					$testimonial = new AATestimonial( get_the_ID() );

				?>
				<header class="entry-header">
					<h1 class="entry-title">
						<?php the_title(); ?>
					</h1>

					<?php
						// Manually created as case-studies page isn't part of the 
						// case-studies plugin, it's a static page with a shortcode, 
						// meaning it does'n have a parent set...
					?>
		            <p id="breadcrumbs">
		            	<span xmlns:v="http://rdf.data-vocabulary.org/#">
		            		<span typeof="v:Breadcrumb">
		            			<a href="<?php echo site_url(); ?>" rel="v:url" property="v:title">
		            				Home
		            			</a>
		            		</span> &raquo; 
	            			<span typeof="v:Breadcrumb">
	            				<a href="<?php echo get_permalink( 163 ); ?>" rel="v:url" property="v:title">
	            					Case Studies
	            				</a>
	            			</span> &raquo; 
	            			<span typeof="v:Breadcrumb">
	            				<strong class="breadcrumb_last" property="v:title">
	            					<?php the_title(); ?>
	            				</strong>
	            			</span>
	            		</span>
		            </p>
				</header>
				<section class="entry-content">
					<aside class="aa-testimonial-logo">
						<div class="aa-testimonial-logo-holder">
							<?php
								if( has_post_thumbnail()){
									?>
									<a href="<?php the_permalink(); ?>">
									<?php
										the_post_thumbnail( 'aa-testimonial-logo', $default_attr = array(
															'alt'	=> trim(strip_tags( get_the_title() )),
															'title'	=> trim(strip_tags( get_the_title() ))
										));	
									?>
									</a>
									<?php
								}else{
									?>
									<a href="<?php the_permalink(); ?>">
										<?php echo '<img src="http://placehold.it/225x75" alt="'. get_the_title() . '" title="'.get_the_title().'" />'; ?>
									</a>
									<?php
								}
							?>
						</div>

						<?php if( $testimonial->getTestimonialPdf()): ?>
							<a href="<?php echo $testimonial->getTestimonialPdf(); ?>" class="btn btn-info">
								<i class="icon-white icon-download"></i>
								Download the Case Study (.pdf)
							</a>
						<?php endif; ?>
					</aside>
					<article>
						<?php the_content(); ?>
					</article>
					<footer>
						<h4>More Case Studies</h4>
						<ul>
							<?php 
							$currentId = get_the_ID();
							$links = new WP_Query( array( 
												'post_type' 		=> 'testimonial', 
												'posts_per_page' 	=> 5, 
												'post__not_in'		=> array( get_the_ID() ),
												'orderby' 			=> 'rand'
												)
											); 
							while( $links->have_posts()): $links->the_post();
							?>
								<li>
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</li>
							<?php endwhile; ?>
						</ul>
					</footer>


				</section><!-- .entry-content -->
				
		<?php endwhile; ?>

	</div>

	<section class="wrapper" id="home-base-callout">
	    <div class="container">
	        <div class="secondary-callout">
	            <div class="callout-pitch">
	                <?php $baseCallout = get_option( 'aa_home_base_callout' ); 
	                    if( $baseCallout ):
	                        echo $baseCallout;
	                    else:  ?>
	                        Like to learn more? One of our experts will walk 
	                        you through how Enerit's software can help your
	                        organisation.
	                <?php endif; ?>
	            </div>
	            <div class="callout-button">
	                <a class="btn btn-success btn-large" href="<?php echo get_permalink( 597 ); // Request Demo?>">
	                    Request a Demo Today
	                </a>

	                <span> or </span>

	                <a href="<?php echo get_permalink( ); ?>">
	                    Make a Partnership Enquiry
	                </a>
	            </div>
	        </div>
	    </div>
	</section>


<?php get_footer(); ?>