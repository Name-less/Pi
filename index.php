<!DOCTYPE html>
<html>
<body>

<h1>Le nid web page bro's</h1>

<p>Let's start with song</p>

<?php
if($_GET["dl"]){
	$url = $_GET["url_song"];
	echo "Downloading ...";
	echo "<br>";
	//$cmd = 'cd music;/usr/local/bin/youtube-dl --extract-audio --audio-format mp3 ' . escapeshellarg($url).'> /dev/null 2>/dev/null &;cd ..';
	$cmd = 'cd music;/usr/local/bin/youtube-dl --extract-audio --audio-format mp3 ' . escapeshellarg($url).'> /dev/null 2>/dev/null ;cd ..';
	//$cmd = '/usr/local/bin/youtube-dl -o "/home/pi/%(id)s.%(ext)s" ' . escapeshellarg($url);
	exec($cmd);
        echo '
        <script>
                window.location.replace("http://lenid.local/toto");
        </script>
';
}

if($_GET["play_song"]){
	$name =$_GET["name"];
	$name = str_replace(' ','\ ',$name);
	$name = str_replace('(','\(',$name);
	$name = str_replace(')','\)',$name);
	$name = str_replace('"','\"',$name);
	$name = str_replace("'","\'",$name);
	echo exec("kill $(ps -e | grep mplayer | cut -d ' ' -f 2)");
	$cmd = 'mplayer -idle ./music/'.$name.'> /dev/null 2>/dev/null &';
	//echo $cmd;
	echo "<br>";
	exec($cmd);
	echo '
	<script>
        	window.location.replace("http://lenid.local/toto");
	</script>
';
	//exec("mplayer -idle ./music/Black M - Foutue mlodie (audio)-ZsnYgCy0YrI.mp3");
}

if($_GET["stop_song"]){
	exec("kill $(ps -e | grep mplayer | cut -d ' ' -f 2)");
}

if($_GET["pause_song"]){
        exec("sudo kill -SIGSTOP $(ps -e | grep mplayer | cut -d ' ' -f 2)");
}

if($_GET["keep_song"]){
        exec("sudo kill -SIGCONT $(ps -e | grep mplayer | cut -d ' ' -f 2)");
}

$dir = '/home/pi/music';

$dh  = opendir($dir);
$pattern = '/*';
while (false !== ($filename = readdir($dh))) {
	if(preg_match('`[a-z]*[m][p][3]`',$filename)){
	//if(preg_match('`^[[:alnum:]]`',$filename)){
	        echo '<a href="/toto?play_song=true&name='.$filename.'">'.$filename.'</a>';
        	echo "<br>";
		echo "<br>";
	}
}
	echo "<br>";
	echo "<br>";

?>
<form action="toto" method="GET">

	<input type="text" style="width:400px;" name="url_song">
	<input type="hidden" name="dl" value="true"> 
	<input type="submit" value="Download song from youtube !">

</form>

<br>
<br>

<button onclick="window.location.href='/toto?stop_song=true'">Stop song bitches !</button>

<button onclick="window.location.href='/toto?pause_song=true'">Pause broh it is enough</button>
<button onclick="window.location.href='/toto?keep_song=true'">Continue broh</button>


</body>
</html>
