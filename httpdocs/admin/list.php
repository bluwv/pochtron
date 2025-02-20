<?php

session_start();

if ( $_SESSION['timeout'] < time() ) {
	session_destroy();
	header('Location: login.php');
	exit();
}

require_once 'app/database.php';

$wines_limit = 20;
$wines_offset = ($_GET['page'] ?? 0) * $wines_limit;

$sql = "SELECT wines.id as wine_id, wines.name, grapes.color, producers.domain, producers.region, wines.year, wines.price, wines.format, wines.stock, grapes.name as grapes_name
		FROM wines
		LEFT JOIN producers ON wines.id_producer = producers.id
		LEFT JOIN grapes ON wines.id_grapes = grapes.id
		LIMIT $wines_limit OFFSET $wines_offset";

$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

// DELETE

if ( isset( $_POST['delete'] ) && isset( $_POST['wine_id'] ) ) {
	$sql = "DELETE FROM wines
			WHERE wines.id = :wine_id";

	$stmt = $db->prepare($sql);
	$stmt->execute([':wine_id' => $_POST['wine_id']]);

	header('Location: list.php');
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
					<h1>Listing des vins</h1>
					<a class="button" href="edit.php?post_type=wine">Add new</a>
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
								<tr data-wineID="<?php echo $result->wine_id; ?>">
									<td data-content="Nom">
										<a href="edit.php?post_type=wine&wine_id=<?php echo $result->wine_id; ?>"><?php echo $result->name; ?></a>
									</td>
									<td data-content="Type"><?php echo $result->color; ?></td>
									<td data-content="Domaine"><?php echo $result->domain; ?></td>
									<td data-content="Région"><?php echo $result->region; ?></td>
									<td data-content="Millésime"><?php echo $result->year; ?></td>
									<td data-content="Prix"><?php echo $result->price; ?> <span>€</span></td>
									<td data-content="Format"><?php echo $result->format; ?> <span>cl</span></td>
									<td data-content="Stock"><?php echo $result->stock; ?> <span>cl</span></td>
									<td data-content="Cépages"><?php echo $result->grapes_name; ?></td>
									<td data-content="Actions">
										<?php // <button data-action="user-action">…</button> ?>
										<menu class="">
											<ul>
												<li>
													<a class="button-edit button" href="edit.php?post_type=wine&wine_id=<?php echo $result->wine_id; ?>">Modifier</a>
												</li>
												<li>
													<button class="button-delete button" data-show="delete">Supprimer</button>
												</li>
											</ul>
										</menu>
									</td>
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

			<?php include_once 'views/components/sidebar.php'; ?>
		</main>
	</div>

	<aside class="modals">
		<section class="modal" data-modal="delete">
			<p>Placeholder vraiment supprimer</p>

			<form action="list.php" method="POST" novalidate>
				<input type="hidden" name="wine_id" value="">

				<button class="button-cancel button" type="button" data-cancel="modal">Annuler</button>
				<button class="button-delete button" type="submit" name="delete">Delete ?</button>
			</form>
		</section>
	</aside>

	<script src="assets/js/app.js"></script>
</body>
</html>
<?php

$stmt = null;
$db = null;

?>
