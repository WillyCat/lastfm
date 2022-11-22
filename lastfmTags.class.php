<?php

class lastfmTags extends lastfmrpc
{
	private $len;
	private $tags;

	public function
	__construct(string $apikey, string $artist)
	{
		parent::__construct(['apikey' => $apikey, 'artist' => $artist, 'method' => 'artist.getTopTags'] );

		$res = $this -> fetchData();

		// 2 formes:
		// {"tags":{"#text":" ","@attr":{"artist":"Cher"}}}
		// {"tags":{"tag":[{"name":"rock","url":"https://www.last.fm/tag/rock"},{"name":"funky","url":"https://www.last.fm/tag/funky"}],"@attr":{"artist":"Red Hot Chili Peppers"}}}

		$this -> tags = [];
		if (property_exists ($res, 'tags')
		&&  property_exists ($res -> tags, 'tag'))
			foreach ( $res -> tags -> tag as $tagObject)
				$this -> tags[] = $tagObject -> name;
		$this -> len = count($this -> tags);
	}

	public function
	countTags(): int
	{
		return $this -> len;
	}

	// returns an array of tags
	public function
	getTags(): array
	{
		return $this -> tags;
	}

}
?>
