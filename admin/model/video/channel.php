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
		if(!isset($param['id']))
			return false;

		$queryArray = array();

		$groupId = intval($param['groupId']);

		if(array_key_exists('name', $param) || array_key_exists('description', $param)) {
			if(array_key_exists('name', $param)) {
				$name = isset($param['name']) ? strval($param['name']) : NULL;
				$queryArray[] = is_null($name) ? "`name`=NULL, " : "`name`=" . $this->db->escape($name);
			}

			if(array_key_exists('description', $param)) {
				$name = isset($param['description']) ? strval($param['description']) : NULL;
				$queryArray[] = is_null($description) ? "`description`=NULL, " : "`description`=" . $this->db->escape($description);
			}

			$query = "UPDATE " . $this->_groupsTable . " SET " . implode(",", $queryArray) . " WHERE `id`=" . $groupId;
			$this->db->query($query);
		}

		return true;
	}


	public function getGroup(int $groupId) {
		$result = $this->db
			->query(
				"SELECT " .
					"`id`,
					`name`,
					`description`
				FROM " . $this->_groupsTable
				. " WHERE `id`=" . $groupId
				. " LIMIT 1"
				);

		return isset($result->row) ? $result->row : false;
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