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



if ( !function_exists('downloadFromYoutube') ) {
	/**
	 * @param string $video_id
	 * @param string $youtube_id
	 * @param string $video_type
	 * @return bool|mixed
	 */
	function downloadFromYoutube($video_id = '', $youtube_id = '', $video_type = 'video/mp4')
	{
		$dataToSend = array();
		$dataToSend['video_id'] = $video_id;
		$dataToSend['youtube_id'] = $youtube_id;
		$dataToSend['video_type'] = $video_type;

		$temp = tmpfile();
		fwrite($temp, json_encode($dataToSend));
		fseek($temp, 0);

		// generate request for user api service
		$request = curl_init();

		curl_setopt_array($request, array(
			CURLOPT_URL => $api_url . $api_video_path,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_PUT => true,
			CURLOPT_BINARYTRANSFER => true,
			CURLOPT_UPLOAD => true,
			CURLOPT_INFILE => $temp,
			CURLOPT_INFILESIZE, strlen(json_encode($dataToSend)),
		));

		$response = curl_exec($request);
		fclose($temp);

		if ( curl_getinfo($request, CURLINFO_HTTP_CODE) === 200 ) {

			$json = json_decode($response, true);
			curl_close($request);

			if ( $json == null ) {
				return false;
			}

			if ( $json['status'] != true ) {
				return false;
			}

		} else {
			curl_close($request);
			return false;
		}

		return $json;
	}
}
?>