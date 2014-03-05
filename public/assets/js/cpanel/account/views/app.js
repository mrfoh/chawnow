define(function() {

	var AppView = Backbone.View.extend({
		el: "#account-app",

		ui: {
			"form": "#user-form",
			"logopreview": ".logo-thumbnail",
			"city": "#city",
			"area": "#area",
			"logistics": "#logistics-info"
		},

		events: {
			"change #city":"onCityChange",
			"change #deliveries":"onDeliveriesChange",
			"change #pickups": "onPickupChange",
			"click .remove-trigger": "removeLogo",
			"click #upload-btn": "uploadLogo"
		},

		validationRules: {
			name: {
				required: true
			},
			address: {
				required: true
			},
			minimuim_order: {
				required: true,
				number: true
			},
			order_limit: {
				number: true
			},
			delivery_fee: {
				number: true
			},
			email: {
				email: true
			},
			phone: {
				numeric: true
			}
		},

		setUpUi: function() {
			var self = this;

			_.each(_.keys(self.ui), function(key) {
			    var selector = self.ui[key];
			    this.ui[key] = $(selector);
			}, this);

		},

		initUploader: function() {
			//instantiate uploader object
			var uploader = new plupload.Uploader({
				runtimes: 'html5,flash',
				browse_button: 'upload-trigger',
				url: Cpanel.Constants.url+"/upload",
				max_file_size: '1mb',
				filters : [
				 { title : "Image files", extensions : "jpg,gif,png"}
				],
				flash_swf_url : Cpanel.Constants.url+"/js/plugins/plupload/Moxie.swf",
				unique_names: true,
				file_data_name: 'logo'
			});

			this.uploader = uploader;
			//start uploader
			this.uploader.init();
			//bind events
			this.uploader.bind('FilesAdded', this.logoAdded, this);
			this.uploader.bind('FileUploaded', this.logoUploaded, this);
		},

		logoAdded: function (uploader, files) {
			var preview = $('.logo-thumbnail'),
			    remove = preview.find('.remove-trigger'),
			    uploadbtn = $("#upload-btn");

			//clear previous preview
			preview.find('canvas').remove();
			preview.find('img').remove();
			uploadbtn.show();

			$.each(files, function() {
					var self = this,
						img = new mOxie.Image();

					img.onload = function() {
						this.embed(preview.get(0), {
							width: 300,
							height: 200,
							crop: false
						});
					};

					img.onembedded = function() {
						this.destroy();
					};

					img.onerror = function() {
						this.destroy();
					};

					img.load(this.getSource()); 
			});

			remove.show();
		},

		logoUploaded: function (uploader, file, response)
		{
			var r = $.parseJSON(response.response);

			if(r.status == "success") {
				$('#upload-btn').html('<i class="icon-cloud-upload"></i> Uploaded').delay(3000).hide();
				$('#upload-btn').html('<i class="icon-cloud-upload"></i> Upload');

				$("input#logo").val(r.file.path);
			} 
		},

		initialize: function() {

			this.setUpUi();
			this.initUploader();
			this.bindPlugins();

			this.cities = new Backbone.Collection;
			this.cities.reset(locales);

			this.populateCityDropdown();
		},

		bindFormValidation: function()
		{
			var self = this;
			this.ui.form.validate({
				rules: this.validationRules,
				onfocusout: function (element) {
				        $(element).valid();
			    },
	            errorPlacement: function (label, element) { // render error placement for each input type   
					$('<span class="error"></span>').insertAfter(element).append(label)
	                 var parent = $(element).parent('.controls');
	                 parent.removeClass('success-control').addClass('error-control');  
	            },

	            success: function (label, element) {
					var parent = $(element).parent('.controls');
					parent.removeClass('error-control').addClass('success-control'); 
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
			});
		},

		bindPlugins: function() {

			this.bindFormValidation();

			var deliveries = $("#deliveries"),
				pickups = $("#pickups");

			if(deliveries.attr('data-checked') == "1")
			{
				var info = $("#delivery-info");
				deliveries.prop('checked', true);

				this.ui.logistics.show();
				info.show();
			}

			if(pickups.attr('data-checked') == "1")
			{
				var info = $("#pickup-info");
				pickups.prop('checked', true);

				this.ui.logistics.show();
				info.show();
			}

			_.each(cuisines, this.selectCuisine)
		},

		selectCuisine: function (cuisine) {
			var id = "#cuisine"+cuisine.cuisine_id;
			var field = $(id);
				field.prop('checked', true);
		},

		onCityChange: function (event) {
			var el = $(event.currentTarget),
				id = el.val(),
				city = this.cities.get(id);
				areas = city.get('areas');

			this.populateAreaDropdown(areas);
		},

		populateCityDropdown: function() {
			var self = this;

			this.cities.each(function(city) {
				self.ui.city.append('<option value="'+city.id+'">'+city.get('name')+'</option>')
			});

			//Set city if value is given
			if(this.ui.city.attr('data-select') != "none")
			{
				var id = this.ui.city.attr('data-select');
				var option = this.ui.city.find('option[value="'+id+'"]').prop('selected', true);

				city = this.cities.get(id);
				areas = city.get('areas');

				this.populateAreaDropdown(areas);
			}
		},

		populateAreaDropdown: function (areas) {
			var self = this;

			this.ui.area.removeAttr('disabled');
			_.each(areas, function(area) {
				self.ui.area.append('<option value="'+area.id+'">'+area.name+'</option>')
			}); 

			if(this.ui.area.attr('data-select') != "none")
			{
				var id = this.ui.area.attr('data-select');
				this.ui.area.find('option[value="'+id+'"]').prop('selected', true);
			}
		},

		onDeliveriesChange: function (event) {

			var el = $(event.currentTarget);
			var info = $('#delivery-info');
			var other = $('#pickups');
			if(el.prop('checked'))
			{
	            info.show();
	            if(!this.ui.logistics.is(':visible')) {
	            	this.ui.logistics.slideDown();
	            }
			}
			else
			{
				info.hide();
				if(!other.prop('checked'))
					this.ui.logistics.slideUp();
			}
		},

		onPickupChange: function (event) {
			var el = $(event.currentTarget);
			var info = $('#pickup-info');
			var other = $('#deliveries');
			if(el.prop('checked'))
			{
	            info.show();
	            if(!this.ui.logistics.is(':visible')) {
	            	this.ui.logistics.slideDown();
	            }
			}
			else
			{
				info.hide();
				if(!other.prop('checked'))
					this.ui.logistics.slideUp();
			}
		},

		removeLogo: function (event) {
			var el = $(event.currentTarget);

			if(el.attr('data-hide') == "true")
				el.hide();
			else
				this.ui.logopreview.find('a.remove-trigger').hide();
			//hide upload btn
			$('#upload-btn').hide();
			//remove canvas
			this.ui.logopreview.find('canvas').remove();
			//remove img
			this.ui.logopreview.find('img').remove();
			//remove logo src
			$('#logo').val('');

			event.preventDefault();
		},

		uploadLogo: function (event) {
			var el = $(event.currentTarget);
				el.html('<i class="icon-cloud-upload"></i> Uploading...');
				el.attr('disabled','disabled');

			this.uploader.start();
		}
	});

	return AppView;
})