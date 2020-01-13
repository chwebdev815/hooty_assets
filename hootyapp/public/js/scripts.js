(function($) {
    "use strict";
    $(function(){

    	// Content height    	
    	function contentHeight(){
	    	var contentHead = $('.content-head').outerHeight();
			var contentWrapper = $('.content-wrapper');

			contentWrapper.css('height', function(){
				return 'calc(100% - ' + contentHead + 'px)';
			});
		}

		contentHeight();

		// Editor for email
		var mailEditor = $('#editor');
		
		if (mailEditor.length){
			ClassicEditor
		    .create( document.querySelector( '#editor' ) )
		    .catch( error => {
		        console.error( error );
		    } );
		}

		// Checkbox control
		$('.selectall').on('click', function(){

			$(this.form.elements).filter('.checkbox').prop('checked', this.checked);
			
		});
    });


})(jQuery);