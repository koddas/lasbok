<?php
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\AccessTokenInterface;

class AccessTokenStorageImpl extends AbstractStorage implements AccessTokenInterface {
	
	private $db;
	
	public function __construct($db) {
		super();
		$this->db = $db;
	}
	
	/**
     * {@inheritdoc}
     */
	public function get($token) {
		$result = $this->db->select('oauth_access_tokens', '*',
				['access_token' => $token]);
		
		if (count($result) === 1) {
			$token = (new AccessTokenEntity($this->server))
			->setId($result[0]['access_token'])
			->setExpireTime($result[0]['expire_time']);
		
			return $token;
		}
		
		return;
	}
	
	/**
     * {@inheritdoc}
     */
	public function getScopes(AccessTokenEntity $token) {
		$result = $this->db->select('oauth_access_token_scopes',
				['oauth_scopes.id', 'oauth_scopes.description'],
				['[>]oauth_scopes' => ['oauth_access_token_scopes.scope' => 'oauth_scopes.id']],
				['accss_token' => $token-getId()]);
		
		$response = [];
		
		if (count($result) > 0) {
			foreach ($result as $row) {
				$scope = (new ScopeEntity($this->server))->hydrate([
						'id'            =>  $row['id'],
						'description'   =>  $row['description'],
				]);
				$response[] = $scope;
			}
		}
		
		return $response;
	}
	
	/**
     * {@inheritdoc}
     */
	public function create($token, $expireTime, $sessionId) {
		$this->db->insert('oauth_access_tokens',
			[
				'access_token'     =>  $token,
				'session_id'    =>  $sessionId,
				'expire_time'   =>  $expireTime,
		]);
	}
	
	/**
     * {@inheritdoc}
     */
	public function associateScope(AccessTokenEntity $token, ScopeEntity $scope) {
		$this->db->insert('oauth_access_token_scopes',
			[
				'access_token'  =>  $token->getId(),
				'scope' =>  $scope->getId(),
		]);
	}
	
	/**
     * {@inheritdoc}
     */
	public function delete(AccessTokenEntity $token) {
		$this->db->delete('oauth_access_tokens',
				['access_token' => $token->getId()]);
	}
}