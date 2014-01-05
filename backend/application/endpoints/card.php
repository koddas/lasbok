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

$app->get('/card/:id/ports', function ($id) use ($app, $db) {
	echo "Card port get: $id";
});

$app->get('/card/:id/ports/:pid', function ($id, $pid) use ($app, $db) {
	echo "Card port get: $id, $pid";
});

$app->get('/card/:id/ports/:pid/door', function ($id, $pid) use ($app, $db) {
	echo "Card port get: $id, $pid";
});

$app->post('/card/:id/ports/:pid/door', function ($id, $pid) use ($app, $db) {
	echo "Card port post: $id, $pid";
});

$app->get('/card/:id/ports/:pid/door/:did', function ($id, $pid, $did) use ($app, $db) {
	echo "Card port delete: $id, $pid, $did";
});
?>