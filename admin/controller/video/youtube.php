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

	}
}
?>