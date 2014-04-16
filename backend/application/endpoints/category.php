<?php
$app->get('/category', function () use ($app, $db) {
	$cols = array('id', 'description');
	$category = $db->select('Categry', $cols);
	echo json_encode($buildings, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
});

$app->get('/category/:id', function ($id) use ($app, $db) {
	$cols = array('id', 'description');
	$where = array('id' => $id);
	$category = $db->select('Categry', $cols, $where);
	
	if (count($category) > 0) {
		echo json_encode($category[0], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	} else {
		$app->halt(404, 'Category not found');
	}
});

$app->post('/category', function () use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att skapa categori
	$id = $app->request->post('id');
	$description = $app->request->post('description');
	
	if (!(strlen($id) > 0 && strlen($description) > 0)) {
		$app->halt(400, 'Bad request');
		}
		
		$db->query("INSERT INTO category VALUES ('$id', '$description');");
		
		$errors = $db->error();
		
		switch (intval($errors[0])) {
			case 0:
				$app->response()->status(201);
				break;
			case 23000:
				$app->halt(409, "Category '$id' already exists");
				break;
			default:
				$app->halt(500, $errors[2]);
		}
		
});

$app->put('/category/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ändra categori
	if (intval($id) < 1) {
		$app->halt(400, 'Bad request');
	}
	
	$id = $app->request->post('id');
	$description = $app->request->post('description');
	
	if (!(strlen($id) > 0 && strlen($description) > 0 )) {
		$app->halt(400, 'Bad request');
	}
	
	$values = array('id' => $id,
			'description' => $description);
	
	$db->insert('category', $values);
	
	$errors = $db->error();
	
	switch (intval($errors[0])) {
		case 0:
			$app->response()->status(201);
			break;
		case 23000:
			$app->halt(409, "Category 'id' already exists");
			break;
		default:
			$app->halt(500, $errors[2]);
	}
	echo "Category get: $id";
});

$app->delete('/category/:id', function ($id) use ($app, $db) {
	// TODO: Kontrollera om användaren har behörighet att ta bort categori
	$db->delete('category', array('id' => $id));
});
?>