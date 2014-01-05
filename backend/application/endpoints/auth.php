<?php
$app->get('/auth', function () use ($app, $db) {
	echo "Auth get";
});

$app->get('/auth/:id', function ($id) use ($app, $db) {
	echo "Auth get: $id";
});

$app->delete('/auth/:id', function ($id) use ($app, $db) {
	echo "Auth delete: $id";
});
?>