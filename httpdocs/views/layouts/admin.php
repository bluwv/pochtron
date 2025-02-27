<?php

session_start();

if ( ! empty ($_SESSION) && $_SESSION['timeout'] < time() ) {
	session_destroy();
	header('Location: /admin/login');
	exit();
}

require_once '../app/database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Catalogue</title>

	<link rel="stylesheet" href="https://pochtron.localhost/admin/assets/css/app.css">
</head>

<body class="admin <?php echo $body_class; ?>">

	<div id="app" class="site">
		<?php // include_once 'views/layouts/header.php'; ?>

		<main class="site-main <?php echo $body_class; ?>">

			<?php include $file; ?>

			<?php
			if ( $body_class != 'login' ) {
				include_once 'views/components/sidebar.php';
			}
			?>

		</main>

		<?php if ( in_array($body_class, ['list', 'edit']) ) : ?>
			<aside class="modals">
				<section class="modal" data-modal="delete">
					<p>Placeholder vraiment supprimer</p>

					<form action="/admin/wines/list" method="POST" novalidate>
						<input type="hidden" name="wine_id" value="">

						<button class="button-cancel button" type="button" data-cancel="modal">Annuler</button>
						<button class="button-delete button" type="submit" name="delete">Delete ?</button>
					</form>
				</section>
			</aside>
		<?php endif; ?>

		<?php // include_once 'views/layouts/footer.php'; ?>
	</div>

	<script src="https://pochtron.localhost/admin/assets/js/app.js"></script>

</body>
</html>
