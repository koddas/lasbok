<?php
$app->get('/reservation', function () use ($app, $db) {
	$cols = array('start_date', 'end_date', 'Customers_id',
			'description', 'Customer_categories_id');
	
	$reservation = $db->select('Reservations', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/reservation/:id', function ($id) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	$cols = array('id', 'description', 'start_date', 'end_date',
			'number_of_guests', 'Customers_id', 'Customer_types_id');
	$reservation = $db->select('Reservations', $join, $cols, $select);
	
	if (count($reservations) > 0) {
		echo json_encode($reservations[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Reservation not found');
	}
});

$app->post('/reservation', function () use ($app, $db) {
	// TODO: Kontrollera dubbelbokningar
	$id = $app->request->post('id');
	$customers_id = $app->request->post('Customers_id');
	$customer_categories_id = $app->request->post('Customer_categories_id');
	$Sites_id = $app->request->post('Sites_id');
	$description = $app->request->post('description');
	$start_date = $app->request->post('start_date');
	$end_date = $app->request->post('end_date');
	$is_preliminary = $app->request->post('is_preliminary');
	$is_verified = $app->request->post('is_verified');
	$lock_site = $app->request->post('lock_site');
	$number_of_guests = $app->request->post('number_of_guests');
	$quoted_price = $app->request->post('quoted_price');
	$extras = $app->request->post('extras');
	$start_date = strtotime(start_date);
	$end_date = strtotime(end_date);
	
	if (!(intval($customers_id) > 0 && intval($customer_categries_id) > 0 &&
			intval($sites_id) > 0 && strlen($site) > 0 &&
			$start_date > 0 && $start_date < $end_date)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Customers_id' => $customers_id, 'Customer_categories_id' =>
			$customer_categories_id, 'sites_id' => $Sites_id,
			'description' => $description, 'start_date' => $start_date,
			'end_date' => $end_date, 'number_of_guests' => $number_of_guests,
			'extras' => $extras);
	
	$db->insert('Reservations', $values);
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Reservation 'id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/reservation/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att förändra reservationer
	$id = $app->request->post('id');
	$customers_id = $app->request->post('Customers_id');
	$customer_categories_id = $app->request->post('Customer_categories_id');
	$Sites_id = $app->request->post('Sites_id');
	$description = $app->request->post('description');
	$start_date = $app->request->post('start_date');
	$end_date = $app->request->post('end_date');
	$is_preliminary = $app->request->post('is_preliminary');
	$is_verified = $app->request->post('is_verified');
	$lock_site = $app->request->post('lock_site');
	$number_of_guests = $app->request->post('number_of_guests');
	$quoted_price = $app->request->post('quoted_price');
	$extras = $app->request->post('extras');
	$start_date = strtotime(start_date);
	$end_date = strtotime(end_date);
	
	if (!(intval($customers_id) > 0 && intval($customer_categries_id) > 0 &&
			intval($sites_id) > 0 && strlen($site) > 0 &&
			$start_date > 0 && $start_date < $end_date)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Customers_id' => $customers_id, 'Customer_categories_id' =>
			$customer_categories_id, 'sites_id' => $Sites_id,
			'description' => $description, 'start_date' => $start_date,
			'end_date' => $end_date, 'number_of_guests' => $number_of_guests,
			'extras' => $extras);
	
	$where = array('id' => $id);
	
	$db->update('Reservations', $values, $where);
	
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

$app->delete('/reservation/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort reservationer
	
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id);
	
	$db->delete('Reservations', $values);
});

$app->get('/reservation/:id/facilities', function ($id) use ($app, $db) {
	$cols = array('Reservations_id', 'Facility_partitions_id');

	$reservation = $db->select('Reservation_has_Facilities', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/reservation/:id/facilities', function ($id) use ($app, $db) {
	$reservations_id = $app->request->post('Reservations_id');
	$facility_partitions_id = $app->request->post('Facility_partitions_id');
	
	if (!(intval($reservations_id) > 0 && intval($facility_partitions_id) > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Reservations_id' => $reservations_id, 'Facility_partitions_id' =>
			$facility_partitions_id);
	
	$db->insert('Reservation_has_Facilities', $values);
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Reservation already have that facility");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/reservation/:id/facilities/:fid', function ($id, $fid) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort fasiliteter från reservationer
	
	if (intval($reservatins_id) < 1 && intval(facility_partitions_id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Reservations_id' => $reservations_id, 'Facility_partitions_id' => $facility_partitions_id);
	
	$db->delete('Reservation_has_Facilities', $values);
});

$app->get('/reservation/search/by/:customer', function ($customer) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	$cols = array('id', 'Customers_id');
	
	$reservation = $db->select('Reservations', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	
	if (count($reservations) > 0) {
		echo json_encode($reservations[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Reservation not found');
	}
});

$app->get('/reservation/search/from/:start/to/:stop', function ($start, $stop) use ($app, $db) {
	
	echo "Reservation from to get: $start, $stop";
});

$app->get('/reservation/search/from/:start/to/:stop/by/:customer',
		  function ($start, $stop, $customer) use ($app, $db) {
	echo "Reservation from to get: $start, $stop, $customer";
});
?>