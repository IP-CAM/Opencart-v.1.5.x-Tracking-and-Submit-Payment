<?php 
class ControllerTrackingBoard extends Controller {  
	private $error = array();
	
	public function index() {
		$this->language->load('tracking/board');
				
		$this->load->model('tracking/board');
		
		//$this->load->model('catalog/product');
		
		$this->load->model('tool/image'); 
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
							
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
					
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			
		$orders = $this->model_tracking_board->getTotalOrder();
	
		if ($orders) {
	  		//$this->document->setTitle($order_info['name']);
			//$this->document->setDescription($order_info['meta_description']);
			//$this->document->setKeywords($order_info['meta_keyword']);
			
			$this->data['heading_title'] = $this->language->get('heading_title');
			
			$this->data['text_description'] = $this->language->get('text_description');
			$this->data['text_empty'] = $this->language->get('text_empty');			
			
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');
			
			$this->data['text_order_date'] = $this->language->get('text_order_date');
			$this->data['text_tracking_no'] = $this->language->get('text_tracking_no');
			$this->data['text_parcel_type'] = $this->language->get('text_parcel_type');
			$this->data['text_order_status'] = $this->language->get('text_order_status');
			$this->data['text_shipped_date'] = $this->language->get('text_shipped_date');
			$this->data['text_deliveried_date'] = $this->language->get('text_deliveried_date');
			$this->data['text_tracking_link'] = $this->language->get('text_tracking_link');
			
			$this->data['button_continue'] = $this->language->get('button_continue');
					
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$this->data['orders'] = array();
			
			$data = array(
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
					
			$order_total = $this->model_tracking_board->getTotalTrackingOrder($data); 
			
			$results = $this->model_tracking_board->getTrackingOrders($data);
			
			$this->data['action'] = $this->url->link('account/order/info');
			
			foreach ($results as $result) {
				$this->data['orders'][] = array(
					'order_id'  	=> $result['order_id'],
					'firstname'       	=> $result['firstname'],
					'lastname'        	=> $result['lastname'],
					'status'		=> $result['status'],
					'date_added'	=> $result['date_added'],
					'total'			=> number_format($result['total'], 2),
					'url'			=> $result['url'],
					'parcel_type'	=> $result['parcel_type'],
					'tracking_no'	=> $result['tracking_no'],
					'description'	=> substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 300) . '..',
					'shipped_date'	=> isset($result['shipped_date'])? date('d/m/Y', strtotime($result['shipped_date'])) : NULL,
					'deliveried_date'	=> isset($result['deliveried_date'])? date('d/m/Y', strtotime($result['deliveried_date'])) : NULL,
					'href'        => $this->url->link('account/order/info', 'order_id=' . $result['order_id'])
				);
			}
			
			$url = '';
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
							
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('tracking/board', 'sort=p.sort_order&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('tracking/board', 'sort=pd.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('tracking/board', 'sort=pd.name&order=DESC' . $url)
			);

			
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('tracking/board', $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);
						
			$this->data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('tracking/board', $url . '&limit=25')
			);
			
			$this->data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('tracking/board', $url . '&limit=50')
			);

			$this->data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('tracking/board', $url . '&limit=75')
			);
			
			$this->data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('tracking/board', $url . '&limit=100')
			);
						
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
					
			$pagination = new Pagination();
			$pagination->total = $order_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('tracking/board', $url . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();
		
			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;
		
			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/tracking/board.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/tracking/board.tpl';
			} else {
				$this->template = 'default/template/tracking/board.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
				
			$this->response->setOutput($this->render());										
    	} else {
			$url = '';
			
			
									
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('tracking/board', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
					
			$this->response->setOutput($this->render());
		}
  	}
	
	public function payment() {
		$this->language->load('tracking/payment');

		$this->load->model('tracking/board');

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_tracking_board->addSubmitPayment($this->request->post);
	  		
			$this->sendmail();
			
			$this->redirect($this->url->link('tracking/board/success', '', 'SSL'));
    	} 
				
		$this->document->setTitle($this->language->get('heading_title'));
		
      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	); 
		
      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => $this->language->get('text_tracking'),
			'href'      => $this->url->link('tracking/board', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tracking/board/payment', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['entry_order_id'] = $this->language->get('entry_order_id');	
		$this->data['entry_date_ordered'] = $this->language->get('entry_date_ordered');	    	
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['text_additional'] = $this->language->get('text_additional');
		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_user'] = $this->language->get('text_user');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_transfer_method'] = $this->language->get('text_transfer_method');
		$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');
		
		$this->data['text_deposit'] = $this->language->get('text_deposit');
		$this->data['text_counter_service'] = $this->language->get('text_counter_service');
		$this->data['text_internet'] = $this->language->get('text_internet');
		$this->data['text_atm'] = $this->language->get('text_atm');
		
		$this->data['entry_bank'] = $this->language->get('entry_bank');
		$this->data['entry_payment_date'] = $this->language->get('entry_payment_date');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_slip_no'] = $this->language->get('entry_slip_no');
		$this->data['entry_payment'] = $this->language->get('entry_payment');
		
		$this->data['button_back'] = $this->language->get('button_back');
		$this->data['button_submit'] = $this->language->get('button_submit');
		
		    
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['order_id'])) {
			$this->data['error_order_id'] = $this->error['order_id'];
		} else {
			$this->data['error_order_id'] = '';
		}
		
		if (isset($this->error['order_verify'])) {
			$this->data['error_order_verify'] = $this->error['order_verify'];
		} else {
			$this->data['error_order_verify'] = '';
		}
				
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}	
			
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
				
		if (isset($this->error['bank'])) {
			$this->data['error_bank'] = $this->error['bank'];
		} else {
			$this->data['error_bank'] = '';
		}
		
		if (isset($this->error['total'])) {
			$this->data['error_total'] = $this->error['total'];
		} else {
			$this->data['error_total'] = '';
		}
		
		if (isset($this->error['payment'])) {
			$this->data['error_payment'] = $this->error['payment'];
		} else {
			$this->data['error_payment'] = '';
		}
		
		if (isset($this->error['slip'])) {
			$this->data['error_slip'] = $this->error['slip'];
		} else {
			$this->data['error_slip'] = '';
		}
		
 		if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}	
						
		$this->data['action'] = $this->url->link('tracking/board/payment', '', 'SSL');

    	if (isset($this->request->post['order_id'])) {
      		$this->data['order_id'] = $this->request->post['order_id']; 	
		} else {
      		$this->data['order_id'] = ''; 
    	}
				
    	if (isset($this->request->post['date_ordered'])) {
      		$this->data['date_ordered'] = $this->request->post['date_ordered']; 	
		} else {
      		$this->data['date_ordered'] = '';
    	}
				
		if (isset($this->request->post['name'])) {
    		$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
		}
		
		if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = $this->customer->getEmail();
		}
		
		if (isset($this->request->post['telephone'])) {
    		$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = $this->customer->getTelephone();
		}
		
		if (isset($this->request->post['payment'])) {
      		$this->data['payment'] = $this->request->post['payment']; 	
		} else {
      		$this->data['payment'] = $this->language->get('text_deposit');
    	}
		
		if (isset($this->request->post['bank'])) {
      		$this->data['bank'] = $this->request->post['bank']; 	
		} else {
      		$this->data['bank'] = '';
    	}
		
		if (isset($this->request->post['total'])) {
      		$this->data['total'] = $this->request->post['total']; 	
		} else {
      		$this->data['total'] = '';
    	}
		
		if (isset($this->request->post['payment_date'])) {
      		$this->data['payment_date'] = $this->request->post['payment_date']; 	
		} else {
      		$this->data['payment_date'] = '';
    	}
		
		if (isset($this->request->post['slip_no'])) {
      		$this->data['slip_no'] = $this->request->post['slip_no']; 	
		} else {
      		$this->data['slip_no'] = '';
    	}
		
    	if (isset($this->request->post['comment'])) {
      		$this->data['comment'] = $this->request->post['comment']; 	
		} else {
      		$this->data['comment'] = '';
    	}

		if (isset($this->request->post['captcha'])) {
			$this->data['captcha'] = $this->request->post['captcha'];
		} else {
			$this->data['captcha'] = '';
		}		

		$this->data['back'] = $this->url->link('tracking/board', '', 'SSL');
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/tracking/payment_form.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/tracking/payment_form.tpl';
		} else {
			$this->template = 'default/template/tracking/payment_form.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
				
		$this->response->setOutput($this->render());		
  	}
	
	public function success() {
		$this->language->load('tracking/payment');

		$this->document->setTitle($this->language->get('heading_title')); 
      
	  	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/return', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);	
				
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_message'] = $this->language->get('text_message');

    	$this->data['button_continue'] = $this->language->get('button_continue');
	
    	$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
				
 		$this->response->setOutput($this->render()); 
	}
	
	private function validate() {
		$this->load->model('tracking/board');
		
    	if (!$this->request->post['order_id']) {
      		$this->error['order_id'] = $this->language->get('error_order_id');
    	} else {
			if (!$this->model_tracking_board->checkOrder($this->request->post['order_id'])) {
				$this->error['order_verify'] = $this->language->get('error_order_verify');
			}
		}
		
		if ((strlen(utf8_decode($this->request->post['name'])) < 1) || (strlen(utf8_decode($this->request->post['name'])) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}

    	if ((strlen(utf8_decode($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		
    	if ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}
		
		if ((strlen(utf8_decode($this->request->post['bank'])) < 3) || (strlen(utf8_decode($this->request->post['bank'])) > 32)) {
      		$this->error['bank'] = $this->language->get('error_bank');
    	}		
		
		if ((strlen(utf8_decode($this->request->post['total'])) < 1) || (strlen(utf8_decode($this->request->post['total'])) > 32)) {
      		$this->error['total'] = $this->language->get('error_total');
    	}
		
		if ((strlen(utf8_decode($this->request->post['payment_date'])) < 3) || (strlen(utf8_decode($this->request->post['payment_date'])) > 32)) {
      		$this->error['payment'] = $this->language->get('error_payment');
    	}
		
		if ((strlen(utf8_decode($this->request->post['slip_no'])) < 3) || (strlen(utf8_decode($this->request->post['slip_no'])) > 32)) {
      		$this->error['slip'] = $this->language->get('error_slip');
    	}
		
    	if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
      		$this->error['captcha'] = $this->language->get('error_captcha');
    	}

		if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
	private function sendmail() {
		$order_id = $this->request->post['order_id'];
		$order_date = $this->request->post['date_ordered'];
		$name = $this->request->post['name'];
		$email = $this->request->post['email'];
		$tel = $this->request->post['telephone'];
		$bank = $this->request->post['bank'];
		$payment_date = $this->request->post['payment_date'];
		$total = $this->request->post['total'];
		$slipno = $this->request->post['slip_no'];
		$payment = $this->request->post['payment'];
		
		$url = HTTPS_SERVER . 'admin/index.php?route=report/payment_transfer';
		
		$message = sprintf($this->language->get('text_welcome'), $name) . "\n\n";
		$message .= sprintf($this->language->get('text_order_id'), $order_id) . "\n";
		$message .= sprintf($this->language->get('text_order_date'), $order_date) . "\n\n";
		$message .= sprintf($this->language->get('text_name'), $name) . "\n";
		$message .= sprintf($this->language->get('text_email'), $email) . "\n";
		$message .= sprintf($this->language->get('text_tel'), $tel) . "\n\n";
		$message .= sprintf($this->language->get('text_bank'), $bank) . "\n";
		$message .= sprintf($this->language->get('text_paymentdate'), $payment_date) . "\n";
		$message .= sprintf($this->language->get('text_total'), $total) . "\n";
		$message .= sprintf($this->language->get('text_slipno'), $slipno) . "\n";
		$message .= sprintf($this->language->get('text_payment'), $payment) . "\n";
		$message .= $this->language->get('text_remark') . "\n" . $this->request->post['comment'] . "\n\n";
		$message .= $this->language->get('text_link') . "\n";
		$message .= $url . "\n\n";
		$message .= $this->language->get('text_thank') . "\n\n";
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo($this->config->get('config_email'));
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($name);
		$mail->setSubject(sprintf($this->language->get('email_subject'), $this->request->post['name']));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
	}
}
?>