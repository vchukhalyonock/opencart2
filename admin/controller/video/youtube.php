<?php
/**
*
*/
class ModelVideoYoutube extends Controller {
	
	public function download() {
		$this->load->model('video/channel');

		$allVideos = $this->model_video_channel->getAllVideos(null, null, 'download');
		if(count($allVideos['result']) == 0)
			die;

		foreach ($allVideos as $video) {
			
		}
	}


	public function upload() {

	}
}
?>