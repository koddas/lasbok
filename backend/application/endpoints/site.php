<?php
$app->get('/site', function () use ($app, $db) {
	$cols = array('id', 'name', 'has_automatic_locks');
	$sites = $db->select('Sites', $cols);
	echo json_encode($sites, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/site/:id', function ($id) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array('id', 'name', 'has_automatic_locks');
	$where = array('id' => $id);
	$sites = $db->select('Sites', $cols, $where);
	if (count($sites) > 0) {
		echo json_encode($sites[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Site not found');
	}
});

$app->post('/site', function () use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att skapa avdelning
	
	$name = trim($app->request->post('name'));
	$automatic_locks = boolval($app->request->post('has_automatic_locks'));
	
	if (strlen($name) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('name' => $name,
			'has_automatic_locks' => $automatic_locks);
	
	$db->insert('Sites', $values);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Site '$name' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/site/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ändra avdelning
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$id = intval($app->request->post('id'));
	$name = trim($app->request->post('name'));
	$automatic_locks = boolval($app->request->post('has_automatic_locks'));
	
	if (!(intval($id) > 0 && strlen($name) > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('name' => $name,
			'has_automatic_locks' => $automatic_locks);
	$where = array('id' => $id);
	
	$db->update('Sites', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Site '$name' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/site/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort avdelning
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$db->delete('Sites', array('id' => $id));
	
	$app->response()->status(200);
});
?>