<?php

$sql = "SELECT *
		FROM producers";

$stmt = $db->prepare($sql);
$stmt->execute();

$producers = $stmt->fetchAll();

?>

<section class="edit-listing">
	<header>
		<h1>Listing des vins</h1>
		<a class="button" href="/admin/wines/edit?post_type=wine">Add new</a>
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
