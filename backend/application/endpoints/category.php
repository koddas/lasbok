<?php
$app->get('/category', function () use ($app, $db) {
	echo "Category get";
});

$app->get('/category/:id', function ($id) use ($app, $db) {
	echo "Category get: $id";
});

$app->post('/category', function () use ($app, $db) {
	echo "Category get";
});

$app->get('/category/:id', function ($id) use ($app, $db) {
	echo "Category get: $id";
});

$app->delete('/category/:id', function ($id) use ($app, $db) {
	echo "Category delete: $id";
});
?>