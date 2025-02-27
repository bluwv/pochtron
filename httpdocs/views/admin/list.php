<?php

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

	header('Location: /admin/wines/list');
	exit();
}

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
							<a href="/admin/wines/edit?post_type=wine&wine_id=<?php echo $result->wine_id; ?>"><?php echo $result->name; ?></a>
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
										<a class="button-edit button" href="/admin/wines/edit?post_type=wine&wine_id=<?php echo $result->wine_id; ?>">Modifier</a>
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
