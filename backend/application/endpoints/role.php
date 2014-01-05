<?php
$app->get('/role', function () use ($app, $db) {
	echo "Role get";
});

$app->get('/role/:id', function ($id) use ($app, $db) {
	echo "Role get: $id";
});

$app->post('/role', function () use ($app, $db) {
	echo "Role get";
});

$app->get('/role/:id', function ($id) use ($app, $db) {
	echo "Role get: $id";
});

$app->delete('/role/:id', function ($id) use ($app, $db) {
	echo "Role delete: $id";
});
?>