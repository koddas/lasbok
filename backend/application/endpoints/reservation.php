<?php
$app->get('/reservation', function () use ($app, $db) {
	$cols = array(
			'id', array('Customers_id' => 'customer'),
			array('Customer_categories_id' => 'customer_category'),
			array('Sites_id' => 'site'),
			'description',
			'start_date', 'end_date',
			'is_preliminary', 'is_verified', 'lock_site',
			'number_of_guests', 'quoted_price', 'extras');
	
	$reservation = $db->select('Reservations', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/reservation/:id', function ($id) use ($app, $db) {
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	$cols = array(
			'id', array('Customers_id' => 'customer'),
			array('Customer_categories_id' => 'customer_category'),
			array('Sites_id' => 'site'),
			'description',
			'start_date', 'end_date',
			'is_preliminary', 'is_verified', 'lock_site',
			'number_of_guests', 'quoted_price', 'extras');
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
	$description = trim($app->request->post('description'));
	$start_date = strtotime(trim($app->request->post('start_date')));
	$end_date = strtotime(trim($app->request->post('end_date')));
	$is_preliminary = boolval($app->request->post('is_preliminary'));
	$is_verified = boolval($app->request->post('is_verified'));
	$lock_site = boolval($app->request->post('lock_site'));
	$number_of_guests = intval($app->request->post('number_of_guests'));
	$quoted_price = intval($app->request->post('quoted_price'));
	$extras = trim($app->request->post('extras'));
	
	if (!($customer > 0 && $customer_category > 0 &&
			$site > 0 && $start_date > 0 && $start_date < $end_date)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Customers_id' => $customer,
			'Customer_categories_id' => $customer_category,
			'Sites_id' => $site,
			'description' => $description,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'is_preliminary' => $is_preliminary,
			'is_verified' => $is_verified,
			'number_of_guests' => $number_of_guests,
			'quoted_price' => $quoted_price,
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
	$description = trim($app->request->post('description'));
	$start_date = strtotime(trim($app->request->post('start_date')));
	$end_date = strtotime(trim($app->request->post('end_date')));
	$is_preliminary = boolval($app->request->post('is_preliminary'));
	$is_verified = boolval($app->request->post('is_verified'));
	$lock_site = boolval($app->request->post('lock_site'));
	$number_of_guests = intval($app->request->post('number_of_guests'));
	$quoted_price = intval($app->request->post('quoted_price'));
	$extras = trim($app->request->post('extras'));
	
	if (!($id > 0 && $customer > 0 && $customer_category > 0 &&
			$site > 0 && $start_date > 0 && $start_date < $end_date)) {
				$app->halt(400, 'Bad request');
			}
	
	$values = array(
			'Customers_id' => $customer,
			'Customer_categories_id' => $customer_category,
			'Sites_id' => $site,
			'description' => $description,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'is_preliminary' => $is_preliminary,
			'is_verified' => $is_verified,
			'number_of_guests' => $number_of_guests,
			'quoted_price' => $quoted_price,
			'extras' => $extras);
	
	$where = array('id' => $id);
	
	$db->update('Reservations', $values, $where);
	
	$errors = $db->error();
	
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

$app->delete('/reservation/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort reservationer
	
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id);
	
	$db->delete('Reservations', $values);
});

$app->get('/reservation/:id/facilities', function ($id) use ($app, $db) {
	$cols = array(
				array('Reservations_id' => 'reservation'),
				array('Facilities_id' => 'facility'));

	$reservation = $db->select('Reservation_has_Facilities', $cols);
	
	echo json_encode($reservation, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/reservation/:id/facilities', function ($id) use ($app, $db) {
	$reservation = intval($app->request->post('reservation'));
	$facility = intval($app->request->post('facility'));
	
	if (!($reservation > 0 && $facility > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Reservations_id' => $reservation,
			'Facility_partitions_id' => $facility
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
	
	if (intval($id) < 1 && intval($fid) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'Reservations_id' => $id,
			'Facility_partitions_id' => $fid
	);
	
	$db->delete('Reservation_has_Facilities', $values);
});

$app->get('/reservation/search/by/:customer', function ($customer) use ($app, $db) {
	if (intval($customer) < 1) {
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
	$cols = array('start_date', 'end_date', 'Customers_id',
			'description', 'Customer_categories_id');
	
	$where = array(
			'LIMIT' => array($start, $stop));
	
	$reservation = $db->select('Reservations', $cols, $where);
	
	if (count($reservation) > 0) {
		echo json_encode($reservation[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Customer not found');
	}
});

$app->get('/reservation/search/from/:start/to/:stop/by/:customer',
		  function ($start, $stop, $customer) use ($app, $db) {
	$cols = array('start_date', 'end_date',
				array('Customers_id' => 'customer'),
				'description',
				array('Customer_categories_id' => 'customer_category'));
		  	
	$where = array($id,
		'LIMIT' => array($start, $stop));
		  	
	$reservation = $db->select('Reservations', $cols, $where);
		  	
	if (count($reservation) > 0) {
		echo json_encode($reservation[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Customer not found');
	}	
	echo "Reservation from to get: $start, $stop, $customer";
});
?>