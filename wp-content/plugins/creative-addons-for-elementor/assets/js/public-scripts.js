jQuery(document).ready(function($) {

	/***********************************************************
	 *
	 *                       Search Widget
	 *
	 ***********************************************************/
	$( 'body' ).on( 'submit', '.crel-search-box__search-form', function( e ) {
		
		// Disable in admin 
		if ( $('.elementor-editor-active, .elementor-editor-preview').length ) {
			return false;
		}
		
		e.preventDefault();  // do not submit the form

		//Place Loading Spinner at the end of the Input box.
		let InputLength = $(this).find( '.crel-search-box__search-form__input' ).innerWidth();

		if ( $('[dir=rtl]').length ) {
			$( '.crel-loading-spinner' ).css('right', InputLength - 35 );	
		} else {
			$( '.crel-loading-spinner' ).css('left', InputLength - 35 );
		}


		let form = $(this).closest('.crel-search-box-container');
		
		if ( form.find('.crel-search-box__search-form__input').val() === '' ) {
			return;
		}
 
		let postData = {
			action: 'crel-search-kb',
			crel_kb_id: form.find('input[name=crel_kb_id]').val(),
			search_words: form.find('.crel-search-box__search-form__input').val(),
			crel_list_size: form.find('input[name=crel_list_size]').val()
		};

		let msg = '';

		$.ajax({
			type: 'GET',
			dataType: 'json',
			data: postData,
			url: form.find('input[name=crel_ajaxurl]').val(),
			beforeSend: function (xhr)
			{
				//Loading Spinner
				form.find( '.crel-loading-spinner').show();
			}

		}).done(function (response)
		{
			response = ( response ? response : '' );

			//Hide Spinner
			form.find( '.crel-loading-spinner').hide();
			msg = response.search_result;
			
			if ( response.error || response.status !== 'success') {
				
				form.find('.crel-sbsr__all-results, .crel-sbsr__help-text').hide();
				
			} else {
				form.find('.crel-sbsr__all-results, .crel-sbsr__help-text').show();
			}
			
			if ( response.error || ! response.show_more ) {
				form.find('.crel-sbsr__all-results').hide();
			} else {
				form.find('.crel-sbsr__all-results').show();
			}

		}).fail(function (response, textStatus, error)
		{
			//noinspection JSUnresolvedVariable
			msg = crel_vars.msg_try_again + '. [' + ( error ? error : crel_vars.unknown_error ) + ']';

		}).always(function ()
		{

			if ( msg ) {
				form.find( '.crel-search-box__search-results-container' ).show();
				form.find( '.crel-search-box__search-results__list-container' ).html( msg );
			}
		});
	});
	
	// Show More button
	$('body').on('click', '.crel-sbsr__all-results', function(){
		let form = $(this).closest('.crel-search-box-container');
		form.find('[name=crel_list_size]').val('-1');
		form.find('button').trigger( 'click' );
		
		return false;
	});

	$(document).on( 'click', function(e) {
		if ( $('.crel-search-box__search-results-container').css('display') !== 'none' ) {
			$('.crel-search-box__search-results-container').hide();
		}
	});
	
	
	/***********************************************************
	 *
	 *                       Image Guide Widget
	 *
	 ***********************************************************/
	
	// hightlight 
	$(document).on('click', '.crel-image-guide__container', function(){
		$(this).find('[data-index]').removeClass('crel-image-guide__spot--active');
	});
	
	$(document).on('click', '.crel-image-guide__container [data-index]', function(e){
		e.stopPropagation();
		
		let wrap = $(this).closest('.crel-image-guide__container');
		let i = $(this).data('index');
		
		wrap.find('[data-index]').removeClass('crel-image-guide__spot--active');
		wrap.find('[data-index=' + i + ']').addClass('crel-image-guide__spot--active');
	});
	
	$(document).on({
		mouseenter: function () {
			let wrap = $(this).closest('.crel-image-guide__container');
			let i = $(this).data('index');
			
			wrap.find('[data-index]').removeClass('crel-image-guide__spot--active');
			wrap.find('[data-index=' + i + ']').addClass('crel-image-guide__spot--active');
			$(this).removeClass('crel-image-guide__spot--active');
		},
		mouseleave: function () {
			if ( $(this).hasClass('crel-image-guide__spot--active') ) {
				return true; // user clicked on element, so keep hightlight 
			}
			
			$(document).find('.crel-image-guide__container [data-index]').removeClass('crel-image-guide__spot--active');
		}
	}, '.crel-image-guide__container [data-index]' ); 
	
	$(document).on( 'click', '.crel-image-guide__image-wrap--lightbox', function(){
		$(this).closest('.crel-image-guide__image').addClass('crel-image-guide__image-lightbox__active');
		return false;
	});

	$(document).on( 'click', '.crel-image-guide__image-overflow', function(){
		$(this).closest('.crel-image-guide__image').removeClass('crel-image-guide__image-lightbox__active');
		return false;
	});

	/** elementor is blocking all links on preview so we need to add the script to public-scripts (to work in preview) and unblock the links **/
	$('body').on('click', '.crel-kb_required .crel-kb-button', function( e ){
		window.open( $(this).prop('href') );
		return false;
	});
});

/** CODE BLOCK */
(function($){
	$( window ).on( 'elementor/frontend/init', () => {

		class CRELCodeBlock extends elementorModules.frontend.handlers.Base {
			getDefaultSettings() {
				return {
					selectors: {
						code: '.crel-code-block-container code',
						wrap: '.crel-code-block-container'
					},
				};
			}

			getDefaultElements() {
				const selectors = this.getSettings( 'selectors' );
				return {
					$code: this.$element.find( selectors.code ),
					$wrap: this.$element.find( selectors.wrap ),
				};
			}

			bindEvents() {
				this.initView( this );
				this.elements.$wrap.ready( function(){
					if ( typeof CRELPrism == 'undefined' ) {
						return;
					}

					CRELPrism.highlightAll();
				} );
			}

			initView( event ) {

				if ( typeof CRELPrism == 'undefined' ) {
					return;
				}

				// run prism
				CRELPrism.highlightAll( true, function( e ){
					$(this).closest('.crel-code-block-container').removeClass('crel-loading');
				});
			}
		}

		const addHandler = ( $element ) => {
			elementorFrontend.elementsHandler.addHandler( CRELCodeBlock, {
				$element,
			} );
		};

		elementorFrontend.hooks.addAction( 'frontend/element_ready/crel-code-block.default', addHandler );
	});

	// close fullscreen by press Esc
	$(document).on('keyup', function( e ){
		if ( $( '.crel-code-block-container--fullscreen' ).length && e.keyCode === 27 ) {
			$( '.crel-code-block-container--fullscreen' ).removeClass( 'crel-code-block-container--fullscreen' )
		}
	});

	// expand to fullscreen
	$(document).on('click', '.crel-code-block__control-expand', function(){
		$(this).closest( '.crel-code-block-container' ).toggleClass( 'crel-code-block-container--fullscreen' );
	});

	// add help text
	$(document).on('mouseenter', '.crel-code-block__control-expand, .crel-code-block__control-copy', function(){
		$(this).closest('.crel-code-block__control-panel').find('.crel-code-block__control-panel__help-text').text( $(this).data('help') );
	});

	$(document).on('mouseleave', '.crel-code-block__control-expand, .crel-code-block__control-copy', function() {
		$(this).closest('.crel-code-block__control-panel').find('.crel-code-block__control-panel__help-text').text('');
	});

	// copy function
	$(document).on('click', '.crel-code-block__control-copy', function( event ){
		event.preventDefault();

		$(this).closest('.crel-code-block-container').find('.crel-block-original-code').select();
		document.execCommand("copy");

		let textWrap = $(this).closest('.crel-code-block__control-panel').find('.crel-code-block__control-panel__help-text');
		let text = $(this).data('copied');
		textWrap.text( text );

		setTimeout( function(){
			if ( textWrap.text() == text ) {
				textWrap.text( '' );
			}
		}, 4000 );

	});

	// replace brackets if exists
	$('.crel-replace-brackets').each( function(){
		let text = $(this).text();

		text = text.replaceAll( '%crel_bracket_open%', '[' ).replaceAll( '%crel_bracket_close%', ']' );

		$(this).text( text );
		$(this).closest('.crel-code-block-container').find('.crel-block-original-code').val(text).html(text);
	} );
})(jQuery);

/** Advanced Heading */

jQuery( window ).on( 'elementor/frontend/init', () => {

	class CRELAdvancedHeading extends elementorModules.frontend.handlers.Base {
		getDefaultSettings() {
			return {
				selectors: {
					link: '.crel-advanced-heading__title__link',
					hint: '.crel-advanced-heading__title__link__icon_hover-popup__inner',
					titleBadge: '.crel-advanced-heading__title__text'
				},
			};
		}

		getDefaultElements() {
			const selectors = this.getSettings( 'selectors' );
			return {
				$link: this.$element.find( selectors.link ),
				$hint: this.$element.find( selectors.hint ),
				$titleBadge: this.$element.find( selectors.titleBadge ),
			};
		}

		bindEvents() {
			this.elements.$link.on( 'click', this.copyLink.bind( this ) );
		}

		copyLink( event ) {
			event.preventDefault();

			let hash = this.elements.$titleBadge.prop( 'id' );

			// check if we on kb page and have TOC
			if ( jQuery('.eckb-article-toc').length && typeof this.elements.$titleBadge.data('id') != 'undefined' && this.elements.$titleBadge.data('id') ) {
				hash = this.elements.$titleBadge.data('id');
			}

			// set link in the input to the right
			// use link instead of URL object for IE support
			let url = document.createElement('a');
			url.href = location.href;
			url.hash = hash;

			// Create temporary input and copy text from it
			let tempInput = document.createElement("input");
			tempInput.value = url.href;
			document.body.appendChild(tempInput);
			tempInput.select();
			document.execCommand("copy");
			document.body.removeChild(tempInput);

			// change hint text
			let $hintEl = this.elements.$hint;
			let copied = this.elements.$link.data( 'copied' );
			let copy_text = this.elements.$link.data( 'copy_text' );

			$hintEl.text( copied );
			$hintEl.closest('.crel-advanced-heading__title__link').find('.crel-advanced-heading__title__link__icon').addClass('crel-active');
			$hintEl.closest('.crel-advanced-heading--anchorLink-hover').addClass('crel-active');

			setTimeout(function(){
				$hintEl.text( copy_text );
				$hintEl.closest('.crel-advanced-heading__title__link').find('.crel-advanced-heading__title__link__icon').removeClass('crel-active');
				$hintEl.closest('.crel-advanced-heading--anchorLink-hover').removeClass('crel-active');
			}, 2000);
		}
	}

	const addHandler = ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( CRELAdvancedHeading, {
			$element,
		} );
	};

	elementorFrontend.hooks.addAction( 'frontend/element_ready/crel-advanced-heading.default', addHandler );
} );


/** STEPS */
jQuery( window ).on( 'elementor/frontend/init', () => {

	class CRELSteps extends elementorModules.frontend.handlers.Base {
		getDefaultSettings() {
			return {
				selectors: {
					link: '.crel-step-header__title__link',
				},
			};
		}

		getDefaultElements() {
			const selectors = this.getSettings( 'selectors' );
			return {
				$link: this.$element.find( selectors.link ),
			};
		}

		bindEvents() {
			this.elements.$link.on( 'click', this.copyLink.bind( this ) );
		}

		copyLink( event ) {
			event.preventDefault();

			let $stepWrap = jQuery(event.target).closest('.crel-step');
			let hash = $stepWrap.prop( 'id' );
			let $title = $stepWrap.find('.crel-step-header__title__text');

			// check if we on kb page and have TOC
			if ( $title.length && jQuery('.eckb-article-toc').length && typeof $title.data('id') != 'undefined' && $title.data('id') ) {
				hash = $title.data('id');
			}

			// set link in the input to the right
			// use link instead of URL object for IE support
			let url = document.createElement('a');
			url.href = location.href;
			url.hash = hash;

			// Create temporary input and copy text from it
			let tempInput = document.createElement("input");
			tempInput.value = url.href;
			document.body.appendChild(tempInput);
			tempInput.select();
			document.execCommand("copy");
			document.body.removeChild(tempInput);

			// change hint text
			let $hintEl = $stepWrap.find('.crel-step-header__title__link__icon_hover-popup__inner');
			let copied = $stepWrap.find('.crel-step-header__title__link').data( 'copied' );
			let copy_text = $stepWrap.find('.crel-step-header__title__link').data( 'copy_text' );

			$hintEl.text( copied );

			setTimeout(function(){
				$hintEl.text( copy_text );
			}, 2000);
		}
	}

	const addHandler = ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( CRELSteps, {
			$element,
		} );
	};

	elementorFrontend.hooks.addAction( 'frontend/element_ready/crel-steps.default', addHandler );
} );