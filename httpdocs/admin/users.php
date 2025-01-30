<?php

session_start();

require_once '../../app/database.php';

$sql = "SELECT *
		FROM users";

$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="assets/css/app.css">
</head>

<body class="admin users">

	<div id="app">
		<main class="site-main">
			<section class="edit-listing">
				<header>
					<h1>Listing des users</h1>
					<a class="button" href="">Add new</a>
				</header>

				<div>
					<table>
						<thead>
							<tr>
								<th>Email</th>
								<th>Name</th>
								<th>Token</th>
								<th>Created</th>
								<th>Actions</th>
						</thead>

						<tbody>
							<?php foreach ( $users as $user ) : ?>
								<tr>
									<td>
										<a href="user.php?user_id=<?php echo $user->id; ?>"><?php echo $user->email; ?></a>
									</td>
									<td><?php echo $user->name; ?></td>
									<td><?php echo $user->token; ?></td>
									<td><?php echo $user->created_at; ?></td>
									<td><button>…</button></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
		</main>
	</div>

</body>
</html>
