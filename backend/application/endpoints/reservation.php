<?php
$app->get('/reservation', function () use ($app, $db) {
	echo "Reservation get";
});

$app->get('/reservation/:id', function ($id) use ($app, $db) {
	echo "Reservation get: $id";
});

$app->post('/reservation', function () use ($app, $db) {
	echo "Reservation post";
});

$app->put('/reservation/:id', function ($id) use ($app, $db) {
	echo "Reservation put: $id";
});

$app->delete('/reservation/:id', function ($id) use ($app, $db) {
	echo "Reservation delete: $id";
});

$app->get('/reservation/:id/facilities', function ($id) use ($app, $db) {
	echo "Reservation facilities get: $id";
});

$app->post('/reservation/:id/facilities', function ($id) use ($app, $db) {
	echo "Reservation facilities post: $id";
});

$app->get('/reservation/:id/facilities/:fid', function ($id, $fid) use ($app, $db) {
	echo "Reservation facilities delete: $id, $fid";
});

$app->get('/reservation/search/by/:customer', function ($customer) use ($app, $db) {
	echo "Reservation search get: $customer";
});

$app->get('/reservation/search/from/:start/to/:stop', function ($start, $stop) use ($app, $db) {
	echo "Reservation from to get: $start, $stop";
});

$app->get('/reservation/search/from/:start/to/:stop/by/:customer',
		  function ($start, $stop, $customer) use ($app, $db) {
	echo "Reservation from to get: $start, $stop, $customer";
});
?>