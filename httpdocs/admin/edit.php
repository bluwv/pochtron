<?php

session_start();

/** Check que l'id existe
 * -> si existe afficher == ok
 * _> si existe pas affiche blanco
 * si vide blanco aussi
 */

require_once '../../app/database.php';

if ( ! empty( $_GET['wine_id'] )) {

	// $sql = "SELECT id
	// 	FROM wines
	// 	WHERE id = " . $_GET['wine_id'];

	// $stmt = $db->prepare($sql);
	// $stmt->execute();
	// $has_wine = $stmt->fetch();

	// var_dump($has_wine);
	// die();

	// if ( $has_wine ) {
		// header('Location:');
	// }

	if ( ! empty( $_POST ) ) {
		$sql = "UPDATE wines
			SET name = :name
			WHERE id = :wine_id";

		$stmt = $db->prepare($sql);

		$stmt->bindValue(':name', $_POST['name']);
		$stmt->bindValue(':wine_id', $_GET['wine_id']);

		$stmt->execute();
	}

	$sql = "SELECT wines.id as wine_id, wines.name, grapes.color, producers.domain, producers.region, wines.year, wines.price, wines.format, wines.stock, grapes.name as grapes_name
		FROM wines
		JOIN producers ON wines.id_producer = producers.id
		JOIN grapes ON wines.id_grapes = grapes.id
		WHERE wines.id = " . $_GET['wine_id'];

	$stmt = $db->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetch();
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
					<h1>Ajouter un vin</h1>
				</header>

				<div>
					<form action="#" method="POST" novalidate>
						<div class="form-row">
							<label for="name">Nom</label>
							<input id="name" type="text" name="name" placeholder="name" value="<?php echo (! empty($result)) ? $result->name : ""; ?>" required>
						</div>

						<div class="form-row">
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
						</div>

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
							<label for="stock"></label>
							<input id="stock" type="text" name="stock" placeholder="stock" value="<?php echo (! empty($result)) ?$result->stock : ""; ?>" required>
						</div>

						<div class="form-row">
							<label for="grapes_name">Raisin(s)</label>
							<input id="grapes_name" type="text" name="grapes_name" placeholder="grapes_name" value="<?php echo (! empty($result)) ? $result->grapes_name : ""; ?>" required>
						</div>

						<button>Submit</button>
					</form>
				</div>
			</section>

			<div class="admin-menu">
				<a href="#">Pochtron.be</a>
				<a class="logout" href="#">Déconnexion</a>
			</div>
		</main>
	</div>

</body>
</html>
