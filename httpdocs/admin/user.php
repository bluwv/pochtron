<?php

session_start();

/** Check que l'id existe
 * -> si existe afficher == ok
 * _> si existe pas affiche blanco
 * si vide blanco aussi
 */

require_once '../../app/database.php';

if ( ! empty( $_GET['user_id'] )) {

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
		if ( ! empty($_POST['confirm_email']) ) {
			die('No bots allowed here.');
		}

		$sql = "UPDATE users
			SET name = :name, email = :email, password = :password WHERE id = :user_id";
		$stmt = $db->prepare($sql);

		$stmt->bindValue(':name', $_POST['name']);
		$stmt->bindValue(':email', $_POST['email']);
		$stmt->bindValue(':user_id', $_GET['user_id']);
		$stmt->bindValue(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

		$stmt->execute();
	}

	$sql = "SELECT *
		FROM users
		WHERE id = :user_id";

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':user_id', $_GET['user_id']);

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
					<h1>Ajouter un user</h1>
				</header>

				<div>
					<form action="#" method="POST" novalidate>
						<div class="form-row">
							<label for="name">Nom</label>
							<input id="name" type="text" name="name" placeholder="name" value="<?php echo (! empty($result)) ? $result->name : ""; ?>" required>
						</div>

						<div class="form-row">
							<label for="login">Login</label>
							<input id="login" type="text" name="login" placeholder="login" value="<?php echo (! empty($result)) ? $result->login : ""; ?>" disabled>
						</div>

						<div class="form-row">
							<label for="email">Email</label>
							<input id="email" type="email" name="email" placeholder="email" value="<?php echo (! empty($result)) ?$result->email : ""; ?>" required>
						</div>

						<div class="form-row honeypot">
							<label for="confirm_email">Confirm mail</label>
							<input id="confirm_email" type="confirm_email" name="confirm_email" placeholder="confirm_email" value="">
						</div>

						<div class="form-row">
							<label for="password">Password</label>
							<input id="password" type="password" name="password" placeholder="password" value="" required>
						</div>

						<div class="form-row">
							<label for="confirm_password">Confirm password</label>
							<input id="confirm_password" type="password" name="confirm_password" placeholder="confirm_password" value="" required>
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
