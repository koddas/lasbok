<?php
$app->get('/facility', function () use ($app, $db) {
	$cols = array('id', array('Sites_id' => 'site'), 'name', 'description');
	
	$facilities = $db->select('Facilities', $cols);
	
	echo json_encode($facilities, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/facility/:id', function ($id) use ($app, $db) {
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	$cols = array('id', array('Sites_id' => 'site'), 'name', 'description');
	$select = array('id' => $id);
	$facilities = $db->select('Facilities', $cols, $select);
	
	if (count($facilities) > 0) {
		echo json_encode($facilities[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Facility not found');
	}
});

$app->post('/facility', function () use ($app, $db) {
	$site = intval($app->request->post('site'));
	$name = trim($app->request->post('name'));
	$description = trim($app->request->post('description'));
	
	if (!($site > 0 && strlen($name) > 0 &&
			strlen($description) > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Sites_id' => $site,
			'name' => $name,
			'description' => $description
	);
	
	$db->insert('Facilities', $values);
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Facility '$id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/facility/:id', function ($id) use ($app, $db) {
	$id = intval($app->request->post('id'));
	$site = intval($app->request->post('site'));
	$name = trim($app->request->post('name'));
	$description = trim($app->request->post('description'));
	
	if (!($id > 0 && $site > 0 && strlen($name) > 0 &&
			strlen($description) > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Sites_id' => $site,
			'name' => $name,
			'description' => $description);
	
	$where = array('id' => $id);
	
	$db->update('Facilities', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Facility '$id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/facility/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort facilitet
	
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id);
	
	$db->delete('Facilities', $values);
});

$app->get('/facility/:id/partitions', function ($id) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array(array('Facilities_id' => 'facility'),
			array('Partitions_id' => 'partition'));
	$select = array('Facility_has_Partitions.Partitions_id' => $id);
	$join = array('[>]Facility_has_Partitions' => array('id' => 'Facilities_id'));

	$facility = $db->select('Facilities', $join, $cols, $select);
	
	echo json_encode($facility, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/facility/:id/partitions', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ge faciliteter nya avdelningar
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$partition = intval($app->request->post('partition'));
	
	if (intval($partition) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$partitions = array('Facilities_id' => $id,
			'Partitions_id' => $partition);
	
	$db->insert('Facility_has_Partitions', $partitions);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Facility '$id' already has this partition");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/facility/:id/partitions/:pid', function ($id, $pid) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort facilitetens avdelningar
	
	if (intval($id) < 1 || intval($pid) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$partition = intval($app->request->delete('partition'));
	
	$partitions = array('Facilities_id' => $id,
			'Partitions_id' => $partition);
		
	$db->delete('Facility_has_Partitions', $partitions);
	
	$app->response()->status(200);
});

$app->get('/facility/:id/prices', function ($id) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array(array('Customer_categories_id' => 'customer_category'),
			array('Facilities_id' => 'facility'), 'price', 'per_head');
	$select = array('Prices.Facilities_id' => $id);
	$join = array('[>]Prices' => array('id' => 'Facilities_id'));

	$facility = $db->select('Facilities', $join, $cols, $select);
	
	echo json_encode($facility, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/facility/:id/prices', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ge faciliteter nya priser
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$customer_category = intval($app->request->post('customer_category'));
	$facility = intval($app->request->post('facility'));
	$price = intval($app->request->post('price'));
	$per_head = boolval($app->request->post('per_head'));
	
	if (intval($price) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$prices = array('Facilities_id' => $facility,
			'Customer_categories_id' => $customer_category,
			'price' => $price,
			'per_head' => $per_head
	);
	
	$db->insert('Prices', $prices);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Facility '$id' already has this price");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/facility/:id/prices/:pid', function ($id, $pid) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort facilitetens priser
	
	if (intval($id) < 1 || intval($pid) < 1) {
		$app->halt(400, 'Bad request');
	}

	$facility = intval($app->request->delete('facility'));
	$customer_category = intval($app->request->delete('customer_category'));
	
	$price = array('Facilities_id' => $facility,
			'Customer_category_id' => $customer_category);
		
	$db->delete('Prices', $price);
	
	$app->response()->status(200);
});
?>