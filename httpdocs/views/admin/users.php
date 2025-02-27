<?php

$sql = "SELECT *
		FROM users";

$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();

?>

<section class="edit-listing">
	<header>
		<h1>Listing des users</h1>
		<a class="button" href="/admin/user/edit?post_type=user">Add new</a>
	</header>

	<div>
		<table>
			<thead>
				<tr>
					<th>Email</th>
					<th>Name</th>
					<th>Created</th>
					<th>Actions</th>
			</thead>

			<tbody>
				<?php foreach ( $users as $user ) : ?>
					<tr>
						<td>
							<a href="/admin/user/edit?post_type=user&user_id=<?php echo $user->id; ?>"><?php echo $user->email; ?></a>
						</td>
						<td><?php echo $user->name; ?></td>
						<td><?php echo $user->created_at; ?></td>
						<td><a class="button-edit button" href="/admin/user/edit?post_type=user&user_id=<?php echo $user->id; ?>">Modifier</a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>
