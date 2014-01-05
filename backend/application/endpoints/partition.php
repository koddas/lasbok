<?php
$app->get('/partition', function () use ($app, $db) {
	echo "Partition get";
});

$app->get('/partition/:id', function ($id) use ($app, $db) {
	echo "Partition get: $id";
});

$app->post('/partition', function () use ($app, $db) {
	echo "Partition post";
});

$app->put('/partition/:id', function ($id) use ($app, $db) {
	echo "Partition put: $id";
});

$app->delete('/partition/:id', function ($id) use ($app, $db) {
	echo "Partition delete: $id";
});

$app->get('/partition/:id/doors', function ($id) use ($app, $db) {
	echo "Partition doors get: $id";
});

$app->post('/partition/:id/doors', function ($id) use ($app, $db) {
	echo "Partition doors post: $id";
});

$app->get('/partition/:id/doors/:did', function ($id, $did) use ($app, $db) {
	echo "Partition doors delete: $id, $did";
});
?>