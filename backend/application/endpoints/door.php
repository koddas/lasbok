<?php
$app->get('/door', function () use ($app, $db) {
	$cols = array('*');
	$category = $db->select('Door', $cols);
	echo json_encode($buildings, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/door/:id', function ($id) use ($app, $db) {
	$cols = array('*');
	$where = array('id' => $id);
	$category = $db->select('Door', $cols, $where);
	
	if (count($category) > 0) {
		echo json_encode($category[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Door not found');
	}
});

$app->post('/door', function () use ($app, $db) {
	$cards_id = intval($app->request->post('cards_id'));
	$port = $app->request->post('port');
	$is_internal = $app->request->post('is_internal');
	$description = $app->request->post('description');
	
	$values = array('Relay_cards_id' => $cards_id, 'port' => $port,
			'is_internal' => $is_internal, 'description' => $description);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Category '$description' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/door/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ändra dörr
	
	$id = intval($app->request->post('id'));
	$cards_id = intval($app->request->post('cards_id'));
	$port = $app->request->post('port');
	$is_internal = $app->request->post('is_internal');
	$description = $app->request->post('description');
	
	if (!($id > 0 && $cards_id > 0 && strlen($port) > 0 &&
			strlen($is_internal) > 0 &&  intval($description) > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id, 'Relay_cards_id' => $cards_id,
			'description' => $description, 'is_internal' => $is_internal);
	$where = array('id' => $id);
	
	$db->update('Buildings', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Building '$id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
	echo "Door get: $id";
});

$app->delete('/door/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort dörr
	
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$db->delete('Doors', array('id' => $id));
	
	$app->response()->status(200);
});
?>