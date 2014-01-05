<?php
$app->get('/card', function () use ($app, $db) {
	echo "Card get";
});

$app->get('/card/:id', function ($id) use ($app, $db) {
	echo "Card get: $id";
});

$app->post('/card', function () use ($app, $db) {
	echo "Card post";
});

$app->put('/card/:id', function ($id) use ($app, $db) {
	echo "Card put: $id";
});

$app->delete('/card/:id', function ($id) use ($app, $db) {
	echo "Card delete: $id";
});

$app->get('/card/:id/door', function ($id) use ($app, $db) {
	echo "Card door get: $id";
});

$app->post('/card/:id/door', function ($id) use ($app, $db) {
	echo "Card door post: $id";
});

$app->get('/card/:id/door/:did', function ($id, $did) use ($app, $db) {
	echo "Card door delete: $id, $did";
});
?>