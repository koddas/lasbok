<?php
$app->get('/building', function () use ($app, $db) {
	echo "Building get";
});

$app->get('/building/:id', function ($id) use ($app, $db) {
	echo "Building get: $id";
});

$app->post('/building', function () use ($app, $db) {
	echo "Building post";
});

$app->put('/building/:id', function ($id) use ($app, $db) {
	echo "Building put: $id";
});

$app->delete('/building/:id', function ($id) use ($app, $db) {
	echo "Building delete: $id";
});

$app->get('/building/:id/facilities', function ($id) use ($app, $db) {
	echo "Building facilities get: $id";
});

$app->post('/building/:id/facilities', function ($id) use ($app, $db) {
	echo "Building facilities post: $id";
});

$app->get('/building/:id/facilities/:fid', function ($id, $fid) use ($app, $db) {
	echo "Building facilities delete: $id, $fid";
});
?>