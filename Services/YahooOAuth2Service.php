<?php

namespace YahooApiBundle\Services;

class YahooOAuth2Service {

	const AUTHORIZATION_ENDPOINT = 'https://api.login.yahoo.com/oauth2/request_auth';
	const TOKEN_ENDPOINT = 'https://api.login.yahoo.com/oauth2/get_token';
	const YAHOO_CONTACTS_ENDPOINT = 'https://social.yahooapis.com/v1/user/me/contacts?format=json';

	public function __construct(array $config)
	{
		$this->client_id = $config['consumer_key'];
		$this->client_secret = $config['consumer_secret'];
		$this->callback = $config['callback_url'];
	}

	public function getAuthorizationUrl( $language = "en-us" ) {
		$url = self::AUTHORIZATION_ENDPOINT;
		$authorization_url = $url . '?' . 'client_id=' . $this->client_id . '&redirect_uri=' . $this->callback . '&language=' . $language . '&response_type=code';
		return $authorization_url;
	}

	public function getAccessToken( $code ) {
		$url = self::TOKEN_ENDPOINT;
		$postData = array( "redirect_uri" => $this->callback, "code" => $code, "grant_type" => "authorization_code" );
		$auth = $this->client_id . ":" . $this->client_secret;
		$response = self::fetch( $url, $postData, $auth );
		$jsonResponse = json_decode( $response );
		return $jsonResponse->access_token;
	}

	public function getContacts( $code ) {
		$url = self::YAHOO_CONTACTS_ENDPOINT;
		$token = $this->getAccessToken($code);
		$headers = array(
			'Authorization: Bearer '.$token,
			'Accept: application/json',
			'Content-Type: application/json'
		);
		$response = $this->fetch($url, null, null, $headers);
		return $jsonResponse = json_decode( $response );
	}

	public function fetch( $url, $postData = "", $auth = "", $headers = "" ) {
		$curl = curl_init( $url );
		if ( $postData ) {
			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $postData ) );
		} else {
			curl_setopt( $curl, CURLOPT_POST, false );
		}
		if ( $auth ) {
			curl_setopt( $curl, CURLOPT_USERPWD, $auth );
		}
		if ( $headers ) {
			curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
		}
		curl_setopt( $curl, CURLOPT_HEADER, false );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		$response = curl_exec( $curl );
		if ( empty( $response ) ) {
			die( curl_error( $curl ) );
			curl_close( $curl );
		} else {
			$info = curl_getinfo( $curl );
			curl_close( $curl );
			if ( $info['http_code'] != 200 && $info['http_code'] != 201 ) {
				echo "Received error: " . $info['http_code'] . "\n";
				echo "Raw response:" . $response . "\n";
				die();
			}
		}
		return $response;
	}

}

?>