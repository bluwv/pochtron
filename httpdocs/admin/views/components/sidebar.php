<?php

$sql = "SELECT *
		FROM users
		WHERE id = :user_id";

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':user_id', $_SESSION['user_id']);

	$stmt->execute();
	$user = $stmt->fetch();

	// var_dump($user);
?>

<div class="admin-menu">
	<a href="#">pochtron.be</a>

	<form action="#" method="GET" novalidate>
		<label for="search" class="screen-reader-text">search</label>
		<input id="search" type="search" name="search" placeholder="Recherche">
	</form>

	<nav class="menu-primary menu">
		<ul>
			<li class="<?php echo ( ! isset( $_GET['post_type'] ) ) ? 'active' : ''; ?>">
				<a href="">Tableau de bord</a>
			</li>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'wine' ) ? 'active' : ''; ?>">
				<a href="list.php?post_type=wine">Vins</a>
			</li>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'producer' ) ? 'active' : ''; ?>">
				<a href="domain.php?post_type=producer">Domaines</a>
			</li>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'grape' ) ? 'active' : ''; ?>">
				<a href="list.php?post_type=grape">Cépages</a>
			</li>
		</ul>
	</nav>

	<nav class="menu-secondary menu">
		<ul>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'user' ) ? 'active' : ''; ?>">
				<a href="users.php?post_type=user">Utilisateurs</a>
			</li>
			<li>
				<a href="#">Notifications</a>
			</li>
			<li>
				<a href="#">Paramètres</a>
			</li>
			<li>
				<a href="#">Aide</a>
			</li>
		</ul>
	</nav>

	<div class="sidebar-current-user">
		<a href="user.php?post_type=user&user_id=<?php echo $user->id; ?>">
			<img src="assets/icons/profile.svg" alt="">
			<p><?php echo $user->name; ?></p>
		</a>

		<button class="button-sidebar button" data-action="user-action">…</button>

		<menu class="" data-reaction="user-action">
			<ul>
				<li>
					<a href="user.php?post_type=user&user_id=<?php echo $user->id; ?>">Modifier le profil</a>
				</li>
				<li>
					<a class="logout" href="logout.php">Déconnexion</a>
				</li>
			</ul>
		</menu>
	</div>

	<button class="button-sidebar-expand button" data-id="collapse-menu"></button>
</div>
