<?php
$app->get('/partition', function () use ($app, $db) {
	$cols = array('id', 'description');
	$partitions = $db->select('Partitions', $cols);
	echo json_encode($partitions, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/partition/:id', function ($id) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array('id', 'description');
	$where = array('id' => $id);
	$partitions = $db->select('Partitions', $cols, $where);
	if (count($partitions) > 0) {
		echo json_encode($partitions[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Partition not found');
	}
});

$app->post('/partition', function () use ($app, $db) {
// TODO: Kontrollera om användaren har behörighet att skapa avdelning
	
	$description = trim($app->request->post('description'));
	
	if (strlen($description) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('description' => $description);
	
	$db->insert('Partitions', $values);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Partition '$description' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/partition/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ändra avdelning
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$id = intval($app->request->post('id'));
	$description = trim($app->request->post('description'));
	
	if (!(intval($id) > 0 && strlen($description) > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('description' => $description);
	$where = array('id' => $id);
	
	$db->update('Partitions', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Partition '$description' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/partition/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort avdelning
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$db->delete('Partitions', array('id' => $id));
	
	$app->response()->status(200);
});

$app->get('/partition/:id/doors', function ($id) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array('id', array('Relay_cards_int' => 'relay_card'),
			'port', 'is_internal', 'description');
	$select = array('Partition_has_Doors.Partitions_id' => $id);
	$join = array('[>]Partition_has_Doors'=> array('id' => 'Partition_id'));

	$building = $db->select('Buildings', $join, $cols, $select);
	
	echo json_encode($building, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/partition/:id/doors', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ge avdelningar nya dörrar
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$door = intval($app->request->post('door'));
	
	if (intval($door) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$doors = array('Partitions_id' => $id,
				   'Doors_id' => $door);
	
	$db->insert('Partition_has_Doors', $doors);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Partition '$partition' already has this door");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/partition/:id/doors/:did', function ($id, $did) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort avdelningens dörrar
	
	if (intval($id) < 1 || intval($did) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$doors = array('AND' => array('Partitions_id' => $id,
			'Doors_id' => $did));
		
	$db->delete('Partition_has_Doors', $doors);
	
	$app->response()->status(200);
});
?>