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
			<li>
				<a href="#">Tableau de bord</a>
			</li>
			<li class="active">
				<a href="list.php">Vins</a>
			</li>
			<li>
				<a href="domain.php">Domaines</a>
			</li>
			<li>
				<a href="grapes.php">Cépages</a>
			</li>
		</ul>
	</nav>

	<nav class="menu-secondary menu">
		<ul>
			<li>
				<a href="users.php">Utilisateurs</a>
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

	<div>
		<img src="" alt="">
		<p><?php echo $user->name; ?></p>
		<button data-action="user-action">…</button>
		<menu class="" data-reaction="user-action">
			<ul>
				<li>
					<a href="user.php?id=<?php echo $user->id; ?>">Modifier le profil</a>
				</li>
				<li>
					<a class="logout" href="logout.php">Déconnexion</a>
				</li>
			</ul>
		</menu>
	</div>

	<button class="button-sidebar-expand" data-id="collapse-menu">…</button>
</div>
