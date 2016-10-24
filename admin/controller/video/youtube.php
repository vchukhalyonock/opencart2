<?php
/**
*
*/
class ControllerVideoYoutube extends Controller {
	
	public function download() {
		$this->load->model('video/channel');

		$allVideos = $this->model_video_channel->getAllVideos(null, null, 'download');
		if(count($allVideos['result']) == 0)
			die;

		foreach ($allVideos['result'] as $video) {
			$youtubeID = youtube_id_from_url($video['customerLink']);

			if ($youtubeID !== false) {
				$result = downloadFromYoutube($video['id'], $youtubeID);

				if($result) {
					$this->model_video_channel->updateVideo(
					array(
						'id' => $video['id'],
						'videoStatus' => 'downloaded'
						)
					);
				}
				else {
					$this->model_video_channel->updateVideo(
					array(
						'id' => $video['id'],
						'videoStatus' => 'err_download'
						)
					);
				}
			}
			else {
				$this->model_video_channel->updateVideo(
					array(
						'id' => $video['id'],
						'videoStatus' => 'err_download'
						)
					);
			}
		}
	}


	public function upload() {
		$this->load->model('video/channel');

		$allVideos = $this->model_video_channel->getAllVideos(null, null, 'upload');
		if(count($allVideos['result']) == 0)
			die;

		foreach ($allVideos['result'] as $video) {
			$name = !empty($video['name']) ? $video['name'] : 'Video #' . $video['id'];
			$description = !empty($video['description']) ? $video['description'] : 'Video #' . $video['id'];

			$result = uploadToYoutube($video['id'], '22', $name, strip_tags($description));

			if($result) {
				$this->model_video_channel->updateVideo(
				array(
					'id' => $video['id'],
					'videoStatus' => 'not_ready',
					'channelLink' => $result->getId()
					)
				);
			}
			else {
				$this->model_video_channel->updateVideo(
				array(
					'id' => $video['id'],
					'videoStatus' => 'err_upload'
					)
				);
			}
		}
	}
}
?>