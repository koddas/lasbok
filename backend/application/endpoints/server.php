<?php
$app->get('/server', function () use ($app, $db) {
	echo "Server get";
});

$app->get('/server/:id', function ($id) use ($app, $db) {
	echo "Server get: $id";
});

$app->post('/server', function () use ($app, $db) {
	echo "Server get";
});

$app->get('/server/:id', function ($id) use ($app, $db) {
	echo "Server get: $id";
});

$app->delete('/server/:id', function ($id) use ($app, $db) {
	echo "Server delete: $id";
});
?>