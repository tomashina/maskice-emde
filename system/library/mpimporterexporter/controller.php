<?php
namespace MpImporterExporter;
use \Controller as OpenCartController;
use MpImporterExporter\MpAlphaNumExcel;
class Controller extends OpenCartController {

	protected $token = 'token';
	protected $extension_page = 'extension/extension';

	public function __construct($registry) {
		parent :: __construct($registry);
		if(VERSION >= '3.0.0.0') {
			$this->token = 'user_token';
			$this->extension_page = 'marketplace/extension';
		}
		$registry->set('mpalphanumexcel', new MpAlphaNumExcel());
	}

	protected function breadcrumbs(&$data) {
		$this->load->language('extension/module/mpimportexport', 'mpimportexport');

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->token.'=' . $this->session->data[$this->token], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('mpimportexport')->get('text_extension'),
			'href' => $this->url->link($this->extension_page, $this->token.'=' . $this->session->data[$this->token] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('mpimportexport')->get('heading_title'),
			'href' => $this->url->link('extension/module/mpimportexport', $this->token.'=' . $this->session->data[$this->token], true)
		);

	}

	protected function backLink(&$data) {
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['cancel'] = $this->url->link('extension/module/mpimportexport', $this->token.'=' . $this->session->data[$this->token] . '&type=module', true);
	}

	protected function loadView($route, &$data=[], $tpl=false) {

		// remove .tpl from route
		if (utf8_substr($route, -4) === '.tpl') {
			$route = str_replace(utf8_substr($route, -4), "", $route);
		}

		// remove .twig from route

		if (utf8_substr($route, -5) === '.twig') {
			$route = str_replace(utf8_substr($route, -5), "", $route);
		}

		if(VERSION >= '3.0.0.0') {
			if($tpl) {
				// we load tpl view
	    	$old_template = $this->config->get('template_engine');
				$this->config->set('template_engine', 'template');
			}

			$file = $this->load->view($route, $data);
			if($tpl) {
				$this->config->set('template_engine', $old_template);
			}

		} else {

			$file = $this->load->view($route.'.tpl', $data);
		}

		return $file;
	}
}
