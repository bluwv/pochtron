<?php

session_start();
if ( $_SESSION['token'] < time() ) {
	session_destroy();
	header('Location: login.php');
}

require_once '../../app/database.php';

$wines_limit = 20;
$wines_offset = ($_GET['page'] ?? 0) * $wines_limit;

$sql = "SELECT wines.id as wine_id, wines.name, grapes.color, producers.domain, producers.region, wines.year, wines.price, wines.format, wines.stock, grapes.name as grapes_name
		FROM wines
		JOIN producers ON wines.id_producer = producers.id
		JOIN grapes ON wines.id_grapes = grapes.id
		LIMIT $wines_limit OFFSET $wines_offset";

$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

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
					<h1>Listing des vins</h1>
					<a class="button" href="">Add new</a>
				</header>

				<div>
					FILTRE
				</div>

				<div>
					<table>
						<thead>
							<tr>
								<th>Nom</th>
								<th>Type</th>
								<th>Domaine</th>
								<th>Région</th>
								<th>Millésime</th>
								<th>Prix</th>
								<th>Format</th>
								<th>Stock</th>
								<th>Cépages</th>
								<th>Actions</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ( $results as $result ) : ?>
								<tr>
									<td>
										<a href="edit.php?wine_id=<?php echo $result->wine_id; ?>"><?php echo $result->name; ?></a>
									</td>
									<td><?php echo $result->color; ?></td>
									<td><?php echo $result->domain; ?></td>
									<td><?php echo $result->region; ?></td>
									<td><?php echo $result->year; ?></td>
									<td><?php echo $result->price; ?> <span>€</span></td>
									<td><?php echo $result->format; ?> <span>cl</span></td>
									<td><?php echo $result->stock; ?> <span>cl</span></td>
									<td><?php echo $result->grapes_name; ?></td>
									<td><button>…</button></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<?php if (count($results) > 20) : ?>
						<nav class="pagination">
							<ol>
								<li class="active">
									<a href="">1</a>
								</li>
								<li>
									<a href="">2</a>
								</li>
								<li>
									<a href="">3</a>
								</li>
								<li>
									<a href="">></a>
								</li>
							</ol>
						</nav>
					<?php endif; ?>
				</div>
			</section>

			<div class="admin-menu">
				<a href="#">Pochtron.be</a>
				<a class="logout" href="logout.php">Déconnexion</a>
			</div>
		</main>
	</div>

</body>
</html>
<?php

$stmt = null;
$db = null;

?>
