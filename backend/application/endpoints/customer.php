<?php
$app->get('/customer', function () use ($app, $db) {
	echo "Customer get";
});

$app->get('/customer/:id', function ($id) use ($app, $db) {
	echo "Customer get: $id";
});

$app->post('/customer', function () use ($app, $db) {
	echo "Customer get";
});

$app->get('/customer/:id', function ($id) use ($app, $db) {
	echo "Customer get: $id";
});

$app->delete('/customer/:id', function ($id) use ($app, $db) {
	echo "Customer delete: $id";
});

$app->get('/customer/search/:string', function ($string) use ($app, $db) {
	echo "Customer search get: $string";
});

$app->get('/customer/from/:start/to/:stop', function ($start, $stop) use ($app, $db) {
	echo "Customer from to get: $start, $stop";
});
?>