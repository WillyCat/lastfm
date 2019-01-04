<?php

class lastfmArtistSearch extends lastfmrpc
{
	public function
	__construct($artist, $page = 0, $limit = 30)
	{
		parent::__construct([ 'artist' => $artist, 'method' => 'artist.search']);
		$this -> fetchData();
	}

	public function
	getResults()
	{
		return $this -> resultAsObject;
	}
}

?>
