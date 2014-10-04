<?php
$app->get('/customer', function () use ($app, $db) {
	$cols = array('id', 'name', 'contact_name', 'phone_number','email',
			'postal_address', 'invoicing_address', 'comments');
	$customer = $db->select('Customers', $cols);
	
	echo json_encode($users, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/customer/:id', function ($id) use ($app, $db) {
	$cols = array('id', 'name', 'contact_name', 'phone_number','email',
			'postal_address', 'invoicing_address', 'comments');
	$where = array('id' => $id);
	$customer = $db->select('Customers', $cols, $where);
	if (count($customer) > 0) {
		echo json_encode($users[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Customer not found');
	}
});

$app->post('/customer', function () use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att skapa kund
	$name = intval($app->request->post('name'));
	$contact_name = trim($app->request->post('contact_name'));
	$phone_number = trim($app->request->post('phone_number'));
	$email = trim($app->request->post('email'));
	$postal_address = trim($app->request->post('postal_address'));
	$invoicing_address = trim($app->request->post('invoicing_address'));
	$comments = trim($app->request->post('comments'));
	
	if (!(strlen($name) > 0 && strlen($phone_number) > 0 &&
			strlen($email) > 0 && strlen($postal_address) < 0 )) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('name' => $name,
			'contact_name' => $contact_name, 'phone_number' => $phone_number,
			'email' => $email, 'postal_address' => $postal_address,
			'invoicing_address' => $invoicing_address, 'comments' => $comments);
	
	$db->insert('Customers', $values);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Building '$name' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
	
});

$app->get('/customer/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ändra kund
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$id = intval($app->request->post('id'));
	$name = trim($app->request->post('name'));
	$contact_name = trim($app->request->post('contact_name'));
	$phone_number = trim($app->request->post('phone_number'));
	$email = trim($app->request->post('email'));
	$postal_address = trim($app->request->post('postal_address'));
	$invoicing_address = trim($app->request->post('invoicing_address'));
	$comments = $app->request->post('comments');
	
	if (!(strlen($name) > 0 && strlen($phone_number) > 0 &&
			strlen($email) > 0 && strlen($postal_address) > 0 )) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id, 'name' => $name,
			'contact_name' => $contact_name, 'phone_number' => $phone_number,
			'email' => $email, 'postal_address' => $postal_address,
			'invoicing_address' => $invoicing_address, 'comments' => $comments);
	
	$where = array('id' => $id);
	
	$db->update('Customers', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Customer '$id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/customer/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort kund
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$db->delete('Customers', array('id' => $id));
	
	$app->response()->status(200);
});

$app->get('/customer/search/:string', function ($string) use ($app, $db) {
	$cols = array('id', 'name', 'contact_name', 'phone_number','email',
			'postal_address');
	$where = array(
			'LIKE' => array(
					'OR' => array(
							'name' => $name, 'contact_name' => $contact_name, 
							'phone_number' => $phone_number, 'email' => $email,
							'postal_address' => $postal_address)));
	
	$customer = $db->select('Customers', $cols, $where);
	if (count($customer) > 0) {
		echo json_encode($users[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Customer not found');
	}
});

$app->get('/customer/from/:start/to/:stop', function ($start, $stop) use ($app, $db) {
	$cols = array('id', 'name', 'contact_name', 'phone_number','email',
			'postal_address');
	$where = array(
			'LIMIT' => array($start, $stop));
	
	$customer = $db->select('Custmers', $cols, $where);
	if (count($customer) > 0) {
		echo json_encode($users[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Customer not found');
	}
});
?>