<?php
$app->get('/site', function () use ($app, $db) {
	echo "Site get";
});

$app->get('/site/:id', function ($id) use ($app, $db) {
	echo "Site get: $id";
});

$app->post('/site', function () use ($app, $db) {
	echo "Site post";
});

$app->put('/site/:id', function ($id) use ($app, $db) {
	echo "Site put: $id";
});

$app->delete('/site/:id', function ($id) use ($app, $db) {
	echo "Site delete: $id";
});

$app->get('/site/:id/facilities', function ($id) use ($app, $db) {
	echo "Site facilities get: $id";
});

$app->post('/site/:id/facilities', function ($id) use ($app, $db) {
	echo "Site facilities post: $id";
});

$app->get('/site/:id/facilities/:fid', function ($id, $fid) use ($app, $db) {
	echo "Site facilities delete: $id, $fid";
});

$app->get('/site/:id/cards', function ($id) use ($app, $db) {
	echo "Site cards get: $id";
});

$app->post('/site/:id/cards', function ($id) use ($app, $db) {
	echo "Site cards post: $id";
});

$app->get('/site/:id/cards/:cid', function ($id, $cid) use ($app, $db) {
	echo "Site cards delete: $id, $cid";
});
?>