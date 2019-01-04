<?php

spl_autoload_register ('myautoloader');
function
myautoloader ($class_name)
{
	$fn =  $class_name . '.class.php';

	$paths = [ '.' , '../prod' , '/home/fhou732/classes' ];

	foreach ($paths as $path)
	{
		$pathname =  $path . '/' . $fn;
		if (file_exists ($pathname))
		{
			include $pathname;
			return;
		}
	}
	return;
}

/*
$t = new lastfmTags ('Red Hot Chili Peppers');
$len = $t -> countTags();
echo 'Tags: ' . $len . "\n";
if ($len > 0)
{
	$tags = $t -> getTags();
	foreach ($tags as $tag)
		echo $tag . "\n";
}
*/

$id = 'bfcc6d75-a6a5-4bc6-8282-47aec8531818';	// Cher
$id = 'Red Hot Chili Peppers';
$id = 'Nirvana';
$id = '9282c8b4-ca0b-4c6b-b7e3-4f7762dfc4d6';	// Nirvana
$id = 'MC Solaar';

$displayRaw = false;

echo "===================================================================\n";
echo "lastfmSimilar\n";
echo "===================================================================\n";
$t = new lastfmSimilar ($id);
echo 'URL: ' . $t->getUrl() . "\n";
if ($displayRaw)
{
	echo "RAW RESPONSE\n";
	echo $t -> getRawResponse() . "\n";
	echo "OBJECT RESPONSE\n";
}
$len = $t -> countArtists();
echo 'Artists: ' . $len . "\n";
if ($len > 0)
{
	$max = 10;
	$i = 0;

	$artists = $t -> getArtists();
	foreach ($artists as $artist)
	{
		echo $artist['name'] . ' (' . $artist['mbid'] . '): ' . $artist['match'] . "\n";
		$i++;
		if ($i >= $max)
			break;
	}
}

echo "===================================================================\n";
echo "lastfmTags\n";
echo "===================================================================\n";
$t = new lastfmTags ($id);
echo 'URL: ' . $t->getUrl() . "\n";
if ($displayRaw)
{
	echo "RAW RESPONSE\n";
	echo $t -> getRawResponse() . "\n";
	echo "OBJECT RESPONSE\n";
}
$nb = $t -> countTags();
echo 'Tags: ' . $nb . "\n"; 
print_r ($t->getTags());

echo "===================================================================\n";
echo "lastfmBio\n";
echo "===================================================================\n";
// at the end of the bio
// <a href="https://www.last.fm/music/Nirvana">Read more on Last.fm</a>
$t = new lastfmBio ($id);
echo 'URL: ' . $t->getUrl() . "\n";
$r = $t -> getResultAsObject();
print_r ($r);
$img = $t -> getImage('medium');
echo 'Medium image: ' . $img . "\n";
$img = $t -> getImage('large');
echo 'Large image: ' . $img . "\n";

$t = new lastfmArtistSearch ('Cher');
$r = $t -> getResults();
// print_r ($r);
$artists = $r -> results -> artistmatches -> artist;
foreach ($artists as $artist)
	printf ("%-20.20s | %-20.20s | %-20.20s |\n", $artist -> name, $artist -> mbid, lastfmImage::getImage($artist->image,'medium'));

echo "===================================================================\n";
echo "lastfmArtistTopTracks\n";
echo "===================================================================\n";
$t = new lastfmArtistTopTracks($id);
// echo $t -> getRawResponse();
$nb = $t -> countTracks();
echo 'TRACKS: ' . $nb . "\n";
$tracks = $t -> getTracks();
foreach ($tracks as $track)
{
	//printf ("%-20.20s | %-20.20s | %-20.20s\n", $track['name'], $track['artist']['name'], $track['artist']['mbid']);
	printf ("%-2s | %-30.30s \n", $track['rank'], $track['name']);
}
?>
