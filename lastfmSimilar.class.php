<?php

class lastfmSimilar extends lastfmrpc
{
	private $len;
	private $artists;

	public function
	__construct(string $apikey, string $artist)
	{
		parent::__construct([ 'apikey' => $apikey, 'artist' => $artist, 'method' => 'artist.getsimilar' ]);
		$res = $this -> fetchData();

		$artists = [ ];
		if (property_exists ($res, 'similarartists')
		&&  property_exists ($res -> similarartists, 'artist'))
			foreach ($res -> similarartists -> artist as $a)
			{
				$artist = [];
				$artist['name'] = $a -> name;
				if (property_exists ($a, 'mbid'))
					$artist['mbid'] = $a -> mbid;
				else
					$artist['mbid'] = '';
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
