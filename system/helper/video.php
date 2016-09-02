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


if ( !function_exists('writeVideoFromYoutube') ) {
	/**
	 * @param $path
	 * @param $data
	 * @param string $mode
	 * @return bool
	 */
	function writeVideoFromYoutube($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE)
	{
		if ( !$fp = @fopen($path, $mode) ) {
			return FALSE;
		}

		flock($fp, LOCK_EX);
		$handle = fopen($data, "r");
		if ( $handle ) {
			flock($handle, LOCK_EX);
			while ( !feof($handle) ) {
				$buffer = fgets($handle, 4096);
				file_put_contents($path, $buffer, FILE_APPEND);
			}
			flock($handle, LOCK_UN);
			fclose($handle);
		} else {
			return FALSE;
		}
		flock($fp, LOCK_UN);
		fclose($fp);

		return TRUE;
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



if ( !function_exists('uploadToYoutube') ) {
	/**
	 * @param string $video_id
	 * @param string $video_category
	 * @param string $video_title
	 * @param string $video_desc
	 * @param array $video_tags
	 * @return bool
	 */
	function uploadToYoutube($video_id = '', $video_category = '22', $video_title = '', $video_desc = '', array $video_tags = array())
	{
		$scope = array(
			'https://www.googleapis.com/auth/youtube.upload',
			'https://www.googleapis.com/auth/youtube',
			'https://www.googleapis.com/auth/youtubepartner',
			'https://www.googleapis.com/auth/youtube.force-ssl'
			);


		require_once DIR_THIRD_PARTY . 'Google/autoload.php';

		$key = file_get_contents(YOUTUBE_TOKEN_FILE_PATH);


		//REWRITE THIS
		// get file name by video id
		$dirMap = scandir(DIR_VIDEO);
		foreach ( $dirMap as $file ) {
			if ( preg_match("/^" . $video_id . "\.[a-zA-Z0-9]{1,4}$/", $file) ) {
				$fileName = $file;
				break;
			}
		}

		// construct full path for video
		$final_video_path = DIR_VIDEO . $fileName;

		oc_cli_output($final_video_path);

		try {
			// Client init
			$client = new Google_Client();
			$client->setApplicationName(YOUTUBE_APPLICATION_NAME);
			$client->setClientId(YOUTUBE_CLIENT_ID);
			$client->setAccessType('offline');
			$client->setAccessToken($key);
			$client->setScopes($scope);
			$client->setClientSecret(YOUTUBE_CLIENT_SECRET);

			if ( $client->getAccessToken() ) {

				/**
				 * Check to see if our access token has expired. If so, get a new one and save it to file for future use.
				 */
				if ( $client->isAccessTokenExpired() ) {
					$newToken = json_decode($client->getAccessToken());
					$client->refreshToken($newToken->refresh_token);
					file_put_contents($token_path, $client->getAccessToken());
				}

				$youtube = new Google_Service_YouTube($client);

				// Create a snipet with title, description, tags and category id
				$snippet = new Google_Service_YouTube_VideoSnippet();
				$snippet->setTitle($video_title);
				$snippet->setDescription($video_desc);
				$snippet->setCategoryId($video_category);
				$snippet->setTags($video_tags);

				// Create a video status with privacy status. Options are "public", "private" and "unlisted".
				$status = new Google_Service_YouTube_VideoStatus();
				$status->setPrivacyStatus('public');

				// Create a YouTube video with snippet and status
				$video = new Google_Service_YouTube_Video();
				$video->setSnippet($snippet);
				$video->setStatus($status);

				// Size of each chunk of data in bytes. Setting it higher leads faster upload (less chunks,
				// for reliable connections). Setting it lower leads better recovery (fine-grained chunks)
				$chunkSizeBytes = 1 * 1024 * 1024;

				// Setting the defer flag to true tells the client to return a request which can be called
				// with ->execute(); instead of making the API call immediately.
				$client->setDefer(true);

				// Create a request for the API's videos.insert method to create and upload the video.
				$insertRequest = $youtube->videos->insert("status,snippet", $video);

				// Create a MediaFileUpload object for resumable uploads.
				$media = new Google_Http_MediaFileUpload(
					$client,
					$insertRequest,
					'video/*',
					null,
					true,
					$chunkSizeBytes
				);
				$media->setFileSize(filesize($final_video_path));


				// Read the media file and upload it chunk by chunk.
				$status = false;
				$handle = fopen($final_video_path, "rb");
				while ( !$status && !feof($handle) ) {
					$chunk = fread($handle, $chunkSizeBytes);
					$status = $media->nextChunk($chunk);
				}

				fclose($handle);

				/**
				 * Video has successfully been upload, now lets perform some cleanup functions for this video
				 */
				if ( $status->status['uploadStatus'] == 'uploaded' ) {
					// Actions to perform for a successful upload
					if ( FALSE === unlink($final_video_path) ) {
						return false;
					}
					return $status;
				}

				// If you want to make other calls after the file upload, set setDefer back to false
				$client->setDefer(true);

			} else {
				return FALSE;
			}

		} catch ( Google_Service_Exception $e ) {
			oc_cli_output("Google_Service_Exception");
			return FALSE;
		} catch ( Exception $e ) {
			oc_cli_output("Simple Exception" . $e->getMessage() . "|" . $e->getLine() . "|" . $e->getFile());
			return FALSE;
		}
	}
}


?>