$(document).ready(function() {
	/*
	 * Sort of config
	 */
	APP_DEFAULT_CURRENCY = 'EUR';

	/*
	 * Service
	 */
	const url = 'http://localhost:44/api/product/get.php',
		  app = $('.app'),
		  container = $('#container', app);

	function getProducts() {
		container.empty();

		// We can use ES6 promises or jQueries $.when or AJAX here
		fetch(url).then(response => {
			return response.json();
		}).then(data => {
			if (data.status === 'success') {
				data.message.forEach(function (item) {
					// Normally should create separate jQuery objects for each item, I hope you will forgive me for plain HTML here
					var product =
						'<div>' + item.sku + '</div>' +
						'<div>' + item.name + '</div>' +
						'<div>' + item.price + ' ' + APP_DEFAULT_CURRENCY + '</div>' +
						'<div>' + item.attribute + '</div>';

					container.append(
						$('<div>').addClass('product-item').html(product)
					);
				});
			} else {
				container.append(
					$('<div>').addClass('product-not-found').html('<div>No data found!</div>')
				);

				console.log(data.message);
			}
		}).catch(error => {
			//TODO: error
		});
	}

	getProducts();

	/*
	 * Add product
	 */
	const addProductButton = $('#add-product', app),
		  productModalWindow = $('#modal-add-product', app),
		  productModal = $('#modal-add-product', app),
		  productForm = $('#form-add-product', app),
		  productType = $('#type', productForm),
		  productSave = $('#save-product', productModal);

	addProductButton.on('click', function() {
		if (productModalWindow.is(":visible")) {
			productModalWindow.addClass('invisible');
			$('#response-row', productForm).addClass('invisible'); //TODO: you can make it better, add const
			addProductButton.css({ background: '#7ccc4f' }).text('Add product');
		} else {
			productModalWindow.removeClass('invisible');
			addProductButton.css({ background: '#cc3646' }).text('Cancel');
		}
	});

	productType.on('change', function() {
		const type = productType.val(),
			  attribute = productModal.find(`[data-id='${type}']`);

		$('.attribute').addClass('invisible');
		attribute.removeClass('invisible');
	});

	productSave.on('click', function() {
		const inputSku = $('#sku', productForm),
			  inputName = $('#name', productForm),
			  inputPrice = $('#price', productForm),
			  inputType = $('#type', productForm),
			  responseRow = $('#response-row', productForm);

		let error = false;

		$('.error').remove();
		responseRow.removeClass('red green').addClass('invisible');

		// This is most basic and stupid validation
		if (inputSku.val().length < 1) {
			inputSku.after('<span class="error">This field is required</span>');
			error = true;
		}
		if (inputName.val().length < 1) {
			inputName.after('<span class="error">This field is required</span>');
			error = true;
		}
		if (inputPrice.val().length < 1) {
			inputPrice.after('<span class="error">This field is required</span>');
			error = true;
		}
		if (inputType.val() == 0) {
			inputType.after('<span class="error">This field is required</span>');
			error = true;
		}

		if (!error) {
			responseRow.removeClass('invisible');

			$.get('http://localhost:44/api/product/add.php', productForm.serialize(), function (data) {
				if (data.status === 'error') {
					responseRow.removeClass('invisible').addClass('red').text(data.message);
				}
				if (data.status === 'success') {
					responseRow.removeClass('invisible').addClass('green').text(data.message);
					productForm.find('input[type=text], textarea').val('');
					getProducts();
				}
				}, 'json');
		}
	});
});
