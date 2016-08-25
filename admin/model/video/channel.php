<?php
/**
*
*/
class ModelVideoChannel extends Model {


	private $_table = 'oc_videos';
	private $_groupsTable = 'oc_videos_groups';
	private $_groupsAssocTable = 'co_videos_groups_assoc';


	public function createGroup(array $param = array()) {

	}



	public function updateGroup(array $param = array()) {

	}


	public function getGroup(int $groupId) {

	}



	public function getAllGroups() {

	}


	public function deleteGroup(int $groupId) {

	}


	public function createVideo(array $param = array()) {

	}



	public function updateVideo(array $param = array()) {

	}



	public function getVideo(int $videoId) {

	}



	public function getAllVideos(int $groupId = null) {

	}


	public function geleteVideo(int $videoId) {

	}


	public function setFeatured(int $videoId, bool $featured = TRUE) {

	}


	public function groupVideoAssoc(int $videoId, int $groupId) {

	}


	public function groupVideoUnAssoc(int $videoId, int $groupId) {

	}



	public function setVideoStatus(int $videoId, string $videoStatus = 'new') {

	}
}
?>