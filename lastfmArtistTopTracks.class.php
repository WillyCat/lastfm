<?php

class lastfmArtistTopTracks extends lastfmrpc
{
	private $len;
	private $tracks;

	public function
	__construct(string $apikey, string $artist)
	{
		parent::__construct(['apikey' => $apikey, 'artist' => $artist, 'method' => 'artist.getTopTracks'] );

		$res = $this -> fetchData();

		$this -> tracks = [];
		if (property_exists ($res, 'toptracks')
		&&  property_exists ($res -> toptracks, 'track'))
			foreach ( $res -> toptracks -> track as $trackObject)
			{
				$track = [ ];
				$track['rank'] = $trackObject -> {'@attr'} -> rank;
				$track['name'] = $trackObject -> name;
				$track['playcount'] = $trackObject -> playcount;
				if (property_exists ($trackObject, 'mbid'))
					$track['mbid'] = $trackObject -> mbid;
				else
					$track['mbid'] = '';
				$track['url'] = $trackObject -> url;
				$artist = [ ];
				$artist['name'] = $trackObject -> artist -> name;
				$artist['mbid'] = $trackObject -> artist -> mbid;
				$track['artist'] = $artist;
				$this -> tracks[] = $track;
			}
		$this -> len = count($this -> tracks);
	}

	public function
	countTracks(): int
	{
		return $this -> len;
	}

	// returns an array of tags
	public function
	getTracks(): array
	{
		return $this -> tracks;
	}

}
?>
