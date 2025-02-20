<?php

session_start();

if ( $_SESSION['timeout'] < time() ) {
	session_destroy();
	header('Location: login.php');
	exit();
}

/** Check que l'id existe
 * -> si existe afficher == ok
 * _> si existe pas affiche blanco
 * si vide blanco aussi
 */

// TODO: Bien check que je ne peux delete que le product que je visualise
// TODO: Problème de double submission to bypass => soit ajax soit / unset form

require_once 'app/database.php';

// SELECT
if ( ! empty( $_GET['wine_id'] ) ) {
	$sql = "SELECT wines.id as wine_id, wines.name, grapes.color, producers.domain, producers.region, wines.year, wines.price, wines.format, wines.stock, grapes.name as grapes_name
		FROM wines
		LEFT JOIN producers ON wines.id_producer = producers.id
		LEFT JOIN grapes ON wines.id_grapes = grapes.id
		WHERE wines.id = " . $_GET['wine_id'];

	$stmt = $db->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetch();
}

// DELETE
if ( isset( $_POST['delete'] ) ) {
	$sql = "DELETE FROM wines
			WHERE wines.id = :wine_id";

	$stmt = $db->prepare($sql);
	$stmt->execute([':wine_id' => $_POST['delete']]);

	header('Location: list.php');
	exit();
}

// UPDATE si on submit un "wine" existant
if ( ! empty( $_GET['wine_id'] ) && ! empty( $_POST ) ) {
	$name = htmlentities(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$year = htmlentities(trim($_POST['year']), ENT_QUOTES, 'UTF-8');
	$price = htmlentities(trim($_POST['price']), ENT_QUOTES, 'UTF-8');
	$format = htmlentities(trim($_POST['format']), ENT_QUOTES, 'UTF-8');
	$stock = htmlentities(trim($_POST['stock']), ENT_QUOTES, 'UTF-8');

	$sql = "UPDATE wines
		SET name = :name, year = :year, price = :price, format = :format, stock = :stock
		WHERE id = :wine_id";

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':year', $year);
	$stmt->bindValue(':price', $price);
	$stmt->bindValue(':format', $format);
	$stmt->bindValue(':stock', $stock);
	$stmt->bindValue(':wine_id', $_GET['wine_id']);

	$stmt->execute();
}

// INSERT INTO si on submit un "wine" vide
if ( ! empty($_POST) && empty( $_GET['wine_id'] ) ) {
	$name = htmlentities(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$year = htmlentities(trim($_POST['year']), ENT_QUOTES, 'UTF-8');
	$price = htmlentities(trim($_POST['price']), ENT_QUOTES, 'UTF-8');
	$format = htmlentities(trim($_POST['format']), ENT_QUOTES, 'UTF-8');
	$stock = htmlentities(trim($_POST['stock']), ENT_QUOTES, 'UTF-8');

	$sql = "INSERT INTO wines (name, year, price, format, stock)
		VALUES (:name, :year, :price, :format, :stock)";

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':name', $name);
	// $stmt->bindValue(':title', $_POST['title']);
	$stmt->bindValue(':year', $year);
	$stmt->bindValue(':price', $price);
	$stmt->bindValue(':format', $format);
	$stmt->bindValue(':stock', $stock);
	// $stmt->bindValue(':stars', $_POST['wine_id']);
	// $stmt->bindValue(':notes', $_POST['wine_id']);

	$stmt->execute();
	$new_id = $db->lastInsertId();
	header("Location: edit.php?post_type=wine&wine_id=" . $new_id);
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pochtron</title>
	<link rel="stylesheet" href="assets/css/app.css">
</head>

<body class="admin edit">

	<div id="app">
		<main class="site-main">
			<section class="edit-listing">
				<header>
					<?php if ( isset( $_GET['wine_id'] ) ) : ?>
						<h1>Modifier un vin</h1>
						<a class="button" href="edit.php?post_type=wine">Add new</a>
					<?php else : ?>
						<h1>Ajouter un vin</h1>
					<?php endif; ?>
				</header>

				<div>
					<form action="" method="POST" novalidate>
						<div class="form-row">
							<label for="name">Nom</label>
							<input id="name" type="text" name="name" placeholder="name" value="<?php echo (! empty($result)) ? $result->name : ""; ?>" required>
						</div>

						<!-- <div class="form-row">
							<label for="color">Couleur</label>
							<input id="color" type="text" name="color" placeholder="color" value="<?php echo (! empty($result)) ?$result->color : ""; ?>" required>
						</div>

						<div class="form-row">
							<label for="domain">Domaine</label>
							<input id="domain" type="text" name="domain" placeholder="domain" value="<?php echo (! empty($result)) ?$result->domain : ""; ?>" required>
						</div>

						<div class="form-row">
							<label for="region">Région</label>
							<input id="region" type="text" name="region" placeholder="region" value="<?php echo (! empty($result)) ?$result->region : ""; ?>" required>
						</div> -->

						<div class="form-row">
							<label for="year">Millésime</label>
							<input id="year" type="text" name="year" placeholder="year" value="<?php echo (! empty($result)) ?$result->year : ""; ?>" required>
						</div>

						<div class="form-row">
							<label for="price">Prix</label>
							<input id="price" type="text" name="price" placeholder="price" value="<?php echo (! empty($result)) ?$result->price : ""; ?>" required>
						</div>

						<div class="form-row">
							<label for="format">Format</label>
							<input id="format" type="text" name="format" placeholder="format" value="<?php echo (! empty($result)) ?$result->format : ""; ?>" required>
						</div>

						<div class="form-row">
							<label for="stock">Stock</label>
							<input id="stock" type="text" name="stock" placeholder="stock" value="<?php echo (! empty($result)) ?$result->stock : ""; ?>" required>
						</div>

						<!-- <div class="form-row">
							<label for="grapes_name">Raisin(s)</label>
							<input id="grapes_name" type="text" name="grapes_name" placeholder="grapes_name" value="<?php echo (! empty($result)) ? $result->grapes_name : ""; ?>" required>
						</div> -->

						<div class="form-row form-row--submit">
							<button class="button-submit button" type="submit">Submit</button>

							<?php if ( ! empty( $_GET['wine_id'] ) ) : ?>
								<button class="button-delete button" type="button" data-show="delete">Delete ?</button>
							<?php endif; ?>
						</div>
					</form>
				</div>
			</section>

			<?php include_once 'views/components/sidebar.php'; ?>
		</main>

		<aside class="modals">
			<section class="modal" data-modal="delete">
				<p>Placeholder vraiment supprimer</p>

				<?php if ( ! empty( $_GET['wine_id'] ) ) : ?>
					<form action="edit.php?post_type=wine&wine_id=<?php echo $_GET['wine_id']; ?>" method="POST" novalidate>
						<button class="button-cancel button" type="button" data-cancel="modal">Annuler</button>
						<button class="button-delete button" type="submit" name=delete value="<?php echo $_GET['wine_id']; ?>">Delete ?</button>
					</form>
				<?php endif; ?>
			</section>
		</aside>
	</div>

	<script src="assets/js/app.js"></script>
</body>
</html>
