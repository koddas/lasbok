<?php
$app->get('/user', function () use ($app, $db) {
	$cols = array('user_name', 'first_name', 'last_name');
	$users = $db->select('Users', $cols);
	
	echo json_encode($users, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/user/:id', function ($id) use ($app, $db) {
	$cols = array('user_name', 'first_name', 'last_name');
	$where = array('user_name' => $id);
	$users = $db->select('Users', $cols, $where);
	if (count($users) > 0) {
		echo json_encode($users[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'User not found');
	}
});

$app->post('/user', function () use ($app, $db) {
	$username = $app->request->post('username');
	$password = $app->request->post('password');
	$first_name = $app->request->post('first_name');
	$last_name = $app->request->post('last_name');
	
	if (!(strlen($username) > 0 && strlen($password) &&
		  strlen($first_name) > 0 && strlen($last_name) > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$db->query("INSERT INTO Users VALUES ('$username', "
			.  "PASSWORD('$password'), '$first_name', '$last_name');");
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 23000:
			$app->halt(409, "User '$username' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/user/:id', function ($id) use ($app, $db) {
	$password = $app->request->put('password');
	$current_password = $app->request->put('current_password');
	$first_name = $app->request->put('first_name');
	$last_name = $app->request->put('last_name');
	
	if (strlen($current_password) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$comma_needed = false;
	$password_part = '';
	if (strlen($password) > 0) {
		$password_part = " password = PASSWORD('$password')";
		$comma_needed = true;
	}
	$first_name_part = '';
	if (strlen($first_name) > 0) {
		if ($comma_needed) {
			$first_name_part = ',';
		}
		$first_name_part += " first_name = '$first_name'";
		$comma_needed = true;
	}
	$last_name_part = '';
	if (strlen($last_name) > 0) {
		if ($comma_needed) {
			$first_name_part = ',';
		}
		" last_name = '$last_name'";
	}
	
	$db->query("UPDATE Users SET"
			.  $password_part
			.  $first_name_part
			.  $last_name_part
			.  " WHERE user_name = $id AND "
			.  "password = PASSWORD('$current_password');");
	
	$errors = $db->error();
	
	if (intval($errors[0])) {
		$app->halt(500, $errors[2]);
	}
});

$app->delete('/user/:id', function ($id) use ($app, $db) {
	echo "User delete: $id";
});

$app->get('/user/:id/roles', function ($id) use ($app, $db) {
	echo "User roles get: $id";
});

$app->post('/user/:id/roles', function ($id) use ($app, $db) {
	echo "User roles post: $id";
});

$app->get('/user/:id/roles/:rid', function ($id, $rid) use ($app, $db) {
	echo "User roles delete: $id, $rid";
});
?>