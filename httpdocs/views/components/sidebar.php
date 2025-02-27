<?php

$sql = "SELECT *
	FROM users
	WHERE id = :user_id";

$stmt = $db->prepare($sql);

$stmt->bindValue(':user_id', $_SESSION['user_id']);

$stmt->execute();
$user = $stmt->fetch();


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
				<a href="#">Tableau de bord</a>
			</li>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'wine' ) ? 'active' : ''; ?>">
				<a href="/admin/wines/list?post_type=wine">Vins</a>
			</li>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'producer' ) ? 'active' : ''; ?>">
				<a href="/admin/domains/list?post_type=producer">Domaines</a>
			</li>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'grape' ) ? 'active' : ''; ?>">
				<a href="/admin/grapes/list?post_type=grape">Cépages</a>
			</li>
		</ul>
	</nav>

	<nav class="menu-secondary menu">
		<ul>
			<li class="<?php echo ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'user' ) ? 'active' : ''; ?>">
				<a href="/admin/users/list?post_type=user">Utilisateurs</a>
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
		<a href="/admin/user/edit?post_type=user&user_id=<?php echo $user->id; ?>">
			<img src="https://pochtron.localhost/admin/assets/icons/profile.svg" alt="">
			<p><?php echo $user->name; ?></p>
		</a>

		<button class="button-sidebar button" data-action="user-action">…</button>

		<menu class="" data-reaction="user-action">
			<ul>
				<li>
					<a href="/admin/user/edit?post_type=user&user_id=<?php echo $user->id; ?>">Modifier le profil</a>
				</li>
				<li>
					<a class="logout" href="/admin/logout">Déconnexion</a>
				</li>
			</ul>
		</menu>
	</div>

	<button class="button-sidebar-expand button" data-id="collapse-menu"></button>
</div>
