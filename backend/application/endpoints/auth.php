<?php
$server = new \League\OAuth2\Server\AuthorizationServer;

$server->setSessionStorage(new Storage\SessionStorage);
$server->setAccessTokenStorage(new Storage\AccessTokenStorage);
$server->setClientStorage(new Storage\ClientStorage);
$server->setScopeStorage(new Storage\ScopeStorage);

$clientCredentials = new \League\OAuth2\Server\Grant\ClientCredentialsGrant();
$server->addGrantType($clientCredentials);

$passwordGrant = new \League\OAuth2\Server\Grant\PasswordGrant();
$passwordGrant->setVerifyCredentialsCallback(function ($username, $password) {
	$where = array('user_name' => $username, 'password' => $password);
	$result = $db->select('Users', 'user_name', $where);
	
	if (count($result) == 1 ) {
		return $result[0]['user_name'];
	}
	return;
});
$server->addGrantType($passwordGrant);

$app->get('/auth', function () use ($app, $server) {
	// Use client credentials, i.e. a key
	try {
		$response = $server->issueAccessToken();
		$app->response->headers->set('Content-Type', 'application/json');
		$app->response->headers->set('Cache-Control', 'no-store');
		$app->response->headers->set('Pragma', 'no-store');
		$app->response->body("{'auth_token': '" . $response . "'}");
	} catch (\Exception $e) {
		$app->halt($e->httpStatusCode, 'Unauthorized');
	}
	
});

$app->post('/auth', function () use ($app, $server) {
	// Use username/password
	try {
		$response = $server->issueAccessToken();
		$app->response->headers->set('Content-Type', 'application/json');
		$app->response->headers->set('Cache-Control', 'no-store');
		$app->response->headers->set('Pragma', 'no-store');
		$app->response->body("{'auth_token': '" . $response . "'}");
	} catch (\Exception $e) {
		$app->halt($e->httpStatusCode, 'Unauthorized');
	}
});
?>