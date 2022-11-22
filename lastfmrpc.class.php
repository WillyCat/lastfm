<?php

/**
 * Classes to access last.fm
 *
 * $l = new lastfmBio('Cher');
 * $l -> getSummary(): string
 * $l -> getContent(): string
 *
 * $l = new lastfmSimilar('Cher');
 * $l -> countArtists(): int
 * $l -> getArtists(): array of objects
 *
 * $l = new lastfmTags('Cher');
 * $l -> countTags(): int
 * $l -> getTags(): array of objects

 * @see https://www.last.fm/fr/api
 */

abstract class lastfmrpc
{
	// query infos - functional
	private $artist;
	private $mbid;
	private $method;

	// query infos - technical
	private $user   = 'RJ';
	private $format = 'json';
	private $apikey = '';
	private $ws     = 'http://ws.audioscrobbler.com/2.0';

	/*
	// https://www.nicolas-birckel.fr/javascript/2017/12/14/jouons-avec-l-API-de-lastfm.html
	var apikey ="50ad8f29fba1727d9f76646a56242eb0";
	var user= "nbirckel";
	*/

	// http query
	private $url;

	// http response
	private $response;	// response object
	protected $resultAsObject;	// response object (result after decoding of body)


	public function
	__construct($parms = null)
	{
		$this -> method = '';
		$this -> artist = '';
		$this -> mbid = '';

		if (is_array($parms))
			foreach ($parms as $name => $value)
				$this -> setParm ($name, $value);
	}

	/**
	 * @param string $code Artist MBID or artist name
	 * @throws Exception Si le parametre est incorrect
	 * @return void
	*/
	private function
	setParm (string $name, string $value): void
	{
		switch ($name)
		{
		case 'artist': $this -> setArtist($value); break;
		case 'method': $this -> setMethod($value); break;
		case 'apikey': $this -> apikey = $value; break;
		default: throw new Exception ('Unknown parm ' . $name);
		}
	}

	/**
	 * @param string $code Artist MBID or artist name
	 * @return void
	*/
	protected function
	setArtist (string $code): void
	{
		if ($this -> isMbid ($code))
			$this -> mbid = $code;
		else
			$this -> artist = $code;
	}

	// indique si l'identifiant est un MBID ou pas
	private function
	isMbid (string $code): bool
	{
		// bfcc6d75-a6a5-4bc6-8282-47aec8531818
		$pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';
		if (preg_match ($pattern, $code) == 1)
			return true;
		else
			return false;
	}

	protected function
	setMethod (string $method): void
	{
		$this -> method = $method;
	}

	protected function
	fetchData()
	{
		$this -> buildUrl();
		$this -> fetch();
		switch ($this -> format)
		{
		case 'json' :
			$this -> resultAsObject = json_decode ($this -> getRawResponse());
			if (property_exists ($this->resultAsObject, 'error'))
			{
				throw new Exception ($this->resultAsObject -> message);
			}
			break;
		default:
			throw new Exception ('Format not implemented: '.$this -> format);
		}
		return $this -> resultAsObject;
	}

	public function
	getRawResponse(): string
	{
		return $this -> response -> getBody();
	}

	public function
	getResult(): stdClass
	{
		return $this -> resultAsObject;
	}

	private function
	buildUrl(): string
	{
		$parms = [];
		$parms['api_key'] = $this -> apikey;
		$parms['method']  = $this -> method;
		if ($this -> mbid != '')
			$parms['mbid'] = $this -> mbid;
		else
			if ($this -> artist != '')
				$parms['artist']  = $this -> artist;
			else
				throw new Exception ('No artist code or MBID');
		$parms['user']    = $this -> user;
		$parms['format']  = $this -> format;

		$url = $this -> ws;
		$url .= '/?';
		foreach ($parms as $key => $value)
			$url .= '&' . $key . '=' . urlencode($value);

		$this -> url = $url;
		return $url;
	}

	public function
	getUrl(): string
	{
		return $this -> url;
	}

	private function
	fetch(): void
	{
		$r = new tinyHttp($this -> url);
		$this -> response = $r->send();
		if ($this -> response -> getStatus() != 200)
			throw new Exception ('HTTP code ' . $this -> response -> getStatus());
			//throw new Exception ('HTTP error');
	}
}
?>

