<?php
/**
*
*/
class ModelVideoChannel extends Model {


	private $_table = 'videos';
	private $_groupsTable = 'videos_groups';
	private $_groupsAssocTable = 'videos_groups_assoc';
	private $_customerTable = 'customer';


	public function createGroup(array $param = array()) {
		$name = isset($param['name']) ? strval($param['name']) : NULL;
		$description = isset($param['description']) ? strval($param['description']) : NULL;

		$query = "INSERT INTO " . DB_PREFIX . $this->_groupsTable . "(`name`, `description`) VALUES (";
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

			$query = "UPDATE " . DB_PREFIX . $this->_groupsTable . " SET " . implode(",", $queryArray) . " WHERE `id`=" . $groupId;
			$this->db->query($query);
		}

		return true;
	}


	public function getGroup($groupId) {
		$groupId = intval($groupId);

		$result = $this->db
			->query(
				"SELECT " .
					"`id`,
					`name`,
					`description`
				FROM " . DB_PREFIX . $this->_groupsTable
				. " WHERE `id`=" . $groupId
				. " LIMIT 1"
				);

		return isset($result->row) ? $result->row : false;
	}



	public function getAllGroups($order = 5, $start = 0, $limit = 0) {
		$order = intval($order);
		$start = intval($start);
		$limit = intval($limit);

		$orderDirection = $order & ORDER_DESC ? 'DESC' : 'ASC';
		if($order & ORDER_BY_NAME) {
			$orderField = "`name` ";
		}
		else
			$orderField = "`id` ";

		$query = "SELECT SQL_CALC_FOUND_ROWS "
			. "`id`,
				`name`,
				`description`"
			. "FROM " . DB_PREFIX . $this->_groupsTable
			. " ORDER BY " . $orderField . $orderDirection;

		if($limit > 0)
			$query .= " LIMIT " . $start . ", " . $limit;

		$res = $this->db->query($query);

		$allResult = $this->db->query("SELECT FOUND_ROWS() AS rows");

		$result = array(
			'result' => $res->rows,
			'total' => $allResult->row['rows']
			);

		return $result;
	}


	public function deleteGroups($groupIds) {
		$ids = array();
		if(is_array($groupIds)) {
			foreach ($groupIds as $id)
				$ids[] = intval($id);
		}
		else {
			$ids[] = intval($groupIds);
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . $this->_groupsAssocTable . " WHERE `groupId` IN (" . implode(",", $ids) . ")");
		$this->db->query("DELETE FROM " . DB_PREFIX . $this->_groupsTable . " WHERE `id` IN (" . implode(",", $ids) . ")");

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

		$query = "INSERT INTO " . DB_PREFIX . $this->_table . "(
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

		$query = "UPDATE `" . DB_PREFIX . $this->_table . "` SET " . implode(",", $queryArray) . " WHERE `id`=" . intval($param['id']);

		$this->db->query($query);

		return true;
	}



	public function getVideo($videoId) {
		$videoId = intval($videoId);

		$result = $this->db->query(
			"SELECT "
				. DB_PREFIX . $this->_table . ".id AS id,"
				. DB_PREFIX . $this->_table . ".name AS name,"
				. DB_PREFIX . $this->_table . ".description AS description,"
				. DB_PREFIX . $this->_table . ".videoStatus AS videoStatus,"
				. DB_PREFIX . $this->_table . ".featured AS featured,"
				. DB_PREFIX . $this->_table . ".customerLink AS customerLink,"
				. DB_PREFIX . $this->_table . ".channelLink AS channelLink,"
				. DB_PREFIX . $this->_table . ".thumbnailId AS thumbnailId,"
				. DB_PREFIX . $this->_table . ".customerId AS customerId,"
				. DB_PREFIX . $this->_customerTable . ".email AS email "
			. "FROM " . DB_PREFIX . $this->_table
			. " LEFT JOIN "
				. DB_PREFIX . $this->_customerTable
				. " ON " . DB_PREFIX . $this->_customerTable . ".customer_id = " . DB_PREFIX . $this->_table . ".customerId "
			. "WHERE " . DB_PREFIX . $this->_table . ".id=" . $videoId
			. " LIMIT 1"
			);

		return isset($result->row) ? $result->row : false;
	}



	public function getAllVideos(
			$groupId = null,
			$search = null,
			$select = null,
			$order = 5,
			$start = 0,
			$limit = 0) {
		$groupId = is_null($groupId) ? null : intval($groupId);
		$search = is_null($search) ? null : strval($search);
		$select = is_null($select) ? null : strval($select);
		$order = intval($order);
		$start = intval($start);
		$limit = intval($limit);

		$whereArray = array();

		$orderDirection = $order & ORDER_DESC ? "DESC" : "ASC";
		if($order & ORDER_BY_NAME) {
			$orderField = "name ";
		}
		elseif($order & ORDER_BY_EMAIL) {
			$orderField = "email ";
		}
		elseif($order & ORDER_BY_STATUS) {
			$orderField = "videoStatus ";
		}
		elseif($order & ORDER_BY_FEATURED) {
			$orderField = "featured ";
		}
		else
			$orderField = "id ";

		$query = "SELECT SQL_CALC_FOUND_ROWS "
			. DB_PREFIX . $this->_table . ".id AS id,"
			. DB_PREFIX . $this->_table . ".name AS name,"
			. DB_PREFIX . $this->_table . ".description AS description,"
			. DB_PREFIX . $this->_table . ".videoStatus AS videoStatus,"
			. DB_PREFIX . $this->_table . ".featured AS featured,"
			. DB_PREFIX . $this->_table . ".customerLink AS customerLink,"
			. DB_PREFIX . $this->_table . ".channelLink AS channelLink,"
			. DB_PREFIX . $this->_table . ".thumbnailId AS thumbnailId,"
			. DB_PREFIX . $this->_table . ".customerId AS customerId,"
			. DB_PREFIX . $this->_customerTable . ".email AS email "
			. "FROM " . DB_PREFIX . $this->_table
			. " LEFT JOIN "
				. DB_PREFIX . $this->_customerTable
				. " ON " . DB_PREFIX . $this->_customerTable . ".customer_id = " . DB_PREFIX . $this->_table . ".customerId ";

		if(!is_null($groupId)) {
			$query .= " LEFT JOIN " . DB_PREFIX . $this->_groupsAssocTable
				. " ON " . DB_PREFIX . $this->_groupsAssocTable
				. ".videoId = " . DB_PREFIX . $this->_table . ".id ";
		}


		//WHERE part
		if(!is_null($select)) {
			$whereArray[] = DB_PREFIX . $this->_table . ".videoStatus='" . $this->db->escape($select) . "'";
		}

		if(!is_null($groupId)) {
			$whereArray[] = DB_PREFIX . $this->_groupsAssocTable . ".groupId = " . $groupId;
		}

		if(!is_null($search)) {
			$search = "'" . $this->db->escape("%" . $search . "%") . "'";
			$whereArray[] = "("
				. DB_PREFIX . $this->_table . ".name LIKE ({$search}) OR "
				. DB_PREFIX . $this->_table . ".description LIKE ({$search}) OR "
				. DB_PREFIX . $this->_table . ".videoStatus LIKE ({$search}) OR "
				. DB_PREFIX . $this->_customerTable . ".email LIKE ({$search}) )";
		}

		if(count($whereArray) > 0)
			$query .= " WHERE " . implode(" AND ", $whereArray);

		$query .= " ORDER BY " . $orderField . $orderDirection;

		if($limit > 0) {
			$query .= " LIMIT " . $start . ", " . $limit;
		}

		$res = $this->db->query($query);
		$allResult = $this->db->query("SELECT FOUND_ROWS() AS rows");

		$result = array(
			'result' => $res->rows,
			'total' => $allResult->row['rows']
			);

		return $result;
	}


	public function isLinkExists($customerLink, $videoId = null) {
		$customerLink = strval($customerLink);
		$videoId = is_null($videoId) ? null : intval($videoId);

		$query = "SELECT `id` FROM " . DB_PREFIX . $this->_table . " WHERE `customerLink`='" . $this->db->escape($customerLink) . "'";
		if(!is_null($videoId))
			$query .= " AND `id`!=" . $videoId;

		$query .= " LIMIT 1";

		$res = $this->db->query($query);

		return $res->num_rows > 0 ? true : false;
	}


	public function deleteVideos($videoIds) {
		$ids = array();
		if(is_array($videoIds)) {
			foreach ($videoIds as $id)
				$ids[] = intval($id);
		}
		else {
			$ids[] = intval($videoIds);
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . $this->_groupsAssocTable . " WHERE `videoId` IN (" . implode(",", $ids) . ")");
		$this->db->query("DELETE FROM " . DB_PREFIX . $this->_table . " WHERE `id` IN (" . implode(",", $ids) . ")");

		return;
	}


	public function isVideoAssoc($videoId, $groupId) {
		$videoId = intval($videoId);
		$groupId = intval($groupId);
		$res = $this->db->query(
			"SELECT `groupId`, `videoId` FROM " . DB_PREFIX . $this->_groupsAssocTable
				. " WHERE `groupId`=" . $groupId . " AND `videoId`=" .  $videoId . " LIMIT 1");
		return $res->num_rows > 0 ? true : false;
	}


	public function setFeatured($videoId, $featured = TRUE) {
		$videoId = intval($videoId);
		$featured = ($featured) ? 1 : 0;
		$this->db->query("UPDATE " . DB_PREFIX . $this->_table . " SET `featured`=" . $featured . " WHERE `id`=" . $videoId);
		return;
	}


	public function groupVideoAssoc($videoId, $groupId) {
		$videoId = intval($videoId);
		$groupId = intval($groupId);
		if($this->isVideoAssoc($videoId, $groupId) == 1)
			return;

		$this->db->query("INSERT INTO " . DB_PREFIX . $this->_groupsAssocTable . "(`groupId`, `videoId`) VALUES (" . $groupId . ", " . $videoId . ")");
		return;
	}


	public function groupVideoUnAssoc($videoId, $groupId) {
		$videoId = intval($videoId);
		$groupId = intval($groupId);
		$this->db->query("DELETE FROM " . DB_PREFIX . $this->_groupsAssocTable
				. " WHERE `videoId`=" . $videoId . " AND `groupId`=" . $groupId . " LIMIT 1");
		return;
	}
}
?>