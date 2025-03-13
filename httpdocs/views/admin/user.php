<?php

/** Check que l'id existe
 * -> si existe afficher == ok
 * _> si existe pas affiche blanco
 * si vide blanco aussi
 */

if ( ! empty( $_GET['user_id'] )) {
	$sql = "SELECT *
		FROM users
		WHERE id = :user_id";

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':user_id', $_GET['user_id']);

	$stmt->execute();
	$result = $stmt->fetch();
}

// UPDATE if submit and exist
if ( ! empty( $_GET['user_id'] ) && ! empty( $_POST ) ) {
	// Basic honeypot
	if ( ! empty($_POST['confirm_email']) ) {
		die('No bots allowed here.');
	}

	$name = htmlentities(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$email = htmlentities(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
	$password = htmlentities(trim($_POST['password']), ENT_QUOTES, 'UTF-8');
	$password_confirmation = htmlentities(trim($_POST['confirm_password']), ENT_QUOTES, 'UTF-8');

	if ( ! empty($password) & $password === $password_confirmation) {
		$sql = "UPDATE users
				SET name = :name, email = :email, password = :password WHERE id = :user_id";
	} else {
		$sql = "UPDATE users
				SET name = :name, email = :email WHERE id = :user_id";
	}

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':user_id', $_GET['user_id']);

	if ( ! empty($password) & $password === $password_confirmation) {
		$stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
	}

	$stmt->execute();
}

?>

<section class="edit-listing">
	<header>
		<?php if ( isset( $_GET['user_id'] ) ) : ?>
			<h1>Modifier un user</h1>
			<a class="button" href="/admin/user/edit?post_type=user">Add new</a>
		<?php else : ?>
			<h1>Ajouter un user</h1>
		<?php endif; ?>
	</header>

	<div>
		<form action="" method="POST" novalidate>
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

			<div class="form-row form-row--submit">
				<button class="button" type="submit">Submit</button>
			</div>
		</form>
	</div>
</section>
