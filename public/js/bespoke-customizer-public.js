(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$( window ).load(function() {
		$(".customize_button").click(function(){
			$(".modal-backdrop").show();
			$("div#exampleModalLong").addClass('show');//.show();
			$(".modal-backdrop").addClass('show');
			fetch("http://localhost/wordpress/?api_request=getProduct&prodId="+$(".customize_button").attr("data-product"), {method: 'get'})
			.then((response)=>{ 
				return response.json();
			})
			.then((product)=>{
				$("#bespoke_img_src").attr("src",product.image);
				$("#bespoke_product_title").text(product.title);
				$(".save-btn").attr("id", product.id);
			})
		});

		$(".modal-close").on("click", function(){
			$(".modal-backdrop").hide();
			$("div#exampleModalLong").hide();
			$("div#exampleModalLong").removeClass('show');
			$(".modal-backdrop").removeClass('show');			
		})
		
	});

})( jQuery );
