<?php
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\ClientInterface;

class ClientStorageImpl extends AbstractStorage implements ClientInterface {
	
	private $db;
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	/**
     * {@inheritdoc}
     */
	public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null) {
		$result = null;
		$where = array('oauth_clients.id' => $clientId);
		
		if ($clientSecret !== null) {
			$where['oauth_clients.secret'] = $clientSecret;
		}
		
		if ($redirectUri) {
			$cols = array('oauth_clients.*', 'oauth_client_redirect_uris.*');
			$join = array('[>]oauth_client_redirect_uris' =>
					['oauth_clients.id' => 'oauth_client_redirect_uris.client_id']);
			$where['oauth_client_redirect_uris.redirect_uri'] = $redirectUri;
			$result = $this->db->select('oauth_clients', $join, $cols, $where);
		} else {
			$result = $this->db->select('oauth_clients', '*', $where);
		}
		
		if (count($result) === 1) {
			$client = new ClientEntity($this->server);
			$client->hydrate([
					'id'    =>  $result[0]['id'],
					'name'  =>  $result[0]['name'],
			]);
		
			return $client;
		}
		
		return;
	}
	
	/**
     * {@inheritdoc}
     */
	public function getBySession(SessionEntity $session) {
		$result = $this->db->select('oauth_clients',
				['oauth_clients.id', 'oauth_clients.name'] =>
				['[>]oauth_sessions', 'oauth_clients.id' => 'oauth_sessions.client_id'],
				['oauth_sessions.id' => $session->getId()]);
		
		if (count($result) === 1) {
			$client = new ClientEntity($this->server);
			$client->hydrate([
					'id'    =>  $result[0]['id'],
					'name'  =>  $result[0]['name'],
			]);
		
			return $client;
		}
		
		return;
	}
}