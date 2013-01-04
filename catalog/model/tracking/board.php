<?php
class ModelTrackingBoard extends Model {
	public function getTracking($order_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "order_tracking t WHERE t.order_id = '" . (int)$order_id . "'");
		
		return $query->row;
	}
	
	public function addSubmitPayment($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order_payment` SET order_id = '" . $this->db->escape($data['order_id']) . "', order_date = '" . $this->db->escape($data['date_ordered']) . "', name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', bank = '" . $this->db->escape($data['bank']) . "', payment_date = '" . $this->db->escape($data['payment_date']) . "', total = '" . (int)$data['total'] . "', slip_no = '" . $this->db->escape($data['slip_no']) . "', payment = '" . $this->db->escape($data['payment']) . "', remark = '" . $this->db->escape($data['comment']) . "', date_added = NOW() , date_modified = NOW()");
	}
	
	public function checkOrder($order_id) {
		$query = $this->db->query("SELECT COUNT(order_id)  AS total FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "' AND o.order_id NOT IN (SELECT p.order_id FROM order_payment p)");
		
		$order_checked = false;
		
		if ($query->row['total'] > 0) {
			$order_checked = true;
		} else {
			$order_checked = false;
		}
		
		return $order_checked;
	}
	
	public function getOrders($setting) {
		$sql = "SELECT *, s.name AS status_name FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_status s ON (o.order_status_id=s.order_status_id) ";
		
		if($setting['order']=='1'){
			$sql .= "WHERE o.order_status_id <> 0 ORDER BY o.firstname ASC ";
		}else if($setting['order']=='2'){
			$sql .= "WHERE o.order_status_id <> 0 ORDER BY o.date_added DESC ";
		}else if($setting['order']=='3'){
			$sql .= "WHERE o.order_status_id <> 0 ORDER BY o.date_modified DESC ";
		}else if($setting['order']=='4'){
			$sql .= "WHERE o.order_status_id = 5 ORDER BY o.date_modified DESC ";
		}else if($setting['order']=='5'){
			$sql .= "WHERE o.order_status_id = 1 ORDER BY o.date_modified DESC ";
		}
		
		$sql .= 'LIMIT ' . $setting['limit'];
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getTotalTrackingOrder($data = array()) {
		$sql = "SELECT COUNT(*) AS orders FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_tracking t ON (o.order_id=t.order_id) WHERE o.order_status_id <> 0 AND t.status = 1";
		
		$sort_data = array(
			'o.firstname',
			'o.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'o.firstname') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY o.date_added";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['orders'];
	}
	
	public function getTrackingOrders($data = array()) {
		//$cache = md5(http_build_query($data));
		
		$sql = "SELECT *, o.date_added AS order_date, s.name AS status_name FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_status s ON (o.order_status_id=s.order_status_id) LEFT JOIN " . DB_PREFIX . "order_tracking t ON (o.order_id=t.order_id) WHERE t.status = 1 AND s.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
			
		$sort_data = array(
			'o.firstname',
			'o.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'o.firstname') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY o.date_added";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$order_data = array();
				
		$query = $this->db->query($sql);
	
		foreach ($query->rows as $result) {
			$order_data[] = array(
				'order_id' 	=> $result['order_id'],
				'firstname' => $result['firstname'],
				'lastname' 	=> $result['lastname'],
				'status' 	=> $result['status_name'],
				'date_added'	=> $result['order_date'],
				'total'		=> $result['total'],
				'parcel_type'	=> $result['parcel_type'],
				'tracking_no'	=> $result['tracking_no'],
				'url'			=> $result['url'],
				'description'	=> $result['description'],
				'shipped_date'	=> ($result['shipped_date']=='0000-00-00 00:00:00')? NULL : $result['shipped_date'],
				'deliveried_date'	=> ($result['deliveried_date']=='0000-00-00 00:00:00')? NULL : $result['deliveried_date']
			);
		}
			
		return $order_data;
	}
	
	public function getTotalOrder() {
		$query = $this->db->query("SELECT COUNT(*) AS orders FROM `" . DB_PREFIX . "order` WHERE order_status_id <> 0");
		
		return $query->row['orders'];
	}
	
	public function getTodayOrder() {
		$query = $this->db->query("SELECT COUNT(*) AS orders FROM `" . DB_PREFIX . "order` WHERE DATE_FORMAT(date_added,'%Y-%m-%d') = CURDATE() AND order_status_id <> 0");
		
		return $query->row['orders'];
	}
}
?>