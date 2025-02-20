<?php

session_start();

if ( $_SESSION['timeout'] < time() ) {
	session_destroy();
	header('Location: login.php');
	exit();
}

require 'app/database.php';

$sql = "SELECT *
		FROM producers";

$stmt = $db->prepare($sql);
$stmt->execute();

$producers = $stmt->fetchAll();

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
								<th>Domaine</th>
								<th>Région</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ( $producers as $producer ) : ?>
								<tr>
									<td data-content="Nom"><?php echo $producer->name; ?></td>
									<td data-content="Domaine"><?php echo $producer->domain; ?></td>
									<td data-content="Région"><?php echo $producer->region; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>

			<?php include_once 'views/components/sidebar.php'; ?>
		</main>
	</div>

	<script src="assets/js/app.js"></script>
</body>
</html>
