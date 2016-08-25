<?php
if ( !function_exists('getYoutubeVideoInfoContent') ) {
	/**
	 * @param $video_id
	 * @return string
	 */
	function getYoutubeVideoInfoContent($video_id)
	{
		$options = array(
			CURLOPT_RETURNTRANSFER => true,   // return web page
			CURLOPT_HEADER         => false,  // don't return headers
			CURLOPT_FOLLOWLOCATION => true,   // follow redirects
			CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
			CURLOPT_ENCODING       => "",     // handle compressed
			CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
			CURLOPT_TIMEOUT        => 120,    // time-out on response
			CURLOPT_SSL_VERIFYPEER => false
		);

		$ch = curl_init(
			"https://www.googleapis.com/youtube/v3/videos?id={$video_id}&key=" . YOUTUBE_CLIENT_KEY . "&part=snippet,contentDetails,statistics,status"
		);

		curl_setopt_array($ch, $options);

		$content  = curl_exec($ch);

		curl_close($ch);

		return $content;
	}
}
?>