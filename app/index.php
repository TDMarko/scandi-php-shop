<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Senior Test Assignment</title>
	<meta name="description" content="Senior Test Assignment">
	<meta name="author" content="Mark Timofeyev">
	<link rel="stylesheet" href="styles/reset.css?v=1.0">
	<link rel="stylesheet" href="styles/main.css?v=1.0">

	<!-- External libraries, bad practice to include them from unknown sources, but no time :( -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Karla" rel="stylesheet">
</head>
<body class="app">
	<header>
		<div class="title">Products</div>
		<div class="button green" id="add-product">Add product</div>
	</header>
	<!-- This is not proper SPA way, we can use Router to make one, will remake if necessary -->
	<div class="modal-add-product invisible" id="modal-add-product">
		<form name="form-add-product" id="form-add-product" method="post">
			<div class="form-add-product">
				<div class="response-row invisible" id="response-row"></div>
				<div class="form-row">
					<label for="sku">SKU</label>
					<input type="text" name="sku" id="sku">
				</div>
				<div class="form-row">
					<label for="name">Name</label>
					<input type="text" name="name" id="name">
				</div>
				<div class="form-row">
					<label for="price">Price (EUR)</label>
					<input type="text" name="price" id="price">
				</div>
				<div class="form-row">
					<label for="type">Type</label>
					<select name="type" id="type">
						<option value="0" selected></option>
						<option value="1">DVD-disk</option>
						<option value="2">Book</option>
						<option value="3">Furniture</option>
					</select>
				</div>
				<div class="form-row invisible attribute" data-id="1">
					<label for="size">Size</label>
					<input type="text" name="size" id="size">
				</div>
				<div class="form-row invisible attribute" data-id="2">
					<label for="weight">Weight</label>
					<input type="text" name="weight" id="weight">
				</div>
				<div class="form-row invisible attribute" data-id="3">
					<label for="hwl">Height/Width/Length (format: HxWxL)</label>
					<input type="text" name="hwl" id="hwl">
				</div>
				<div class="form-row">
					<div class="button green big" id="save-product">Save</div>
				</div>
			</div>
		</form>
	</div>
	<div id="container" class="container"></div>
	<script src="scripts/main.js"></script>
</body>
</html>