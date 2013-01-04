<?php
class ModelSaleTracking extends Model {
	public function getTracking($order_id) {
		$tracking_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_tracking` WHERE order_id = '" . (int)$order_id . "'");

		if ($tracking_query->num_rows) {
			$tracking_data = array(
				'order_id'          => $tracking_query->row['order_id'],
				'parcel_type'       => $tracking_query->row['parcel_type'],
				'url'              	=> $tracking_query->row['url'],
				'status'            => $tracking_query->row['status'],
				'tracking_no'       => $tracking_query->row['tracking_no'],
				'description'       => $tracking_query->row['description'],
				'shipped_date'      => $tracking_query->row['shipped_date'],
				'deliveried_date'   => $tracking_query->row['deliveried_date']
			);

			return $tracking_data;
		} else {
			return FALSE;
		}
	}
	
	public function getSubmitPayment($order_id) {
		$payment_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_payment` WHERE order_id = '" . (int)$order_id . "'");
		
		if ($payment_query->num_rows) {
			$payment_data = array(
				'order_id'          => $payment_query->row['order_id'],
				'order_date'        => $payment_query->row['order_date'],
				'name'       		=> $payment_query->row['name'],
				'email'             => $payment_query->row['email'],
				'telephone'         => $payment_query->row['telephone'],
				'bank'       		=> $payment_query->row['bank'],
				'payment_date'      => $payment_query->row['payment_date'],
				'total'      		=> $payment_query->row['total'],
				'slip_no'   		=> $payment_query->row['slip_no'],
				'payment_method'    => $payment_query->row['payment'],
				'remark'            => $payment_query->row['remark']
			);

			return $payment_data;
		} else {
			return FALSE;
		}
	}
	
	public function updateTransferPayment($order_id, $data) {
		$payment_query = $this->db->query("UPDATE `" . DB_PREFIX . "order_payment` SET " .
			"name = '" . $this->db->escape($data['name']) . 
			"', email = '" . $this->db->escape($data['email']) .
			"', telephone = '" . $this->db->escape($data['telephone']) . 
			"', bank = '" . $this->db->escape($data['bank']) .
			"', payment_date = '" . $this->db->escape($data['payment_date']) . 
			//"', order_date = '" . $this->db->escape($data['order_date']) . 
			"', total = '" . $this->db->escape($data['total']) .
			"', slip_no = '" . $this->db->escape($data['slip_no']) .
			"', payment = '" . $this->db->escape($data['payment_method']) . 
			"', remark = '" . $this->db->escape($data['remark']) .
			"', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function updateTracking($order_id, $data) {
		$tracking_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_tracking` WHERE order_id = '" . (int)$order_id . "'");
		
		if ($tracking_query->num_rows) {
			$this->db->query("UPDATE `" . DB_PREFIX . "order_tracking` SET parcel_type = '" . $this->db->escape($data['parcel_type']) . 
			"', tracking_no = '" . $this->db->escape($data['tracking_no']) .
			"', url = '" . $this->db->escape($data['tracking_url']) . 
			"', status = '" . (isset($data['tracking_notify']) ? (int)$data['tracking_notify'] : 0) .
			"', description = '" . $this->db->escape($data['parcel_description']) . 
			"', shipped_date = '" . $this->db->escape($data['shipped_date']) . 
			"', deliveried_date = '" . $this->db->escape($data['deliveried_date']) . 
			"', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_tracking SET order_id = '" . (int)$order_id . 
			"', parcel_type = '" . $this->db->escape($data['parcel_type']) . 
			"', url = '" . $this->db->escape($data['tracking_url']) . 
			"', status = '" . (isset($data['tracking_notify']) ? (int)$data['tracking_notify'] : 0) .
			"', tracking_no = '" . $this->db->escape($data['tracking_no']) . 
			"', description = '" . $this->db->escape($data['parcel_description']) . 
			"', shipped_date = '" . $this->db->escape($data['shipped_date']) . 
			"', deliveried_date = '" . $this->db->escape($data['deliveried_date']) . 
			"', date_added = NOW(), date_modified = NOW() ");
		}	
		
		
	}	
}
?>