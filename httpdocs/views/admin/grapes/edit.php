<?php

/** Check que l'id existe
 * -> si existe afficher == ok
 * _> si existe pas affiche blanco
 * si vide blanco aussi
 */

// TODO: Bien check que je ne peux delete que le product que je visualise
// TODO: Problème de double submission to bypass => soit ajax soit / unset form

// SELECT
if ( ! empty( $_GET['grape_id'] ) ) {
    $sql = "SELECT grapes.id as grape_id, grapes.name, grapes.color
        FROM grapes
        WHERE grapes.id = " . $_GET['grape_id'];

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
}

// DELETE
if ( isset( $_POST['delete'] ) ) {
    $sql = "DELETE FROM grapes
            WHERE grapes.id = :grape_id";

    $stmt = $db->prepare($sql);
    $stmt->execute([':grape_id' => $_POST['delete']]);

    header('Location: /admin/grapes/list');
    exit();
}

// UPDATE si on submit un "grape" existant
if ( ! empty( $_GET['grape_id'] ) && ! empty( $_POST ) ) {
    $name = htmlentities(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $color = htmlentities(trim($_POST['color']), ENT_QUOTES, 'UTF-8');

    $sql = "UPDATE grapes
        SET name = :name, color = :color
        WHERE id = :grape_id";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':color', $color);

    $stmt->execute();
}

// INSERT INTO si on submit un "grape" vide
if ( ! empty($_POST) && empty( $_GET['grape_id'] ) ) {
    $name = htmlentities(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $color = htmlentities(trim($_POST['color']), ENT_QUOTES, 'UTF-8');

    $sql = "INSERT INTO grapes (name, color)
        VALUES (:name, :color)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':color', $color);

    $stmt->execute();
    $new_id = $db->lastInsertId();
    header("Location: /admin/grapes/edit?post_type=grape&grape_id=" . $new_id);
    exit();
}

?>

<section class="edit-listing">
    <header>
        <?php if ( isset( $_GET['grape_id'] ) ) : ?>
            <h1>Modifier un cépage</h1>
            <a class="button" href="/admin/grapes/edit?post_type=grape">Add new</a>
        <?php else : ?>
            <h1>Ajouter un cépage</h1>
        <?php endif; ?>
    </header>

    <div>
        <form action="" method="POST" novalidate>
            <div class="form-row">
                <label for="name">Nom</label>
                <input id="name" type="text" name="name" placeholder="name" value="<?php echo (! empty($result)) ? $result->name : ""; ?>" required>
            </div>

            <div class="form-row">
                <label for="color">Couleur</label>
                <input id="color" type="text" name="color" placeholder="color" value="<?php echo (! empty($result)) ?$result->color : ""; ?>" required>
            </div>

            <div class="form-row form-row--submit">
                <button class="button-submit button" type="submit">Submit</button>

                <?php if ( ! empty( $_GET['grape_id'] ) ) : ?>
                    <button class="button-delete button" type="button" data-show="delete">Delete ?</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</section>

<!-- <aside class="modals">
    <section class="modal" data-modal="delete">
        <p>Placeholder vraiment supprimer</p>

        <?php if ( ! empty( $_GET['grape_id'] ) ) : ?>
            <form action="/admin/grapes/edit?post_type=grape&grape_id=<?php echo $_GET['grape_id']; ?>" method="POST" novalidate>
                <button class="button-cancel button" type="button" data-cancel="modal">Annuler</button>
                <button class="button-delete button" type="submit" name=delete value="<?php echo $_GET['grape_id']; ?>">Delete ?</button>
            </form>
        <?php endif; ?>
    </section>
</aside> -->
