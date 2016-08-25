<?php
if ( !function_exists('getYoutubeVideoInfoUrl') ) {
	/**
	 * @param $video_id
	 * @return string
	 */
	function getYoutubeVideoInfoUrl($video_id)
	{
		return "http://www.youtube.com/get_video_info?&video_id={$video_id}&asv=3&el=detailpage&hl=en_US";
	}
}


if ( !function_exists('getYoutubeVideoByType') ) {
	/**
	 * @param array $stream_data
	 * @param string $video_type
	 * @return bool
	 */
	function getYoutubeVideoByType(array $stream_data = array(), $video_type = '')
	{
		if ( count($stream_data) == 0 OR $video_type == '' ) {
			return FALSE;
		}

		// search for video with specified type
		foreach ( $stream_data as $item ) {
			parse_str($item, $itemData);
			$types = explode(';', $itemData['type']);
			if ( $types[0] == $video_type ) return $itemData;
		}

		return FALSE;
	}
}

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


if ( !function_exists('youtube_id_from_url') ) {
	/**
	 * get youtube video ID from URL
	 *
	 * @param string $url
	 * @return string Youtube video id or FALSE if none found.
	 */
	function youtube_id_from_url($url)
	{
		$pattern =
				'%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
		$result = preg_match($pattern, $url, $matches);
		if ( false !== $result ) {
			return $matches[1];
		}
		return false;
	}
}


if ( !function_exists('downloadFromYoutube') ) {
	/**
	 * @param string $video_id
	 * @param string $youtube_id
	 * @param string $video_type
	 * @return bool
	 */
	function downloadFromYoutube($video_id = '', $youtube_id = '', $video_type = 'video/mp4')
	{
		$CI = get_instance();
		$CI->load->helper('eventlog');
		$CI->config->load('main');

		if ( $video_id == '' ) {
			return FALSE;
		}

		if ( $youtube_id == '' ) {
			return FALSE;
		}

		// get youtube video info
		if ( FALSE === $video_info = file_get_contents(getYoutubeVideoInfoUrl($youtube_id)) ) {
			return FALSE;
		}

		parse_str($video_info, $parsed_video_info);

		if ( strtolower($parsed_video_info['status']) == 'fail' ) {
			return FALSE;
		}

		$stream_data = explode(',', $parsed_video_info['url_encoded_fmt_stream_map']);

		if ( count($stream_data) == 0 ) {
			return FALSE;
		}

		// get youtube video info
		if ( FALSE === $video_stream_item = getYoutubeVideoByType($stream_data, $video_type) ) {
			return FALSE;
		}

		$mimeTypes = explode('/', $video_type);
		$extension = $mimeTypes[1];
		$final_upload_path = DIR_VIDEO . $video_id . '.' . $extension;

		if ( !is_dir($final_upload_path) ) {
			if ( FALSE === writeVideoFromYoutube(
					$final_upload_path,
					$video_stream_item['url']
				)
			) {
				return FALSE;
			} else {
				return TRUE;
			}
		}

		return FALSE;
	}
}



?>