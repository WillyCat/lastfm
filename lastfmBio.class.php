<?php

class lastfmBio extends lastfmrpc
{
	public function
	__construct($artist)
	{
		parent::__construct([ 'artist' => $artist, 'method' => 'artist.getinfo']);
		$this -> fetchData();
	}

	public function
	getImage ($size = 'medium')
	{
		return lastfmImage::getImage ($this -> resultAsObject -> artist -> image, $size);
	}

	public function
	getContent(): string
	{
		if (isset ($this -> resultAsObject -> artist -> bio -> content))
			return strip_tags($this -> resultAsObject -> artist -> bio -> content);
		else
			return '';
	}

	public function
	getSummary(): string
	{
		if (isset ($this -> resultAsObject -> artist -> bio -> summary))
			return strip_tags($this -> resultAsObject -> artist -> bio -> summary);
		else
			return '';
	}

	public function
	getResultAsObject()
	{
		return $this -> resultAsObject;
	}
}
?>
