<?php
class ControllerExtensionModuleInfinite extends Controller {
	public function footer($route = '', $data = array(), &$output = '') {
		if ($this->config->get('module_infinite_status')) {
			$routes = $this->config->get('module_infinite_route');
			$routes = explode("\n", $this->config->get('module_infinite_route'));
			$routes = array_filter($routes);
			$routes = array_unique($routes);
			$routes = array_map('trim', $routes);

			$page = isset($this->request->get['route']) ? $this->request->get['route'] : '';

			if (in_array($page, $routes)) {
				$product = $this->config->get('module_infinite_product');

				if ($product) {
					$info['product'] = $this->stringfy($product);
				} else {
					$info['product'] = '.product-layout';
				}

				$wrapper = $this->config->get('module_infinite_wrapper');

				if ($wrapper) {
					$info['wrapper'] = $this->stringfy($wrapper);
				} else {
					$info['wrapper'] = '.row';
				}

				$pagination = $this->config->get('module_infinite_pagination');

				if ($pagination) {
					$info['pagination'] = $this->stringfy($pagination);
				} else {
					$info['pagination'] = '#content .row:last-child';
				}

				$active = $this->config->get('module_infinite_active');

				if ($active) {
					$info['active'] = $this->stringfy($active);
				} else {
					$info['active'] = '.active';
				}

				$message = $this->config->get('module_infinite_message');

				$language_id = $this->config->get('config_language_id');

				if (isset($message[$language_id])) {
					$info['loading']	= $this->stringfy($message[$language_id]['loading']);
					$info['button']		= $this->stringfy($message[$language_id]['button']);
					$info['finished'] 	= $this->stringfy($message[$language_id]['finished']);
				} else {
					$info['loading']	= '';
					$info['button'] 	= '';
					$info['finished'] 	= '';
				}

				$info['hide']		= (int)$this->config->get('module_infinite_hide');
				$info['method']		= $this->config->get('module_infinite_method');
				$info['update']		= $this->config->get('module_infinite_update');
				$info['mobile']		= (int)$this->config->get('module_infinite_mobile');
				$info['threshold']	= (int)$this->config->get('module_infinite_threshold');

				$css = $this->config->get('module_infinite_css');

				if ($css) {
					$info['css'] = $this->stringfy($css);
				} else {
					$info['css'] = '';
				}

				if ($this->config->get('module_infinite_class')) {
					$info['class'] = $this->config->get('module_infinite_class');
				} else {
					$info['class'] = '';
				}

				if ($this->config->get('module_infinite_animation')) {
					$info['animate'] = true;
					$info['class'] .= ' animated ' . $this->config->get('module_infinite_animation');
				} else {
					$info['animate'] = false;
				}

				if ($info['class']) {
					$info['class'] = $this->stringfy($info['class']);
				}

				if ($this->config->get('module_infinite_js')) {
					$info['js'] = $this->stringfy($this->config->get('module_infinite_js'));
				} else {
					$info['js'] = '';
				}

				$output = $this->load->view('extension/module/infinite', $info) . $output;
			}
		}
	}

	protected function stringfy($string) {
		return html_entity_decode(trim(preg_replace('/\s\s+/', ' ', $string)), ENT_QUOTES, 'UTF-8');
	}
}