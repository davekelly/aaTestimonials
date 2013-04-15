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
					/*
					 * This is specfic to a particular site - you can adapt it
					 * it's based on code generated by Yoast's SEO plugin	
					<p id="breadcrumbs">
		            	<span xmlns:v="http://rdf.data-vocabulary.org/#">
		            		<span typeof="v:Breadcrumb">
		            			<a href="<?php echo site_url(); ?>" rel="v:url" property="v:title">
		            				Home
		            			</a>
		            		</span> &raquo; 
	            			<span typeof="v:Breadcrumb">
	            				<a href="<?php echo get_permalink(); ?>" rel="v:url" property="v:title">
	            					Testimonials
	            				</a>
	            			</span> &raquo; 
	            			<span typeof="v:Breadcrumb">
	            				<strong class="breadcrumb_last" property="v:title">
	            					<?php the_title(); ?>
	            				</strong>
	            			</span>
	            		</span>
		            </p>
		            */ ?>
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


<?php get_footer(); ?>