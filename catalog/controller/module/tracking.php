<?php  
class ControllerModuleTracking extends Controller {
	protected function index($setting) {
		$this->language->load('module/tracking');
		
		$this->document->addScript('catalog/view/javascript/easyslider/1.7/js/easySlider1.7.js');
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/easyslider.1.7.css');
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/tracking.css');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_orderdate'] = $this->language->get('text_orderdate');
		$this->data['text_orderstatus'] = $this->language->get('text_orderstatus');
		$this->data['text_totalorder'] = $this->language->get('text_totalorder');
		$this->data['text_todayorder'] = $this->language->get('text_todayorder');
		
							
		$this->load->model('tracking/board');
		$this->load->model('catalog/product');
		
		$this->data['orders'] = array();
					
		$orders = $this->model_tracking_board->getOrders($setting);
		
		foreach ($orders as $order) {
			$tracking_info = $this->model_tracking_board->getTracking($order['order_id']);
			
			$this->data['orders'][] = array(
				'order_id' 		=> $order['order_id'],
				'firstname' 	=> $order['firstname'],
				'lastname' 		=> $order['lastname'],
				'total' 		=> $order['total'],
				// 'reward' 		=> $order['reward'],
				'status'		=> $order['status_name'],
				'currency' 		=> $order['currency_code'],
				'date_added' 	=> date('d/m/Y', strtotime($order['date_added'])),
				'ip'			=> $order['ip'],
				'href'        => $this->url->link('tracking/board', '')
			);
		}
		
		$this->data['total_order'] = number_format($this->model_tracking_board->getTotalOrder(), 0);
		$this->data['today_order'] = number_format($this->model_tracking_board->getTodayOrder(), 0);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/tracking.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/tracking.tpl';
		} else {
			$this->template = 'default/template/module/tracking.tpl';
		}
		
		$this->render();
  	}
}
?>