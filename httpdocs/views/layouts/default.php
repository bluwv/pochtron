<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Catalogue</title>

	<link rel="stylesheet" href="https://pochtron.localhost/assets/css/app.css">
</head>

<body class="<?php echo $body_class; ?>">

	<div class="site">
		<?php include_once 'views/layouts/header.php'; ?>

		<main class="site-main">

			<?php include $file; ?>

		</main>

		<?php include_once 'views/layouts/footer.php'; ?>
	</div>

	<script src="https://pochtron.localhost/assets/js/app.js"></script>

</body>
</html>
