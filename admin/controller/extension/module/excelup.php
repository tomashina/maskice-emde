<?php
/*
 * Excelup OpenCart Extension by OpencartBot
 * https://opencartbot.com/en/excelup
 * Released under CC BY-ND 3.0 license
 */

class ControllerExtensionModuleExcelup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/excelup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_excelup', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
                $this->response->redirect($this->url->link('extension/module/excelup', 'user_token=' . $this->session->data['user_token'], true));
            } else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'].'&type=module', true));
			}
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])&&!$this->request->post) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'].'&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/excelup', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/excelup', 'user_token=' . $this->session->data['user_token'], true);
		$data['action_upload'] = $this->url->link('extension/module/excelup/upload', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'].'&type=module', true);

		if (isset($this->request->post['module_excelup_status'])) {
			$data['module_excelup_status'] = $this->request->post['module_excelup_status'];
		} else {
			$data['module_excelup_status'] = $this->config->get('module_excelup_status');
		}

		if (isset($this->request->post['module_excelup_firstrow'])) {
			$data['module_excelup_firstrow'] = $this->request->post['module_excelup_firstrow'];
		} elseif ($this->config->get('module_excelup_firstrow')) {
			$data['module_excelup_firstrow'] = $this->config->get('module_excelup_firstrow');
		} else {
			$data['module_excelup_firstrow'] = 1;
		}

		if (isset($this->request->post['module_excelup_ident'])) {
			$data['module_excelup_ident'] = $this->request->post['module_excelup_ident'];
		} else {
			$data['module_excelup_ident'] = $this->config->get('module_excelup_ident');
		}

		if (isset($this->request->post['module_excelup_idcol'])) {
			$data['module_excelup_idcol'] = $this->request->post['module_excelup_idcol'];
		} elseif ($this->config->get('module_excelup_idcol')) {
			$data['module_excelup_idcol'] = $this->config->get('module_excelup_idcol');
		} else {
			$data['module_excelup_idcol'] = 1;
		}

		if (isset($this->request->post['module_excelup_price'])) {
			$data['module_excelup_price'] = $this->request->post['module_excelup_price'];
		} else {
			$data['module_excelup_price'] = $this->config->get('module_excelup_price');
		}

		if (isset($this->request->post['module_excelup_pricecol'])) {
			$data['module_excelup_pricecol'] = $this->request->post['module_excelup_pricecol'];
		} elseif ($this->config->get('module_excelup_pricecol')) {
			$data['module_excelup_pricecol'] = $this->config->get('module_excelup_pricecol');
		} else {
			$data['module_excelup_pricecol'] = 2;
		}

		if (isset($this->request->post['module_excelup_priceup'])) {
			$data['module_excelup_priceup'] = $this->request->post['module_excelup_priceup'];
		} elseif ($this->config->get('module_excelup_priceup')) {
			$data['module_excelup_priceup'] = $this->config->get('module_excelup_priceup');
		} else {
			$data['module_excelup_priceup'] = 0;
		}

		if (isset($this->request->post['module_excelup_special'])) {
			$data['module_excelup_special'] = $this->request->post['module_excelup_special'];
		} else {
			$data['module_excelup_special'] = $this->config->get('module_excelup_special');
		}

		if (isset($this->request->post['module_excelup_special_new'])) {
			$data['module_excelup_special_new'] = $this->request->post['module_excelup_special_new'];
		} else {
			$data['module_excelup_special_new'] = $this->config->get('module_excelup_special_new');
		}

		if (isset($this->request->post['module_excelup_specialcol'])) {
			$data['module_excelup_specialcol'] = $this->request->post['module_excelup_specialcol'];
		} elseif ($this->config->get('module_excelup_specialcol')) {
			$data['module_excelup_specialcol'] = $this->config->get('module_excelup_specialcol');
		} else {
			$data['module_excelup_specialcol'] = 2;
		}

		if (isset($this->request->post['module_excelup_specialup'])) {
			$data['module_excelup_specialup'] = $this->request->post['module_excelup_specialup'];
		} elseif ($this->config->get('module_excelup_specialup')) {
			$data['module_excelup_specialup'] = $this->config->get('module_excelup_specialup');
		} else {
			$data['module_excelup_specialup'] = 0;
		}

		if (isset($this->request->post['module_excelup_quantity'])) {
			$data['module_excelup_quantity'] = $this->request->post['module_excelup_quantity'];
		} else {
			$data['module_excelup_quantity'] = $this->config->get('module_excelup_quantity');
		}

		if (isset($this->request->post['module_excelup_quantitycol'])) {
			$data['module_excelup_quantitycol'] = $this->request->post['module_excelup_quantitycol'];
		} elseif ($this->config->get('module_excelup_quantitycol')) {
			$data['module_excelup_quantitycol'] = $this->config->get('module_excelup_quantitycol');
		} else {
			$data['module_excelup_quantitycol'] = 3;
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/excelup', $data));
	}

	public function upload() {
		$this->load->language('extension/module/excelup');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/module/excelup');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateUpload()) {

			if ((isset($this->request->files['excelup_upload'] )) && (is_uploaded_file($this->request->files['excelup_upload']['tmp_name']))) {
				$file = DIR_UPLOAD . time() . '.xlsx';
				$moved = move_uploaded_file($this->request->files['excelup_upload']['tmp_name'], $file);

				if ($moved) {
					if ($this->parseFile($file)) {
						$this->session->data['success'] = $this->language->get('text_success_import');
						$this->response->redirect($this->url->link('extension/module/excelup', 'user_token=' . $this->session->data['user_token'], true));
					} else {
						$this->session->data['warning'] = $this->language->get('error_import');
						$this->response->redirect($this->url->link('extension/module/excelup', 'user_token=' . $this->session->data['user_token'], true));
					}        
				} else {
				  $this->session->data['warning'] = $this->request->files['excelup_upload']['error'];
				}
			} else {
				$this->session->data['warning'] = $this->language->get('error_upload');
			}
		}
		$this->response->redirect($this->url->link('extension/module/excelup', 'user_token=' . $this->session->data['user_token'], true));
	}

	protected function parseFile($file) {
		set_time_limit(0);

		if (version_compare(phpversion(), '7.2.', '<')) {
			$this->session->data['warning'] = $this->language->get('error_php_version');
		}

		$this->load->model('extension/module/excelup');
		
		require (DIR_SYSTEM.'library/excelup/vendor/autoload.php');

		$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

		$filetype = PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
		$object = PhpOffice\PhpSpreadsheet\IOFactory::createReader($filetype);
		$object->setReadDataOnly(true);
		$reader = $object->load($file);

		$sheet = $reader->getActiveSheet();

		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
		if ($this->config->get('module_excelup_firstrow')) {
			$firstrow = intval($this->config->get('module_excelup_firstrow'));
			if (!$firstrow) {
				$firstrow = 1;
			}
		} else {
			$firstrow = 1;
		}

		for ($row = $firstrow; $row <= $highestRow; ++$row) {
			$value = array();

			for ($col = 1; $col <= $highestColumnIndex; ++$col) {
				$value[$col] = $sheet->getCellByColumnAndRow($col, $row)->getValue();
				if (substr($value[$col], 0, 1) == '=') {
					$value[$col] = $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
				}
			}

			if (!empty($value[$this->config->get('module_excelup_idcol')])) {

				$ident_val = trim($value[$this->config->get('module_excelup_idcol')]);
	
				if ($this->config->get('module_excelup_price') && $value[$this->config->get('module_excelup_pricecol')] !== false) {
					if (floatval($this->config->get('module_excelup_priceup')) > 0) {
						$percent = floatval($this->config->get('module_excelup_priceup')) / 100;
					} else {
						$percent = 0;
					}
					$price = floatval($value[$this->config->get('module_excelup_pricecol')]) * (1 + $percent);
				} else {
					$price = false;
				}

				if ($this->config->get('module_excelup_special')) {
					if (empty($value[$this->config->get('module_excelup_specialcol')])) {
						$special = 0;
					} else {
						if (floatval($this->config->get('module_excelup_specialup')) > 0) {
							$percent_special = floatval($this->config->get('module_excelup_specialup')) / 100;
						} else {
							$percent_special = 0;
						}
						$special = floatval($value[$this->config->get('module_excelup_specialcol')]) * (1 + $percent_special);
					}
				} else {
					$special = false;
				}

				if ($this->config->get('module_excelup_quantity')) {
					if(!empty($value[$this->config->get('module_excelup_quantitycol')])) {
						$quantity = intval($value[$this->config->get('module_excelup_quantitycol')]);
					} else {
						$quantity = 0;
					}
				} else {
					$quantity = false;
				}

				$product_id = 0;
				$field = $this->config->get('module_excelup_ident');
				if ($field == 'product_id') {
					$product_id = $ident_val;
				} else {
					$product_id = $this->model_extension_module_excelup->getProductId($field, $ident_val);
				}

				if (intval($product_id)) {
					$this->model_extension_module_excelup->updateProduct($product_id, $price, $special, $quantity);
				}
				
			}
		}

		$this->cache->delete('product');

		return true;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/excelup')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

	protected function validateUpload() {
		if (!$this->user->hasPermission('modify', 'extension/module/excelup')) {
			$this->error['warning'] = $this->language->get('error_permission');
			$this->session->data['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
}