<?php
/**
*
*/
class ModelVideoChannel extends Model {


	private $_table = 'oc_videos';
	private $_groupsTable = 'oc_videos_groups';
	private $_groupsAssocTable = 'co_videos_groups_assoc';


	public function createGroup(array $param = array()) {
		$name = isset($param['name']) ? strval($param['name']) : NULL;
		$description = isset($param['description']) ? strval($param['description']) : NULL;

		$query = "INSERT INTO " . $this->_groupsTable . "(`name`, `description`) VALUES (";
		$query .= is_null($name) ? "NULL, " : $this->db->escape($name) . ", ";
		$query .= is_null($description) ? "NULL, " : $this->db->escape($description) . ")";

		$this->db->query($query);

		return $this->db->getLastId();
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


	public function setFeatured(int $videoId, $featured = TRUE) {

	}


	public function groupVideoAssoc(int $videoId, int $groupId) {

	}


	public function groupVideoUnAssoc(int $videoId, int $groupId) {

	}



	public function setVideoStatus(int $videoId, $videoStatus = 'new') {

	}
}
?>