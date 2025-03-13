<?php

$grapes_limit = 20;
$grapes_offset = ($_GET['page'] ?? 0) * $grapes_limit;

$sql = "SELECT grapes.id as grape_id, grapes.name, grapes.color
        FROM grapes
        LIMIT $grapes_limit OFFSET $grapes_offset";

$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

// DELETE
if ( isset( $_POST['delete'] ) && isset( $_POST['item_id'] ) ) {
    $sql = "DELETE FROM grapes
            WHERE grapes.id = :grape_id";

    $stmt = $db->prepare($sql);
    $stmt->execute([':grape_id' => $_POST['item_id']]);

    header('Location: /admin/grapes/list');
    exit();
}

?>

<section class="edit-listing">
    <header>
        <h1>Listing des cépages</h1>
        <a class="button" href="/admin/grapes/edit?post_type=grape">Add new</a>
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
                </tr>
            </thead>

            <tbody>
                <?php foreach ( $results as $result ) : ?>
                    <tr data-item-id="<?php echo $result->grape_id; ?>" data-item-name="<?php echo $result->name; ?>">
                        <td data-content="Nom">
                            <a href="/admin/grapes/edit?post_type=grape&grape_id=<?php echo $result->grape_id; ?>"><?php echo $result->name; ?></a>
                        </td>
                        <td data-content="Type"><?php echo $result->color; ?></td>
                        <td data-content="Actions">
                            <?php // <button data-action="user-action">…</button> ?>
                            <menu class="">
                                <ul>
                                    <li>
                                        <a class="button-edit button" href="/admin/grapes/edit?post_type=grape&grape_id=<?php echo $result->grape_id; ?>">Modifier</a>
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
