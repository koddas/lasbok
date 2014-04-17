<?php
$app->get('/card', function () use ($app, $db) {
	$cols = array('*');
	$cards = $db->select('Relay_cards', $cols);
	
	echo json_encode($cards, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/card/:id', function ($id) use ($app, $db) {
	$cols = array('*');
	$where = array('id' => $id);
	$cards = $db->select('Relay_cards', $cols, $where);
	if (count($users) > 0) {
		echo json_encode($cards[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Card not found');
	}
});

$app->post('/card', function () use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att skapa kort
	$site = $app->request->post('site');
	$address = inet_pton($app->request->post('address'));
	
	if (strlen($site) < 1 || !$address) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Sites_id' => $site,
					'ipaddress' => $address);
	
	$db->insert('Relay_cards', $values);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Card at '{$app->request->post('address')}' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/card/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ändra kort
	$site = $app->request->put('site');
	$address = inet_pton($app->request->put('address'));
	
	if (strlen($site) < 1 || !$address) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Sites_id' => $site,
					'ipaddress' => $address);
	$where = array('id' => $id);
	
	$db->update('Relay_cards', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Card at '{$app->request->put('address')}' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/card/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort kort
	
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id);
	
	$db->delete('Relay_cards', $values);
});

$app->get('/card/:id/ports', function ($id) use ($app, $db) {
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array('id', 'port', 'is_internal', 'description');
	$where = array('Relay_cards_id' => $id, 'ORDER' => 'port ASC');
	
	$ports = $db->select('Doors', $cols, $where);
	
	echo json_encode($ports, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/card/:id/ports/:pid', function ($id, $pid) use ($app, $db) {
	$id = intval($id);
	$pid = intval($pid);
	
	if ($id < 1 || $pid < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array('id', 'is_internal', 'description');
	$where = array('Relay_cards_id' => $id, 'port' => $pid, 'ORDER' => 'port ASC');
	
	$port = $db->select('Doors', $cols, $where);
	
	echo json_encode($port, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/card/:id/ports/:pid/door', function ($id, $pid) use ($app, $db) {
	$id = intval($id);
	$pid = intval($pid);
	
	if ($id < 1 || $pid < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$cols = array('id', 'is_internal', 'description');
	$where = array('Relay_cards_id' => $id, 'port' => $pid, 'ORDER' => 'port ASC');
	
	$port = $db->select('Doors', $cols, $where);
	
	echo json_encode($port, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->post('/card/:id/ports/:pid/door', function ($id, $pid) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att koppla dörr med port 
	$did = intval($app->post('door'));
	$id = intval($id);
	$pid = intval($pid);
	
	if ($id < 1 || $pid < 1 || $did < 0) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Relay_cards_id' => $id, 'port' => $pid);
	$where = array('id' => $did);
	
	$db->update('Doors', $values, $where);
});

$app->delete('/card/:id/ports/:pid/door', function ($id, $pid) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort dörr från port
	
	$id = intval($id);
	$pid = intval($pid);
	
	if ($id < 1 || $pid < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('Relay_cards_id' => 0, 'port' => 0);
	$where = array('Relay_cards_id' => $id, 'port' => $pid);
	
	$db->update('Doors', $values, $where);
});
?>