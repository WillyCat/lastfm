<?php

class lastfmSimilar extends lastfmrpc
{
	private $len;
	private $artists;

	public function
	__construct($artist)
	{
		parent::__construct(['artist' => $artist, 'method' => 'artist.getsimilar' ]);
		$res = $this -> fetchData();

		$artists = [ ];
		if (property_exists ($res, 'similarartists')
		&&  property_exists ($res -> similarartists, 'artist'))
			foreach ($res -> similarartists -> artist as $a)
			{
				$artist = [];
				$artist['name'] = $a -> name;
				$artist['mbid'] = $a -> mbid;
				$artist['match'] = round($a -> match * 100) . '%';
				$artists[] = $artist;
			}
		$this -> artists = $artists;
		$this -> len = count ($this -> artists);
	}

	public function
	countArtists(): int
	{
		return $this -> len;
	}

	// returns an array of [ 'name', 'mbid', 'match' ]
	public function
	getArtists(): array
	{
		return $this -> artists;
	}
}
?>
