<?php
/**
*
*/
class ModelVideoChannel extends Model {


	private $_table = 'oc_videos';
	private $_groupsTable = 'oc_videos_groups';
	private $_groupsAssocTable = 'co_videos_groups_assoc';
	private $_customerTable = 'customer';


	public function createGroup(array $param = array()) {
		$name = isset($param['name']) ? strval($param['name']) : NULL;
		$description = isset($param['description']) ? strval($param['description']) : NULL;

		$query = "INSERT INTO " . $this->_groupsTable . "(`name`, `description`) VALUES (";
		$query .= is_null($name) ? "NULL, " : "'" . $this->db->escape($name) . "', ";
		$query .= is_null($description) ? "NULL, " : "'" . $this->db->escape($description) . "')";

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
				$queryArray[] = is_null($name) ? "`name`=NULL, " : "`name`='" . $this->db->escape($name) . "'";
			}

			if(array_key_exists('description', $param)) {
				$description = isset($param['description']) ? strval($param['description']) : NULL;
				$queryArray[] = is_null($description) ? "`description`=NULL, " : "`description`='" . $this->db->escape($description) . "'";
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



	public function getAllGroups($order = 5, $start = 0, $limit = 0) {
		$order = intval($order);
		$start = intval($start);
		$limit = intval($limit);

		$orderDirection = $order & ORDER_ASC ? 'ASC' : 'DESC';
		if($order & ORDER_BY_NAME) {
			$orderField = "`name` ";
		}
		else
			$orderField = "`id` ";

		$query = "SELECT SQL_CALC_FOUND ROWS "
			. "`id`,
				`name`
				`description`"
			. "FROM " . $this->_groupsTable
			. " ORDER_BY " . $orderField . $orderDirection;

		if($limit > 0)
			$query .= " LIMIT " . $start . ", " . $limit;

		$res = $this->db->query($query);

		$allResult = $this->db->query("SELECT FOUND_ROWS AS rows");

		$result = array(
			'result' => $res->rows,
			'total' => $allResult->row['rows']
			);

		return $result;
	}


	public function deleteGroup(int $groupId) {
		$this->db->query("DELETE FROM " . $this->_groupsAssocTable . " WHERE `groupId`=" . $groupId);
		$this->db->query("DELETE FROM " . $this->_groupsTable . " WHERE `id`=" . $groupId);

		return;
	}


	public function createVideo(array $param = array()) {
		$queryArray = array();

		$queryArray[] = isset($param['name']) ? "'" . $this->db->escape(strval($param['name'])) . "'" : "NULL";
		$queryArray[] = isset($param['description']) ? "'" . $this->db->escape(strval($param['description'])) . "'" : "NULL";
		$queryArray[] = isset($param['videoStatus']) ? "'" . $this->db->escape(strval($param['videoStatus'])) . "'" : "'new'";
		$queryArray[] = isset($param['featured']) ? intval($param['name']) : 0;
		$queryArray[] = isset($param['customerLink']) ? "'" . $this->db->escape(strval($param['customerLink'])) . "'" : "NULL";
		$queryArray[] = isset($param['channelLink']) ? "'" . $this->db->escape(strval($param['channelLink'])) . "'" : "NULL";
		$queryArray[] = isset($param['thumbnailId']) ? intval($param['thumbnailId']) : "NULL";
		$queryArray[] = isset($param['customerId']) ? intval($param['customerId']) : "NULL";

		$query = "INSERT INTO " . $this->_table . "(
			`name`,
			`description`,
			`videoStatus`,
			`featured`,
			`customerLink`,
			`channelLink`,
			`thumbnailId`,
			`customerId`
			) VALUES (" . implode(",", $queryArray) . ")";

		$this->db->query($query);
		$videoId = $this->db->getLastId();

		return $videoId;
	}



	public function updateVideo(array $param = array()) {
		if(!isset($param['id']))
			return false;

		$queryArray = array();

		if(array_key_exists('name', $param)) {
			$queryArray[] = is_null($param['name']) ? "`name`=NULL" : "`name`='" . $this->db->escape(strval($param['name'])) . "'";
		}

		if(array_key_exists('description', $param)) {
			$queryArray[] = is_null($param['description']) ? "`description`=NULL" : "`description`='"
				. $this->db->escape(strval($param['description'])) . "'";
		}

		if(array_key_exists('videoStatus', $param) && !is_null($param['videoStatus'])) {
			$queryArray[] = "`videoStatus`='" . $this->db->escape(strval($param['videoStatus'])) . "'";
		}

		if(array_key_exists('featured', $param)) {
			$queryArray[] = "`featured`=" . intval($param['featured']);
		}

		if(array_key_exists('customerLink', $param)) {
			$queryArray[] = is_null($param['customerLink']) ? "`customerLink`=NULL" : "`customerLink`='"
				. $this->db->escape(strval($param['customerLink'])) . "'";
		}

		if(array_key_exists('channelLink', $param)) {
			$queryArray[] = is_null($param['channelLink']) ? "`channelLink`=NULL" : "`channelLink`='"
				. $this->db->escape(strval($param['channelLink'])) . "'";
		}

		if(array_key_exists('thumbnailId', $param)) {
			$queryArray[] = is_null($param['thumbnailId']) ? "`thumbnailId`=NULL" : "`thumbnailId`=" . intval($param['thumbnailId']);
		}

		if(array_key_exists('customerId', $param)) {
			$queryArray[] = is_null($param['customerId']) ? "`customerId`=NULL" : "`customerId`=" . intval($param['customerId']);
		}

		$query = "UPDATE `" . $this->_table . "` SET " . implode(",", $queryArray) . " WHERE `id`=" . intval($param['id']);

		return true;
	}



	public function getVideo(int $videoId) {
		$result = $this->db->query(
			"SELECT "
				. $this->_table . ".id AS id,"
				. $this->_table . ".name AS name,"
				. $this->_table . ".description AS description,"
				. $this->_table . ".videoStatus AS videoStatus,"
				. $this->_table . ".featured AS featured,"
				. $this->_table . ".customerLink AS customerLink,"
				. $this->_table . ".channelLink AS channelLink,"
				. $this->_table . ".thumbnailId AS thumbnailId,"
				. $this->_table . ".customerId AS customerId,"
				. DB_PREFIX . $this->_customerTable . ".email AS email "
			. "LEFT JOIN "
				. DB_PREFIX . $this->_customerTable
				. " ON " . DB_PREFIX . $this->_customerTable . ".customer_id = " . $this->_table . ".customerId "
			. "WHERE " . $this->_table . ".id=" . $videoId
			. " LIMIT 1"
			);

		return isset($result->row) ? $result->row : false;
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