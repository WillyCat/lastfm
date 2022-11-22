<?php

class lastfmArtistSearch extends lastfmrpc
{
	public function
	__construct(string $apikey, string $artist, $page = 0, $limit = 30)
	{
		parent::__construct([ 'apikey' => $apikey, 'artist' => $artist, 'method' => 'artist.search']);
		$this -> fetchData();
	}

	public function
	getResults()
	{
		return $this -> resultAsObject;
	}
}

?>
