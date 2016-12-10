<?php

namespace Yahoo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;


class DefaultController extends Controller
{

	public function YahooAuthorizationAction(Request $request)
    {
	    $yahooService = $this->get('AG.Yahoo.OAuth2.Service');
	    header("HTTP/1.1 302 Found");
	    header("Location: " . $yahooService->getAuthorizationUrl());
	    exit;
    }

	public function YahooAccessTokenAction(Request $request)
	{
		$yahooService = $this->get('AG.Yahoo.OAuth2.Service');
		$code = $request->get('code',null);
		if($code) {
			$token = $yahooService->getAccessToken($code);
			$session = $this->get('session');
			$session->set('yahoo_access_token', $token);
		}
		return new JsonResponse('Success');
	}

	public function YahooContactsAction(Request $request)
	{
		$yahooService = $this->get('AG.Yahoo.OAuth2.Service');
		$code = $request->get('code',null);
		$contacts = null;
		if($code) {
			$contacts = $yahooService->getContacts($code);
		}
		return new JsonResponse($contacts);
	}
}
