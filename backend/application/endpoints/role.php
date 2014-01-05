<?php
$app->get('/role', function () use ($app, $db) {
	$cols = array('id', 'name', 'description');
	$roles = $db->select('User_roles', $cols);
	
	echo json_encode($roles, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/role/:id', function ($id) use ($app, $db) {
	$cols = array('id', 'name', 'description');
	$where = array('id' => $id);
	
	$roles = $db->select('User_roles', $cols, $where);
	
	echo json_encode($roles, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/role', function () use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att skapa nya roller
	$name = $app->request->post('name');
	$description = $app->request->post('description');
	
	if (strlen($name) < 1 || strlen($description) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('name' => $name,
					'description' => $description);
	
	$db->insert('User_roles', $values);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "User role 'name' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/role/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att förändra roller
	
	$name = $app->request->put('name');
	$description = $app->request->put('description');
	
	if (intval($id) < 1 || strlen($name) < 1 || strlen($description) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('name' => $name,
					'description' => $description);
	$where = array('id' => $id);
	
	$db->update('User_roles', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "User role 'name' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/role/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort roller
	
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id);
	
	$db->delete('User_roles', $values);
});
?>