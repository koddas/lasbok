<?php
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\SessionInterface;

class SessionImpl extends AbstractStorage implements SessionInterface {
	
	private $db;
	
	public function __construct($db) {
		super();
		$this->db = $db;
	}
	
	/**
     * {@inheritdoc}
     */
	public function getByAccessToken(AccessTokenEntity $accessToken) {
		$where = array('oauth_access_tokens.access_token' => $accessToken->getId());
		$cols = array('oauth_sessions.id', 'oauth_sessions.owner_type',
				'oauth_sessions.owner_id', 'oauth_sessions.client_id',
				'oauth_sessions.client_redirect_uri');
		$join = array('[>]oauth_access_tokens', ['oauth_access_tokens.session_id' => 'oauth_sessions.id']);
		$result = $this->db->select('oauth_sessions', $join, $cols, $where);
		
		if (count($result) === 1) {
			$session = new SessionEntity($this->server);
			$session->setId($result[0]['id']);
			$session->setOwner($result[0]['owner_type'], $result[0]['owner_id']);
		
			return $session;
		}
		
		return;
	}
	
	/**
     * {@inheritdoc}
     */
	public function getByAuthCode(AuthCodeEntity $authCode) {
		$where = array();
		$cols = array('oauth_sessions.id', 'oauth_sessions.owner_type',
				'oauth_sessions.owner_id', 'oauth_sessions.client_id',
				'oauth_sessions.client_redirect_uri');
		$join = array('oauth_auth_codes', ['oauth_auth_codes.session_id' => 'oauth_sessions.id']);
		$result = $this->db->select('oauth_sessions', $join, $cols, $where);
		
		if (count($result) === 1) {
			$session = new SessionEntity($this->server);
			$session->setId($result[0]['id']);
			$session->setOwner($result[0]['owner_type'], $result[0]['owner_id']);
		
			return $session;
		}
		
		return;
	}
	
	/**
     * {@inheritdoc}
     */
	public function getScopes(SessionEntity $session) {
		$where = array('oauth_scopes' => $session->getId());
		$cols = 'oauth_scopes.*';
		$join = array('[>]oauth_session_scopes' => ['oauth_sessions.id' => 'oauth_session_scopes.session_id'],
					  '[>]oauth_scopes' => ['oauth_scopes.id' => 'oauth_session_scopes.scope']
		);
		$result = $this->db->select('oauth_sessions', $join, $cols, $where);
		
		$scopes = [];
		
		foreach ($result as $scope) {
			$scopes[] = (new ScopeEntity($this->server))->hydrate([
					'id'            =>  $scope['id'],
					'description'   =>  $scope['description'],
			]);
		}
		
		return $scopes;
	}
	
	/**
     * {@inheritdoc}
     */
	public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null) {
		$id = $this->db->insert('oauth_sessions', [
				'owner_type'  =>    $ownerType,
				'owner_id'    =>    $ownerId,
				'client_id'   =>    $clientId,
		]);
		
		return $id;
	}
	
	/**
     * {@inheritdoc}
     */
	public function associateScope(SessionEntity $session, ScopeEntity $scope) {
		$this->db->insert('oauth_session_scope', [
				'session_id'    =>  $session->getId(),
				'scope'         =>  $scope->getId(),
		]);
	}
}