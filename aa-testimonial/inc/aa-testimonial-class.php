<?php
/**
 * Used to access custom post info for Testimonials
 */

if ( ! class_exists( 'AATestimonial' ) ) {
	
	$custom;

	class AATestimonial {

		function __construct( $postId )
		{
			$this->custom = get_post_custom( $postId );
		}

		public function getIsFeatured()
		{
			return (isset ( $this->custom["aa_testimonial_is_featured"][0] ) &&  $this->custom["aa_testimonial_is_featured"][0] == '1' ?   true : false );
		}


		public function getTestimonialDate()
		{
			if( ! $this->isOptionAllowed('date') ){
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_date"][0] ) ? wp_kses_post( trim( $this->custom["aa_testimonial_date"][0] )): '' );
		}

		public function getTestimonialName()
		{
			if( !$this->isOptionAllowed('name' ) ){
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_name"][0] ) ? wp_kses_post( trim ( $this->custom["aa_testimonial_name"][0] )): '' );
		}

		public function getTestimonialLinkedIn()
		{
			if( !$this->isOptionAllowed('linkedin' ) ){
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_linkedin"][0] ) ? esc_url( $this->custom["aa_testimonial_linkedin"][0] ): '' );
		}

		public function getTestimonialLocation()
		{
			if( !$this->isOptionAllowed('location' ) ){
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_location"][0] ) ? wp_kses_post( trim( $this->custom["aa_testimonial_location"][0] ) ): '' );	
		}

		public function getTestimonialJob()
		{
			if( !get_option( 'aa_testimonial_job_allowed' ) ){
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_job"][0] ) ? wp_kses_post( trim( $this->custom["aa_testimonial_job"][0] ) ): '' );	
		}

		public function getTestimonialProfileImage()
		{
			if( !get_option( 'aa_testimonial_profile_image_allowed' ) ){
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_profile_image"][0] ) ? esc_url( $this->custom["aa_testimonial_profile_image"][0] ) : '' );	
		}


		public function getTestimonialQuote()
		{
			if( !get_option( 'aa_testimonial_quote_allowed' ) ){
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_quote"][0] ) ? wp_kses_post( trim ($this->custom["aa_testimonial_quote"][0] ) ): '' );	
		}	

		public function getTestimonialPdf()
		{
			if( !get_option( 'aa_testimonial_pdf_allowed'))
			{
				return false;
			}
			return (isset ( $this->custom["aa_testimonial_pdf"][0] ) ? esc_url ($this->custom["aa_testimonial_pdf"][0] ) : '' );	
		}	



		public function isOptionAllowed( $optionName )
		{
			if( !get_option( 'aa_testimonial_'. $optionName .'_allowed' ) )
			{
				return false;
			}
			return true;
		}


		/**
		 * Has the user enabled any of the extra
		 * testimonial data fields?
		 * @return Bool $additionalFieldsAllowed
		 */
		public function anyAdditionalFieldsAllowed()
		{

			if( (get_option( 'aa_testimonial_pdf_allowed') ) or 
					(get_option( 'aa_testimonial_quote_allowed' ) ) or
					(get_option( 'aa_testimonial_profile_image_allowed' )) or
					(get_option( 'aa_testimonial_job_allowed' ) ) or
					(get_option( 'aa_testimonial_location_allowed' )) or
					(get_option( 'aa_testimonial_linkedin_allowed' )) or
					(get_option( 'aa_testimonial_name_allowed' )) or
					(get_option( 'aa_testimonial_date_allowed' )) or
					(get_option( 'aa_testimonial_featured_allowed' ))
			){
				return true;
			}

			return false;
		}	

	}

}