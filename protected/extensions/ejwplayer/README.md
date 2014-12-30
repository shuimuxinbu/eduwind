# EjwPlayer

### Overview

EjwPlayer is a Yii widget for embedding JWPlayer v.6 into your web applications. 
If you have purchased the licensed player, swap out the files in 'assets' with your copies.

*NOTE: I have not tested this widget with all possible combinations of JW settings. If you come accross 
any bugs, please let me know.

### Installation

Either clone or unzip the directory into protected/extenstions/EjwPlayer  (or other relevant folder based on your setup).

### Usage

Here is an example of embedding a 2-video playlist, with 2 bitrates for each (270p and 720p):

	<?php $this->widget('ext.EjwPlayer.EjwPlayer',array(
		'width' => 1280,
		'height' => 720,
		'title' => 'My Test Video',
		'controls' => 'false',
		'playlist' => array(
			array(
				'image' => '/sample-preview.jpg',
				'sources' => array(
					array('file' => '/videos/sample-270.mp4', 'height' => 270),
					array('file' => '/videos/sample-720.mp4', 'height' => 720),
				)
			),
			array(
				'image' => 'https://eduk-videos.s3.amazonaws.com/sey/2012-09-29/js-speaker5-preview.jpg',
				'sources' => array(
					array('file' => '/videos/sample2-270.mp4', 'height' => 270),
					array('file' => '/videos/sample2-720.mp4', 'height' => 720),
				)
			),
		),
	)); ?>

### Options 

For a full list of JWPlayer configuation, see http://www.longtailvideo.com/support/jw-player/.

//Primary Configuration  
$filepath = File destination for the video, if embedding only a single file and format  
$streampath = Stream destination. Will be combined with $filepath to produce the source video  
$image = Preview image for a single video  
$title = Title of the video  
$div = (default: 'media') The div id for the video. Make sure this is unique for each player on a page.  
	
//Layout Configuration  
$controls = (default: true) Whether to display player controls  
$width = Width of the player  
$height = Height of the player  
$skin = Path to a skin file for this player  
$stretching = (default: 'uniform') Options are: none, exactfit, uniform, fill  
	
//Playback Configuration  
$autostart = (default: 'false') Whether to start the video automatically  
$fallback = (default: 'true') Whether to provide a download link if HTML5 and Flash not supported  
$primary = (default: 'html5') The primary video player, either 'html5' or 'flash'  
$mute = (default: 'false') Whether to remove audio  
$repeat = (default: 'false') Whether to repeat the video after completition  
	
//Advanced Configuration  
$plugins = (Array) Optional plugins provided. See www.longtailvideo.com  
$playlist = (Array) Playlist options. See example above.  
$listbar = (Array) Playlist bar options. See http://www.longtailvideo.com/support/jw-player/28842/working-with-playlists/.
$rtmp = (Array) Streaming options. See http://www.longtailvideo.com/support/jw-player/28854/using-rtmp-streaming  
$captions (Array) Caption options. See http://www.longtailvideo.com/support/jw-player/28845/adding-video-captions  
	
$logo = (Array) Configure your watermark. (Licensed versions only)  
$ga = (Array) Google Analytics settings.  
$key = Key for JW Ads  