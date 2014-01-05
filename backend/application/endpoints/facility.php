<?php
$app->get('/facility', function () use ($app, $db) {
	echo "Facility get";
});

$app->get('/facility/:id', function ($id) use ($app, $db) {
	echo "Facility get: $id";
});

$app->post('/facility', function () use ($app, $db) {
	echo "Facility post";
});

$app->put('/facility/:id', function ($id) use ($app, $db) {
	echo "Facility put: $id";
});

$app->delete('/facility/:id', function ($id) use ($app, $db) {
	echo "Facility delete: $id";
});

$app->get('/facility/:id/partitions', function ($id) use ($app, $db) {
	echo "Facility partitions get: $id";
});

$app->post('/facility/:id/partitions', function ($id) use ($app, $db) {
	echo "Facility partitions post: $id";
});

$app->get('/facility/:id/partitions/:pid', function ($id, $pid) use ($app, $db) {
	echo "Facility partitions delete: $id, $pid";
});

$app->get('/facility/:id/prices', function ($id) use ($app, $db) {
	echo "Facility prices get: $id";
});

$app->post('/facility/:id/prices', function ($id) use ($app, $db) {
	echo "Facility prices post: $id";
});

$app->get('/facility/:id/prices/:pid', function ($id, $pid) use ($app, $db) {
	echo "Facility prices delete: $id, $pid";
});
?>