<?php
class ControllerExtensionModuleInfinite extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/infinite');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_infinite', $this->request->post);

			if (!isset($this->request->get['apply'])) {
				$this->session->data['success'] = $this->language->get('text_success');
			}

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/infinite', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/infinite', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_infinite_status'])) {
			$data['module_infinite_status'] = $this->request->post['module_infinite_status'];
		} else {
			$data['module_infinite_status'] = $this->config->get('module_infinite_status');
		}

		if (isset($this->request->post['module_infinite_mobile'])) {
			$data['module_infinite_mobile'] = $this->request->post['module_infinite_mobile'];
		} elseif (!is_null($this->config->get('module_infinite_mobile'))) {
			$data['module_infinite_mobile'] = $this->config->get('module_infinite_mobile');
		} else {
			$data['module_infinite_mobile'] = 1;
		}

		if (isset($this->request->post['module_infinite_method'])) {
			$data['module_infinite_method'] = $this->request->post['module_infinite_method'];
		} else {
			$data['module_infinite_method'] = $this->config->get('module_infinite_method');
		}

		if (isset($this->request->post['module_infinite_update'])) {
			$data['module_infinite_update'] = $this->request->post['module_infinite_update'];
		} else {
			$data['module_infinite_update'] = $this->config->get('module_infinite_update');
		}

		if (isset($this->request->post['module_infinite_hide'])) {
			$data['module_infinite_hide'] = $this->request->post['module_infinite_hide'];
		} else {
			$data['module_infinite_hide'] = $this->config->get('module_infinite_hide');
		}

		if (isset($this->request->post['module_infinite_route'])) {
			$data['module_infinite_route'] = $this->request->post['module_infinite_route'];
		} elseif (!is_null($this->config->get('module_infinite_route'))) {
			$data['module_infinite_route'] = $this->config->get('module_infinite_route');
		} else {
			$data['module_infinite_route'] = "product/category\nproduct/search\nproduct/manufacturer/info\nproduct/special";
		}

		if (isset($this->request->post['module_infinite_class'])) {
			$data['module_infinite_class'] = $this->request->post['module_infinite_class'];
		} else {
			$data['module_infinite_class'] = $this->config->get('module_infinite_class');
		}

		if (isset($this->request->post['module_infinite_css'])) {
			$data['module_infinite_css'] = $this->request->post['module_infinite_css'];
		} elseif (!is_null($this->config->get('module_infinite_css'))) {
			$data['module_infinite_css'] = $this->config->get('module_infinite_css');
		} else {
			$data['module_infinite_css'] = '.dc-clearfix {clear:both;text-align:center;width:100%;margin-bottom:10px;}';
		}

		if (isset($this->request->post['module_infinite_js'])) {
			$data['module_infinite_js'] = $this->request->post['module_infinite_js'];
		} else {
			$data['module_infinite_js'] = $this->config->get('module_infinite_js');
		}

		if (isset($this->request->post['module_infinite_wrapper'])) {
			$data['module_infinite_wrapper'] = $this->request->post['module_infinite_wrapper'];
		} elseif (!is_null($this->config->get('module_infinite_wrapper'))) {
			$data['module_infinite_wrapper'] = $this->config->get('module_infinite_wrapper');
		} else {
			$data['module_infinite_wrapper'] = '.row';
		}

		if (isset($this->request->post['module_infinite_product'])) {
			$data['module_infinite_product'] = $this->request->post['module_infinite_product'];
		} elseif (!is_null($this->config->get('module_infinite_product'))) {
			$data['module_infinite_product'] = $this->config->get('module_infinite_product');
		} else {
			$data['module_infinite_product'] = '#content .product-layout';
		}

		if (isset($this->request->post['module_infinite_pagination'])) {
			$data['module_infinite_pagination'] = $this->request->post['module_infinite_pagination'];
		} elseif (!is_null($this->config->get('module_infinite_pagination'))) {
			$data['module_infinite_pagination'] = $this->config->get('module_infinite_pagination');
		} else {
			$data['module_infinite_pagination'] = '#content .row:last-child';
		}

		if (isset($this->request->post['module_infinite_active'])) {
			$data['module_infinite_active'] = $this->request->post['module_infinite_active'];
		} elseif (!is_null($this->config->get('module_infinite_active'))) {
			$data['module_infinite_active'] = $this->config->get('module_infinite_active');
		} else {
			$data['module_infinite_active'] = '.active';
		}

		if (isset($this->request->post['module_infinite_threshold'])) {
			$data['module_infinite_threshold'] = $this->request->post['module_infinite_threshold'];
		} elseif (!is_null($this->config->get('module_infinite_threshold'))) {
			$data['module_infinite_threshold'] = $this->config->get('module_infinite_threshold');
		} else {
			$data['module_infinite_threshold'] = -500;
		}

		if (isset($this->request->post['module_infinite_animation'])) {
			$data['module_infinite_animation'] = $this->request->post['module_infinite_animation'];
		} else {
			$data['module_infinite_animation'] = $this->config->get('module_infinite_animation');
		}

		if (isset($this->request->post['module_infinite_message'])) {
			$data['module_infinite_message'] = $this->request->post['module_infinite_message'];
		} else {
			$data['module_infinite_message'] = $this->config->get('module_infinite_message');
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['animations'] = array(
			'Attention Seekers' => array(
				'bounce',
				'flash',
				'pulse',
				'rubberBand',
				'shake',
				'swing',
				'tada',
				'wobble',
				'jello'
			),
			'Bouncing' => array(
				'bounceIn',
				'bounceInDown',
				'bounceInLeft',
				'bounceInRight',
				'bounceInUp'
			),
			'Fading' => array(
				'fadeIn',
				'fadeInDown',
				'fadeInDownBig',
				'fadeInLeft',
				'fadeInLeftBig',
				'fadeInRight',
				'fadeInRightBig',
				'fadeInUp',
				'fadeInUpBig'
			),
			'Flippers' => array(
				'flip',
				'flipInX',
				'flipInY'
			),
			'Lightspeed' => array(
				'lightSpeedIn'
			),
			'Rotating' => array(
				'rotateIn',
				'rotateInDownLeft',
				'rotateInDownRight',
				'rotateInUpLeft',
				'rotateInUpRight'
			),
			'Sliding' => array(
				'slideInUp',
				'slideInDown',
				'slideInLeft',
				'slideInRight'
			),
			'Zoom' => array(
				'zoomIn',
				'zoomInDown',
				'zoomInLeft',
				'zoomInRight',
				'zoomInUp'
			),
			'Specials' => array(
				'rollIn'
			)
		);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/infinite', $data));
	}

	public function install() {
		$this->load->model('setting/event');

		$this->model_setting_event->addEvent('infinite', 'catalog/view/common/footer/after', 'extension/module/infinite/footer');
	}

	public function uninstall() {
		$this->load->model('setting/event');

		$this->model_setting_event->deleteEventByCode('infinite');
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/infinite')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}