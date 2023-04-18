<?php
ini_set('display_errors', 1);
error_reporting(~0);
/**
 * Fichier de lancement du service Web
 * @author Ahmed Said
 * @version 1.1
 * @update 2023-04-08
 *
 * 
 */
//header('Content-Type: application/json; charset=utf8');
header('Access-Control-Allow-Origin: *');
		
header('Access-Control-Allow-Methods: OPTIONS, PUT, POST, GET, DELETE');
header('Access-Control-Allow-Credentials: true');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
	header('Access-Control-Allow-Headers: Accept, Accept-CH, Accept-Charset, Accept-Datetime, Accept-Encoding, Accept-Ext, Accept-Features, Accept-Language, Accept-Params, Accept-Ranges, Access-Control-Allow-Credentials, Access-Control-Allow-Headers,	Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Expose-Headers, Access-Control-Max-Age, Access-Control-Request-Headers, 	Access-Control-Request-Method, Age, Allow, Alternates, Authentication-Info, Authorization, C-Ext, C-Man, C-Opt, C-PEP, C-PEP-Info, CONNECT, 	Cache-Control, Compliance, Connection, Content-Base, Content-Disposition, Content-Encoding, Content-ID, Content-Language, Content-Length, 	Content-Location, Content-MD5, Content-Range, Content-Script-Type, Content-Security-Policy, Content-Style-Type, Content-Transfer-Encoding, Content-Type, 	Content-Version, Cookie, Cost, DAV, DELETE, DNT, DPR, Date, Default-Style, Delta-Base, Depth, Derived-From, Destination, Differential-ID, Digest, ETag, 	Expect, Expires, Ext, From, GET, GetProfile, HEAD, HTTP-date, Host, IM, If, If-Match, If-Modified-Since, If-None-Match, If-Range, If-Unmodified-Since, 	Keep-Alive, Label, Last-Event-ID, Last-Modified, Link, Location, Lock-Token, MIME-Version, Man, Max-Forwards, Media-Range, Message-ID, Meter, Negotiate, 	Non-Compliance, OPTION, OPTIONS, OWS, Opt, Optional, Ordering-Type, Origin, Overwrite, P3P, PEP, PICS-Label, POST, PUT, Pep-Info, Permanent, Position, 	Pragma, ProfileObject, Protocol, Protocol-Query, Protocol-Request, Proxy-Authenticate, Proxy-Authentication-Info, Proxy-Authorization, Proxy-Features, 	Proxy-Instruction, Public, RWS, Range, Referer, Refresh, Resolution-Hint, Resolver-Location, Retry-After, Safe, Sec-Websocket-Extensions, Sec-Websocket-Key, 	Sec-Websocket-Origin, Sec-Websocket-Protocol, Sec-Websocket-Version, Security-Scheme, Server, Set-Cookie, Set-Cookie2, SetProfile, SoapAction, Status, Status-URI, 	Strict-Transport-Security, SubOK, Subst, Surrogate-Capability, Surrogate-Control, TCN, TE, TRACE, Timeout, Title, Trailer, Transfer-Encoding, UA-Color, 	UA-Media, UA-Pixels, UA-Resolution, UA-Windowpixels, URI, Upgrade, User-Agent, Variant-Vary, Vary, Version, Via, Viewport-Width, WWW-Authenticate, Want-Digest, 	Warning, Width, X-Content-Duration, X-Content-Security-Policy, X-Content-Type-Options, X-CustomHeader, X-DNSPrefetch-Control, X-Forwarded-For, X-Forwarded-Port, 	X-Forwarded-Proto, X-Frame-Options, X-Modified, X-OTHER, X-PING, X-PINGOTHER, X-Powered-By, X-Requested-With');
	return;
}

	/***************************************************/
    /** Fichier de configuration, contient l'autoloader **/
    /***************************************************/
	require_once("./config.php");
	
   	/***************************************************/
    /** Initialisation des variables **/
    /***************************************************/
   	//var_dump($_GET);
   
	$oReq = new Requete();

	
	/* Instanciation du controlleur */
	if($oReq->ressource == ""){
		http_response_code(400);
		exit();
	}
	
	$nomControlleur = ucfirst($oReq->ressource) . 'Controlleur';
	
	if (class_exists($nomControlleur)) {
		
		$reflectionClass = new ReflectionClass($nomControlleur);
		
		if($reflectionClass->isInstantiable()){
			$oControlleur = new $nomControlleur();
			$nomAction = strtolower($oReq->verbe) . 'Action';
			$resultat = $oControlleur->$nomAction($oReq);

			// La vue!
			echo json_encode($resultat);
		}
		else{
			http_response_code(400);
			exit();
		}	
		
	}
	else{
		http_response_code(400);
		exit();
	}	
	
	
	
	
	
	
	
	
	
	
	
	
			