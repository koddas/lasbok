<?php
$app->get('/reservation', function () use ($app, $db) {
	$cols = array('start_date', 'end_date', 'Customers_id',
			'description', 'Customer_categories_id');
	
	$reservation = $db->select('Reservations', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/reservation/:id', function ($id) use ($app, $db) {
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	$cols = array('id', 'description', 'start_date', 'end_date',
			'number_of_guests', 'Customers_id', 'Customer_types_id');
	$select = array('id' => $id);
	$reservation = $db->select('Reservations', $cols, $select);
	
	if (count($reservations) > 0) {
		echo json_encode($reservations[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Reservation not found');
	}
});

$app->post('/reservation', function () use ($app, $db) {
	// TODO: Kontrollera dubbelbokningar
	
	$customer = intval($app->request->post('customer'));
	$customer_category = intval($app->request->post('customer_category'));
	$site = intval($app->request->post('site'));
	$description = $app->request->post('description');
	$start_date = strtotime($app->request->post('start_date'));
	$end_date = strtotime($app->request->post('end_date'));
	$is_preliminary = $app->request->post('is_preliminary');
	$is_verified = $app->request->post('is_verified');
	$lock_site = $app->request->post('lock_site');
	$number_of_guests = intval($app->request->post('number_of_guests'));
	$quoted_price = intval($app->request->post('quoted_price'));
	$extras = $app->request->post('extras');
	
	if (!($customer > 0 && $customer_category > 0 && $site > 0 &&
			$start_date > 0 && $start_date <= $end_date)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Customers_id' => $customer,
			'Customer_categories_id' => $customer_category,
			'sites_id' => $Sites_id,
			'description' => $description,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'number_of_guests' => $number_of_guests,
			'extras' => $extras);
	
	$db->insert('Reservations', $values);
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Reservation '$id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/reservation/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att förändra reservationer
	$id = intval($app->request->post('id'));
	$customer = intval($app->request->post('customer'));
	$customer_category = intval($app->request->post('customer_category'));
	$site = intval($app->request->post('site'));
	$description = $app->request->post('description');
	$start_date = strtotime($app->request->post('start_date'));
	$end_date = strtotime($app->request->post('end_date'));
	$is_preliminary = $app->request->post('is_preliminary');
	$is_verified = $app->request->post('is_verified');
	$lock_site = $app->request->post('lock_site');
	$number_of_guests = intval($app->request->post('number_of_guests'));
	$quoted_price = intval($app->request->post('quoted_price'));
	$extras = $app->request->post('extras');
	
	if (!($custome > 0 && $customer_category > 0 &&
			$site > 0 && strlen($site) > 0 &&
			$start_date > 0 && $start_date < $end_date)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Customers_id' => $customer,
			'Customer_categories_id' => $customer_category,
			'sites_id' => $site,
			'description' => $description,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'number_of_guests' => $number_of_guests,
			'extras' => $extras);
	
	$where = array('id' => $id);
	
	$db->update('Reservations', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "User role '$name' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/reservation/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort reservationer
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id);
	
	$db->delete('Reservations', $values);
});

$app->get('/reservation/:id/facilities', function ($id) use ($app, $db) {
	$id = intval($id);
	
	$cols = array('Reservations_id', 'Facility_partitions_id');
	$where = array('Reservations_id' => $id);

	$reservation = $db->select('Reservation_has_Facilities', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/reservation/:id/facilities', function ($id) use ($app, $db) {
	$reservation = intval($app->request->post('reservation'));
	$facility_partition = intval($app->request->post('facility_partition'));
	
	if (!($reservation > 0 && $facility_partition > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Reservations_id' => $reservation,
			'Facility_partitions_id' => $facility_partition
	);
	
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
	
	$id = intval($id);
	$fid = intval($fid);
	
	if ($id < 1 && $fid < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Reservations_id' => $id,
			'Facility_partitions_id' => $fid
	);
	
	$db->delete('Reservation_has_Facilities', $values);
});

$app->get('/reservation/search/by/:customer', function ($customer) use ($app, $db) {
	$customer = intval($customer);
	
	if ($customer < 1) {
		$app->halt(400, 'Bad request');
	}
	$cols = array('*');
	$where = array('Customers_id' => $customer);
	
	$reservation = $db->select('Reservations', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	
	if (count($reservations) > 0) {
		echo json_encode($reservations[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Reservation not found');
	}
});

$app->get('/reservation/search/from/:start/to/:stop', function ($start, $stop) use ($app, $db) {
	$start = date('Y-m-d H:i:s', $start);
	$stop = date('Y-m-d H:i:s', $stop);
	
	$cols = array('start_date', 'end_date', 'Customers_id',
			'description', 'Customer_categories_id');
	
	$where = array(
			'AND' => array(
					'start_date[>=]' => $start,
					'end_date[<=]' => $stop
			),
			'ORDER BY' => 'start_date'
	);
	
	$reservation = $db->select('Reservations', $cols, $where);
	
	if (count($reservation) > 0) {
		echo json_encode($reservation[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Customer not found');
	}
});

$app->get('/reservation/search/from/:start/to/:stop/by/:customer',
		  function ($start, $stop, $customer) use ($app, $db) {
	$start = date('Y-m-d H:i:s', $start);
	$stop = date('Y-m-d H:i:s', $stop);
	$customer = intval($customer);
	
	$cols = array('start_date', 'end_date', 'Customers_id',
		'description', 'Customer_categories_id');
		  	
	$where = array(
			'AND' => array(
					'Customers_id' => $customer,
					'start_date[>=]' => $start,
					'end_date[<=]' => $stop
			),
			'ORDER BY' => 'Customers_id');
		  	
	$reservation = $db->select('Reservations', $cols, $where);
		  	
	if (count($reservation) > 0) {
		echo json_encode($reservation[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Customer not found');
	}	
	echo "Reservation from to get: $start, $stop, $customer";
});
?>