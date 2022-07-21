"use strict";
!(function( $, elementor ){
	// elementor here is predefined Elementor object, $ - jQuery as usual

	// Add functions  extend means that we will get Select controls, add our to old and return result - like PHP extends classes 
	
	let creativePreset = elementor.modules.controls.Select.extend({
		
		onReady: function () {
            // load presets if need
			let $wrap = this.$el;
			let $select = $wrap.find('[data-setting=crel_Generic__Custom_Presets]');

			if ( $select.length == 0 ) {
				// usual preset without custom presets, fill variable
				return;
			}

			this.updateCustomSelect( $wrap );
        },
		onRender: function () {
            this.constructor.__super__.onRender.apply(this, arguments);
			this.addResetButton();
        },

		ui: function () {
			let selector = this.constructor.__super__.ui.call(this);
			selector.save_preset_button = '.crel-button-save_new-preset';
			selector.update_preset_button = '.crel-button-update-preset';
			selector.update_preset = '.crel-update-preset-button';
			selector.cancel_update_preset = '.crel-cancel-update-preset-button';
			selector.delete_preset = '.crel-delete-preset-button';
			selector.pre_delete_preset = '.crel-pre-delete-preset-button';
			selector.cancel_delete_preset = '.crel-cancel-delete-preset-button';
			selector.create_preset = '.crel-create-preset-button';
			selector.cancel_preset = '.crel-cancel-preset-button';
			return selector;
		},

		events: function() {
			let allEvents = this.constructor.__super__.events.call(this);
			allEvents["click @ui.save_preset_button"] = "onOpenSave";
			allEvents["click @ui.update_preset_button"] = "onOpenUpdate";
			allEvents["click @ui.update_preset"] = "onUpdatePreset";
			allEvents["click @ui.cancel_update_preset"] = "onCancelPreset";
			allEvents["click @ui.delete_preset"] = "onDeletePreset";
			allEvents["click @ui.pre_delete_preset"] = "onPreDeletePreset";
			allEvents["click @ui.cancel_delete_preset"] = "onCancelDeletePreset";
			allEvents["click @ui.create_preset"] = "onCreatePreset";
			allEvents["click @ui.cancel_preset"] = "onCancelPreset";
			return allEvents;
		},

		// Before our select we will always add reset button 
		addResetButton: function () {
            let e = this;
			
			$('body').off("click", '.crel-reset-design');
            $('body').on("click", '.crel-reset-design', function () {
				// Trigger elementor reset for current openned panel 
				let opt = elementor.getPanelView().getCurrentPageView().getOption("editedElementView");
				// $e - some global elementor var that can trigger hooks 
				$e.run("document/elements/reset-style", { container: opt.getContainer() });
				
				// Reset select 
				$('[class*=crel_Generic__Presets] select').val('');
				// Reset select in elementor object 
				e.setSettingsModel("");
            });
			
		},

		// Change hook - main thing there 
		onBaseInputChange: function (e) {
			let $select = $(e.currentTarget);
			let $wrap = $select.closest('.elementor-control');
			let val = $select.val();
			let data = {};

			// usual preset
			$select.find('option').each(function(){
				if ( $(this).val() == val ) {
					data = $(this).data('value');

					if ( data && typeof data == 'string' ) {
						data = JSON.parse(data);
					}
				}
			});

			// custom preset
			if ( typeof data == 'undefined' && typeof creative_preset_vars.custom_presets[val] !== 'undefined' ) {
				data = creative_preset_vars.custom_presets[val].options;
			}
			
			if ( typeof data == 'undefined' || ! data ) {
				return;
			}

			if ( val && $wrap.find('.crel-button-update-preset').length ) {
				$wrap.find('.crel-button-update-preset').show();
				$wrap.find('.crel-new-preset-name').hide();
			}

			// object with all controls that we have 
			let controls = this.getElementSettingsModel().controls;
			let self = this;
			let newOptions = {};
			let selfName = self.model.get("name"); // current select name 
			newOptions[$select.data('setting')] = val;

			$.each(controls, function (name, el) {
				// if we look on not-current-select element and we should change it
				if ( selfName !== name && ( typeof data[name] !== 'undefined' ) ) {
					if ( el.is_repeater ) {

						let group = self.getElementSettingsModel().get(name).clone();
						
						group.each(function( groupEl, index ) {
							if ( typeof data[name][index] !== 'undefined' ) {
								$.each( groupEl.controls, function( grElIndex, El ){
									if ( self.isStyleTransferControl( El ) && typeof data[name][index][grElIndex] !== 'undefined' ) {
										group.at( index ).set(grElIndex, data[name][index][grElIndex]);
									}
								});
							}
						});
						newOptions[name] = group;
						
					} else if ( self.isStyleTransferControl(el) ) {
						newOptions[name] = data[name];
					}
				}
			});

			// update regular settings
			$e.run('document/elements/settings', {
				container: this.container,
				settings: newOptions,
				options: {
					external: true,
					render: false
				}
			});

			// reset global settings
			$e.run('document/globals/settings', {
				container: this.container,
				settings: {},
				options: {
					external: true,
					render: false
				}
			});

			// apply new globals if need
			if ( typeof data.__globals__ != 'undefined' ) {
				$e.run('document/globals/settings', {
					container: this.container,
					settings: data.__globals__,
					options: {
						external: true,
						render: false
					}
				});
			}

			// trigger update screen 
            this.container.render();

			// make Update button active
			$e.components.get('document/save').footerSaver.activateSaveButtons(document, true);
		},

		// settings of the current opened panel
		getElementSettingsModel: function () {
            return this.container.settings;
        },
		
		// check control if we need it 
		isStyleTransferControl: function(e){
			return ( typeof e !== 'undefined' ) && e.style_transfer ? e.style_transfer : "content" !== e.tab || e.selectors || e.prefix_class || e.force_preset;
		},

		onCreatePreset: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}
			let $wrap = $button.closest('.elementor-control-field');
			let $input = $wrap.find('.crel-create_preset-name');
			let $select = $wrap.find('select');
			let that = this;
			let $message = $wrap.find('.crel-update-preset-message');
			let widget_type = this.getElementSettingsModel().attributes.widgetType;

			// check field name not empty
			if ( ! $input.val() ) {
				$input.addClass('crel-new-preset-name--error');
				setTimeout(function(){
					$input.removeClass('crel-new-preset-name--error');
				}, 2000);
				return;
			}

			let settings = this.getSettings();

			let data = {
				action: 'crel-update-preset',
				crel_nonce: creative_preset_vars.nonce,
				options: settings,
				preset_name: $input.val(),
				widget_type: widget_type,
				preset_id: ''
			};

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: creative_preset_vars.ajax_url,
				data: data,
				beforeSend: function (xhr) {
					$button.find('.crel-button-state-icon').show();
					$button.find('.crel-button-label').hide();
					$message.html('');
				}
			}).done(function (response) {

				if (response.status == 'success') {
					$message.html(`<div class="crel-update-preset-message--success">${response.message}</div>`);

					setTimeout(function () {
						$message.html('');
					}, 2000);

					// update options and redraw
					creative_preset_vars.custom_presets[response.id] = response.preset;
					that.updateCustomSelect($wrap);
					$select.val(response.id);
					$select.trigger('change');

					setTimeout(function () {
						$wrap.find('.crel-panel-popup--save_preset').hide();
						$message.html('');
					}, 2000);
				} else {
					$wrap.find('.crel-update-preset-message').html(`<div class="crel-update-preset-message--error">${response.message}</div>`);
				}
			}).always(function () {
				$button.find('.crel-button-state-icon').hide();
				$button.find('.crel-button-label').show();
			});
		},

		getNotDefaultOptions: function(){
			let settings = {};
			let currentSettings = this.getElementSettingsModel().attributes;
			let defaultSettings = this.getElementSettingsModel().defaults;

			for( let name in currentSettings ) {
				if ( currentSettings[name] == defaultSettings[name] ) {
					continue;
				}

				settings[name] = currentSettings[name];
			}

			return settings;
		},

		onUpdatePreset: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}

			let $wrap = $button.closest('.elementor-control-field');
			let $select = $wrap.find('select');
			let that = this;
			let $message = $wrap.find('.crel-update-preset-message');
			let preset_id = $select.val();
			let $input = $wrap.find('.crel-update_preset-name');
			let widget_type = this.getElementSettingsModel().attributes.widgetType;

			// check field name not empty
			if ( ! $input.val() ) {
				$input.addClass('crel-new-preset-name--error');
				setTimeout(function(){
					$input.removeClass('crel-new-preset-name--error');
				}, 2000);
				return;
			}

			let settings = this.getSettings();

			let data = {
				action: 'crel-update-preset',
				crel_nonce: creative_preset_vars.nonce,
				options: $wrap.find('.crel-update_preset-confirm:checked').length == 0 ? '' : settings,
				preset_name: $input.val(),
				widget_type,
				preset_id
			};

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: creative_preset_vars.ajax_url,
				data: data,
				beforeSend: function (xhr) {
					$button.find('.crel-button-state-icon').show();
					$button.find('.crel-button-label').hide();
					$message.html('');
				}
			}).done(function( response ){

				if ( response.status == 'success' ) {
					$message.html( `<div class="crel-update-preset-message--success">${response.message}</div>` );

					setTimeout(function(){
						$wrap.find('.crel-panel-popup--update_preset').hide();
						$message.html('');
					}, 2000);

					// update options and redraw
					if ( $wrap.find('.crel-update_preset-confirm:checked').length && data.options ) {
						creative_preset_vars.custom_presets[preset_id].options = JSON.parse( data.options );
						$select.trigger('change');
					}

					creative_preset_vars.custom_presets[preset_id].title = response.new_name;

					that.updateCustomSelect( $wrap );
				} else {
					$wrap.find('.crel-update-preset-message').html( `<div class="crel-update-preset-message--error">${response.message}</div>` );
				}
			}).always(function(){
				$button.find('.crel-button-state-icon').hide();
				$button.find('.crel-button-label').show();
			});
		},

		onDeletePreset: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}

			let $wrap = $button.closest('.elementor-control-field');
			let $select = $wrap.find('select');
			let that = this;
			let $message = $wrap.find('.crel-update-preset-message');
			let preset_id = $select.val();
			let name = '';

			$select.find('option').each(function(){
				if ( $(this).val() == preset_id ) {
					name = $(this).text();
				}
			});

			let data = {
				action: 'crel-delete-preset',
				crel_nonce: creative_preset_vars.nonce,
				preset_id: preset_id
			};

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: creative_preset_vars.ajax_url,
				data: data,
				beforeSend: function (xhr) {
					$button.find('.crel-button-state-icon').show();
					$button.find('.crel-button-label').hide();
					$message.html('');
				}
			}).done(function( response ){

				if ( response.status == 'success' ) {
					$message.html( `<div class="crel-update-preset-message--success">${response.message}</div>` );

					setTimeout(function(){
						$wrap.find('.crel-panel-popup--update_preset').hide();
						$wrap.find('.crel-panel-popup--update_preset_2').hide();
						$wrap.find('.crel-panel-popup--update_preset_1').show();
						$message.html('');

						// update options and redraw
						delete creative_preset_vars.custom_presets[preset_id];
						that.updateCustomSelect( $wrap );
						$select.val('');
						$select.trigger('change');
					}, 2000);
				} else {
					$wrap.find('.crel-update-preset-message').html( `<div class="crel-update-preset-message--error">${response.message}</div>` );
				}
			}).always(function(){
				$button.find('.crel-button-state-icon').hide();
				$button.find('.crel-button-label').show();
			});
		},

		updateCustomSelect: function( $wrap ) {
			let $select = $wrap.find('[data-setting=crel_Generic__Custom_Presets]');
			let currentValue = this.getElementSettingsModel().attributes['crel_Generic__Custom_Presets'];
			let widget_type = this.getElementSettingsModel().attributes.widgetType;
			let hasOptions = false;

			// fill custom presets select
			$select.html(`<option value="" selected>${creative_preset_vars.select_preset_title}</option>`);


			for ( let preset_id in creative_preset_vars.custom_presets ) {
				if ( creative_preset_vars.custom_presets[preset_id].widget_type != widget_type ) {
					continue;
				}

				$select.append(`<option value="${preset_id}">${creative_preset_vars.custom_presets[preset_id].title}</option>`);
				hasOptions = true;
			}

			let $opts_list = $select.find('option');
			$opts_list.sort(function(a, b) {
				return $(a).text().localeCompare( $(b).text(), 'standard', {numeric:true});
			});

			$select.html('').append($opts_list);
			$select.val( currentValue );

			if ( hasOptions ) {
				$select.closest('.elementor-control').removeClass( 'crel-preset-wrap-empty' );
			} else {
				$select.closest('.elementor-control').addClass( 'crel-preset-wrap-empty' );
			}
		},

		getSettings: function() {
			let options = Object.assign({}, this.getElementSettingsModel().attributes );

			// exclude some settings
			for ( let option_name in options ) {

				if ( ~creative_preset_vars.excluded_options.indexOf( option_name ) ) {
					delete options[option_name];
				}
			}

			return JSON.stringify(options);
		},


		onOpenUpdate: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}

			let $wrap = $button.closest('.elementor-control');
			let $select = $wrap.find('select');
			let preset_id = $select.val();

			// clean checkbox
			$wrap.find('.crel-update_preset-confirm').prop('checked', false);

			// check field select not empty
			if ( ! preset_id ) {
				$select.addClass('crel-new-preset-name--error');
				setTimeout(function(){
					$select.removeClass('crel-new-preset-name--error');
				}, 2000);
				return;
			}

			$wrap.find('.crel-update_preset-name').val( $select.find('option[value='+preset_id+']').text() );
			$wrap.find('.crel-update-preset-message').html('');

			$wrap.find('.crel-panel-popup--save_preset').hide();
			$wrap.find('.crel-panel-popup--update_preset').show();

			return false;
		},

		onOpenSave: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}

			let $wrap = $button.closest('.elementor-control');
			let $select = $wrap.find('select');
			$select.val('');

			$wrap.find('.crel-create_preset-name').val('');
			setTimeout( function() {
				$wrap.find('.crel-create_preset-name').get(0).focus();
			}, 100 );
			$wrap.find('.crel-update-preset-message').html('');

			$wrap.find('.crel-panel-popup--update_preset').hide();
			$wrap.find('.crel-panel-popup--save_preset').show();

			return false;
		},

		onCancelPreset: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}

			$button.closest('.crel-panel-popup').hide();
			return false;
		},

		onPreDeletePreset: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}

			let $wrap = $button.closest('.elementor-control-field');

			$wrap.find('.crel-panel-popup--update_preset_1').hide();
			$wrap.find('.crel-panel-popup--update_preset_2').show();
			return false;
		},

		onCancelDeletePreset: function(e){
			let $button = $(e.target);

			// elementor bug
			if ( ! $button.hasClass('elementor-button') ) {
				$button = $button.closest('.elementor-button');
			}

			let $wrap = $button.closest('.elementor-control-field');

			$wrap.find('.crel-panel-popup--update_preset_2').hide();
			$wrap.find('.crel-panel-popup--update_preset_1').show();
			return false;
		}

	});
	
	// Add functions to the select control  https://developers.elementor.com/creating-a-new-control/
	// Here we change elementor class to elementor+our functions, add some our events to Elementor Select input 
	elementor.addControlView( 'creative_preset', creativePreset );

})( window.jQuery, window.elementor);

jQuery(document).ready(function($) {
	// Regular wp scripts 
	/** Presets v2 */
	$(document).on( 'change', '[data-setting=crel_presets_v2_general]', function(){
		let container = $(this).closest('#elementor-controls');
		let that = $(this);
		
		container.find('.crel-preset-v2__select').each(function(){
			
			$(this).find('select').val('');
			
			if ( that.val() && $(this).hasClass( that.val() ) ) {
				$(this).css({ 'display' : 'flex' });
				$(this).find('select').val( $(this).find('option').eq(0).val() );
				$(this).find('select').trigger('change');
				
				if ( $(this).hasClass('style') ) {
					crel_presets_selectchange($(this).find('select'));
					
				}
			} else {
				$(this).css({ 'display' : 'none' });
			}

		});
	});
	
	$(document).on( 'change', '.crel-preset-v2__select.style select', function(){
		crel_presets_selectchange($(this))
	});
	
	function crel_presets_selectchange( $select ) {
		let option = false;
		let val = $select.val();
		
		$select.find('option').each(function(){
			if ( $(this).val() == val ) {
				option = $(this);
			}
		});
		
		if ( ! option ) {
			return true;
		}
		
		option.closest('#elementor-controls').find('.crel-preset-v2__select.color').each(function(){
			
			if ( $(this).css('display') !== 'flex' ) {
				return true;
			}
			
			// check only visible  and check first visible 
			let check = false;
			
			$(this).find('option').each(function(){
				if ( ! option.data('colors') || !$(this).val() || ~option.data('colors').indexOf( $(this).val() ) ) {
					// found 	
					$(this).show();
					
					if ( ! check ) {
						
						check = true;
						let select = $(this).closest('select');
						select.val($(this).val());
						
						// let give elementor run all hooks and draw front
						setTimeout(function(){
							select.trigger( 'change' );
						}, 50);
					}
				} else {
					
					$(this).hide();
				}
			});
			
		});
	}
	/** End presets v2 */
});