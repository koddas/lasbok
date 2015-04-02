<?php
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\ScopeStorage;

class ScopeStorageImpl extends AbstractStorage implements ScopeStorage {
	
	private $db;
	
	public function __construct($db) {
		super();
		$this->db = $db;
	}
	
	/**
     * {@inheritdoc}
     */
	public function get($scope, $grantType = null, $clientId = null) {
		$result = $this->db->select('oauth_scopes', '*', ['id' => $scope]);
		
		if (count($result) === 0) {
			return;
		}
		
		return (new ScopeEntity($this->server))->hydrate([
				'id'            =>  $result[0]['id'],
				'description'   =>  $result[0]['description'],
		]);
	}
}