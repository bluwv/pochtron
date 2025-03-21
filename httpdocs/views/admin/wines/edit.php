<?php

/** Check que l'id existe
 * -> si existe afficher == ok
 * _> si existe pas affiche blanco
 * si vide blanco aussi
 */

// TODO: Bien check que je ne peux delete que le product que je visualise
// TODO: Problème de double submission to bypass => soit ajax soit / unset form

// Check if image file is a actual image or fake image
if (! empty($_FILES)) {
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

	if ($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 10 * 1024 * 1024) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}

	// Allow certain file formats
	$accepted_files = ["jpg", "png", "jpeg", "gif"];
	if ( ! in_array( $imageFileType, $accepted_files ) ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
}

// SELECT
if (! empty($_GET['wine_id'])) {
	$sql = "SELECT wines.id as wine_id, wines.name, wines.description, wines.thumbnail, grapes.color, producers.domain, producers.region, wines.year, wines.price, wines.format, wines.stock, grapes.name as grapes_name, wines.id_grapes
		FROM wines
		LEFT JOIN producers ON wines.id_producer = producers.id
		LEFT JOIN grapes ON wines.id_grapes = grapes.id
		WHERE wines.id = " . $_GET['wine_id'];

	$stmt = $db->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetch();
}

$sql = "SELECT grapes.id, grapes.name, grapes.color
	FROM grapes";

$stmt = $db->prepare($sql);
$stmt->execute();
$grapes = $stmt->fetchAll();

// DELETE
if (isset($_POST['delete'])) {
	$sql = "DELETE FROM wines
			WHERE wines.id = :wine_id";

	$stmt = $db->prepare($sql);
	$stmt->execute([':wine_id' => $_POST['delete']]);

	header('Location: /admin/wines/list');
	exit();
}

// UPDATE si on submit un "wine" existant
if (! empty($_GET['wine_id']) && ! empty($_POST)) {

	$name = htmlentities(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$description = htmlentities(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
	$thumbnail = $_FILES["fileToUpload"]['name'];
	$year = htmlentities(trim($_POST['year']), ENT_QUOTES, 'UTF-8');
	$price = htmlentities(trim($_POST['price']), ENT_QUOTES, 'UTF-8');
	$format = htmlentities(trim($_POST['format']), ENT_QUOTES, 'UTF-8');
	$stock = htmlentities(trim($_POST['stock']), ENT_QUOTES, 'UTF-8');
	$id_grapes = serialize($_POST['grapes_id']);

	$sql = "UPDATE wines
		SET name = :name, description = :description, thumbnail = :thumbnail, year = :year, price = :price, format = :format, stock = :stock, id_grapes = :id_grapes
		WHERE id = :wine_id";

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':description', $description);
	$stmt->bindValue(':thumbnail', $thumbnail);
	$stmt->bindValue(':year', $year);
	$stmt->bindValue(':price', $price);
	$stmt->bindValue(':format', $format);
	$stmt->bindValue(':stock', $stock);
	$stmt->bindValue(':wine_id', $_GET['wine_id']);
	$stmt->bindValue(':id_grapes', $id_grapes);

	$stmt->execute();
	// header("Location: /admin/wines/edit?post_type=wine&wine_id=" . $_GET['wine_id']);
	// exit();
}

// INSERT INTO si on submit un "wine" vide
if (! empty($_POST) && empty($_GET['wine_id'])) {
	$name = htmlentities(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$description = htmlentities(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
	$year = htmlentities(trim($_POST['year']), ENT_QUOTES, 'UTF-8');
	$price = htmlentities(trim($_POST['price']), ENT_QUOTES, 'UTF-8');
	$format = htmlentities(trim($_POST['format']), ENT_QUOTES, 'UTF-8');
	$stock = htmlentities(trim($_POST['stock']), ENT_QUOTES, 'UTF-8');
	$id_grapes = serialize($_POST['grapes_id']);

	$sql = "INSERT INTO wines (name, description, year, price, format, stock, id_grapes)
		VALUES (:name, description, :year, :price, :format, :stock, :id_grapes)";

	$stmt = $db->prepare($sql);

	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':description', $description);
	// $stmt->bindValue(':title', $_POST['title']);
	$stmt->bindValue(':year', $year);
	$stmt->bindValue(':price', $price);
	$stmt->bindValue(':format', $format);
	$stmt->bindValue(':stock', $stock);
	$stmt->bindValue(':id_grapes', $id_grapes);
	// $stmt->bindValue(':stars', $_POST['wine_id']);
	// $stmt->bindValue(':notes', $_POST['wine_id']);

	$stmt->execute();
	$new_id = $db->lastInsertId();
	header("Location: /admin/wines/edit?post_type=wine&wine_id=" . $new_id);
	exit();
}

?>

<section class="edit-listing">
	<header>
		<?php if (isset($_GET['wine_id'])) : ?>
			<h1>Modifier un vin</h1>
			<a class="button" href="/admin/wines/edit?post_type=wine">Add new</a>
		<?php else : ?>
			<h1>Ajouter un vin</h1>
		<?php endif; ?>
	</header>

	<div>
		<form action="" method="POST" enctype="multipart/form-data" novalidate>
			<div class="form-row">
				<label for="fileToUpload">Thumbnail</label>
				<div class="product-thumbnail">
					<img src="/uploads/<?php echo (! empty($result)) ? $result->thumbnail : ""; ?>" alt="">
				</div>
				<input id="fileToUpload" type="file" name="fileToUpload">
			</div>

			<div class="form-row">
				<label for="name">Nom</label>
				<input id="name" type="text" name="name" placeholder="name" value="<?php echo (! empty($result)) ? $result->name : ""; ?>" required>
			</div>

			<div class="form-row">
				<label for="description">Description</label>
				<textarea name="description" id="description"><?php echo (! empty($result)) ? $result->description : ""; ?></textarea>
			</div>

			<!-- <div class="form-row">
				<label for="color">Couleur</label>
				<input id="color" type="text" name="color" placeholder="color" value="<?php echo (! empty($result)) ? $result->color : ""; ?>" required>
			</div>

			<div class="form-row">
				<label for="domain">Domaine</label>
				<input id="domain" type="text" name="domain" placeholder="domain" value="<?php echo (! empty($result)) ? $result->domain : ""; ?>" required>
			</div>

			<div class="form-row">
				<label for="region">Région</label>
				<input id="region" type="text" name="region" placeholder="region" value="<?php echo (! empty($result)) ? $result->region : ""; ?>" required>
			</div> -->

			<div class="form-row">
				<label for="year">Millésime</label>
				<input id="year" type="text" name="year" placeholder="year" value="<?php echo (! empty($result)) ? $result->year : ""; ?>" required>
			</div>

			<div class="form-row">
				<label for="price">Prix</label>
				<input id="price" type="text" name="price" placeholder="price" value="<?php echo (! empty($result)) ? $result->price : ""; ?>" required>
			</div>

			<div class="form-row">
				<label for="format">Format</label>
				<input id="format" type="text" name="format" placeholder="format" value="<?php echo (! empty($result)) ? $result->format : ""; ?>" required>
			</div>

			<div class="form-row">
				<label for="stock">Stock</label>
				<input id="stock" type="text" name="stock" placeholder="stock" value="<?php echo (! empty($result)) ? $result->stock : ""; ?>" required>
			</div>

			<div class="form-row form-row--radios">
				<?php foreach ($grapes as $grape) :
				?>
					<div>
						<input id="grape_<?php echo $grape->id; ?>" type="checkbox" name="grapes_id[]" value="<?php echo $grape->id; ?>" <?php if (! empty($_GET['wine_id']) && in_array($grape->id, unserialize($result->id_grapes))) {
																																				echo "checked";
																																			} ?>>
						<label for="grape_<?php echo $grape->id; ?>"><?php echo $grape->name; ?> (<?php echo $grape->color; ?>)</label>
					</div>
				<?php endforeach ?>
			</div>

			<!-- <div class="form-row">
				<label for="grapes_name">Raisin(s)</label>
				<input id="grapes_name" type="text" name="grapes_name" placeholder="grapes_name" value="<?php echo (! empty($result)) ? $result->grapes_name : ""; ?>" required>
			</div> -->

			<div class="form-row form-row--submit">
				<button class="button-submit button" type="submit">Submit</button>

				<?php if (! empty($_GET['wine_id'])) : ?>
					<button class="button-delete button" type="button" data-show="delete">Delete ?</button>
				<?php endif; ?>
			</div>
		</form>
	</div>
</section>

<!-- <aside class="modals">
	<section class="modal" data-modal="delete">
		<p>Placeholder vraiment supprimer</p>

		<?php if (! empty($_GET['wine_id'])) : ?>
			<form action="/admin/wines/edit?post_type=wine&wine_id=<?php echo $_GET['wine_id']; ?>" method="POST" novalidate>
				<button class="button-cancel button" type="button" data-cancel="modal">Annuler</button>
				<button class="button-delete button" type="submit" name=delete value="<?php echo $_GET['wine_id']; ?>">Delete ?</button>
			</form>
		<?php endif; ?>
	</section>
</aside> -->
