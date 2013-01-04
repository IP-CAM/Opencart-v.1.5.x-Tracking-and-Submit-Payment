<?php
class ControllerReportPaymentTransfer extends Controller {
	public function index() {     
		$this->load->language('report/payment_transfer');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}
		
		if (isset($this->request->get['filter_payment_transfer'])) {
			$filter_payment_transfer = $this->request->get['filter_payment_transfer'];
		} else {
			$filter_payment_transfer = 0;
		}	
				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_payment_transfer'])) {
			$url .= '&filter_payment_transfer=' . $this->request->get['filter_payment_transfer'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
						
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/payment_transfer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/payment_transfer');
		
		$this->data['payments'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_payment_transfer' => $filter_payment_transfer,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
				
		$payment_total = $this->model_report_payment_transfer->getTotalPayments($data); 
		
		$results = $this->model_report_payment_transfer->getSubmitPayment($data);
		
		foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
						
			$this->data['payments'][] = array(
				'customer'       	=> $result['name'],
				'email'          	=> $result['email'],
				'telephone' 		=> $result['telephone'],
				'payment_method'	=> $result['payment'],
				'payment_date'      => ($result['payment_date']!='0000-00-00 00:00:00')? date('Y-m-d', strtotime($result['payment_date'])) : '-',
				'slip_no'       	=> $result['slip_no'],
				'total'          => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'action'         => $action
			);
		}
		 
 		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_payment'] = $this->language->get('text_all_payment');
		
		$this->data['text_deposit'] = $this->language->get('text_deposit');
		$this->data['text_counter_service'] = $this->language->get('text_counter_service');
		$this->data['text_internet'] = $this->language->get('text_internet');
		$this->data['text_atm'] = $this->language->get('text_atm');
		
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_payment_method'] = $this->language->get('column_payment_method');
		$this->data['column_payment_date'] = $this->language->get('column_payment_date');
		$this->data['column_slip_no'] = $this->language->get('column_slip_no');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_payment_method'] = $this->language->get('entry_payment_method');

		$this->data['button_filter'] = $this->language->get('button_filter');
		
		$this->data['token'] = $this->session->data['token'];
		
		
			
		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_payment_transfer'])) {
			$url .= '&filter_payment_transfer=' . $this->request->get['filter_payment_transfer'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $payment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/payment_transfer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_payment_transfer'] = $filter_payment_transfer;
				 
		$this->template = 'report/payment_transfer.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
}
?>