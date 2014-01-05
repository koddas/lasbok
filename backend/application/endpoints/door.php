<?php
$app->get('/door', function () use ($app, $db) {
	echo "Door get";
});

$app->get('/door/:id', function ($id) use ($app, $db) {
	echo "Door get: $id";
});

$app->post('/door', function () use ($app, $db) {
	echo "Door get";
});

$app->get('/door/:id', function ($id) use ($app, $db) {
	echo "Door get: $id";
});

$app->delete('/door/:id', function ($id) use ($app, $db) {
	echo "Door delete: $id";
});
?>