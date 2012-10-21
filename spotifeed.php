<?php

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>Spotifeed</title>';
echo '<description>Spotifeed</description>';
echo '<link>http://www.torbennielsen.org</link>';
echo '<lastBuildDate>Mon, 06 Sep 2010 00:01:00 +0000 </lastBuildDate>';
echo '<pubDate>Mon, 06 Sep 2009 16:45:00 +0000 </pubDate>';
echo '<ttl>1800</ttl>';

?>

<?php
    include("simple_html_dom.php");
    
    $the_playlist_url = "https://embed.spotify.com/?uri=spotify:user:illztherocker:playlist:4hYlcIhuqsKl6VxN59POX9";
    $the_playlist_html = file_get_html($the_playlist_url);
    
    $the_tracks_html = $the_playlist_html->find('ul[class=track-info]');
    
    foreach($the_tracks_html as $track) {
        $the_track['uri'] = get_uri($track);
        $the_track['title'] = get_title($track);
        $the_track['artist'] = get_artist($track);
        $the_tracks[] = $the_track;
    }

    //echo count($the_tracks);
    //print_r($the_tracks);
    
    foreach($the_tracks as $track) {
        echo "<item>";
        echo "<title>".$track['title']."</title>";
        echo "<description>".$track['artist']."</description>";
        echo "<link>http://open.spotify.com/track/".$track['uri']."</link>";
        echo "<guid>".$track['uri']."</guid>";
        echo "<pubDate>Mon, 06 Sep 2009 16:45:00 +0000 </pubDate>";
        echo "</item>";
    }
    
    function get_uri($track_html) {
        $uri = explode(' ', $track_html->find("li",1)->class);
        return $uri[1];
    }
    
    function get_title($track_html) {
        $title = explode(' ', $track_html->find("li",1)->plaintext, 2);
        return $title[1];
    }
    
    function get_artist($track_html) {
        return $track_html->find("li",2)->plaintext;
    }
?>

</channel>
</rss>