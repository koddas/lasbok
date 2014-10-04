<?php
$app->get('/server', function () use ($app, $db) {
	$cols = array('id', 'public_ip', 'software_version',
				array('Sites_id' => 'site')
	);
	
	$server = $db->select('Servers', $cols);
	
	echo json_encode($server, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/server/:id', function ($id) use ($app, $db) {
	
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	$cols = array('id', 'public_ip', 'software_version',
				array('Sites_id' => 'site')
	);
	$select = array('id' => $id);
	$servers = $db->select('Servers', $cols, $select);
	
	if (count($servers) > 0) {
		echo json_encode($reservations[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Server not found');
	}
});

$app->post('/server', function () use ($app, $db) {
	$id = intval($app->request->post('id'));
	$ip = intval($app->request->post('ip'));
	$software_version = trim($app->request->post('software_version'));
	$site = intval($app->request->post('site'));
	
	if (!($id > 0 && $ip > 0 && $site > 0 &&
			$software_version > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'ip' => $ip,
			'software_id' => $software_id,
			'Sites_id' => $site
	);
	
	$db->insert('Servers', $values);
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Server '$id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->put('/server/:id', function ($id) use ($app, $db) {
	$id = intval($app->request->put('id'));
	$ip = intval($app->request->put('ip'));
	$software_version = trim($app->request->put('software_version'));
	$sites_id = intval($app->request->put('site'));
	
	if (!($id > 0 && $ip > 0 && $sites_id > 0 &&
			$software_version > 0)) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array(
			'ip' => $ip,
			'software_version' => $software_version,
			'sites_id' => $site);
	
	$where = array('id' => $id);
	
	$db->update('Servers', $values, $where);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Server '$id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
});

$app->delete('/server/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort servrar
	
	$id = intval($id);
	
	if ($id < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id);
	
	$db->delete('Servers', $values);
});
?>