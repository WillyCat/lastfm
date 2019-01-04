<?php
class lastfmImage
{
	public static function
	getImage ($imageArray, $size = 'medium'): ?string
	{
		if (!in_array ($size, [ 'small', 'medium', 'large', 'mega', 'extralarge' ]))
			throw new Exception ('size not supported: ' . $size);

		foreach ($imageArray as $img)
			if ($img->size == $size)
				return $img->{'#text'};

		return null;
	}
}
?>
