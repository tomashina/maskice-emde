<?php
class ControllerExtensionModuleSyncProductQuantity extends Controller {
	private $error = array(); 
	
	public function index() {

		$this->load->language('extension/module/sync_product_quantity');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if (isset($this->session->data['spq_modules'])){
				unset($this->session->data['spq_modules']);
			}
			if (isset($this->session->data['sync'])){
				unset($this->session->data['sync']);
			}

			$this->load->model('localisation/language');
			$language = $this->model_localisation_language->getLanguage($this->request->post['op_sync_lang']);
			$this->request->post['op_sync_lang_name'] = $language['name'];
			
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('sync_product_quantity', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->request->post['name']);

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		}
		
		if (isset($this->error['newdb_host'])) {
			$data['error_newdb_host'] = $this->error['newdb_host'];
		}
		
		if (isset($this->error['newdb_port'])) {
			$data['error_newdb_port'] = $this->error['newdb_port'];
		}
		
		if (isset($this->error['newdb_user'])) {
			$data['error_newdb_user'] = $this->error['newdb_user'];
		}
		
		if (isset($this->error['newdb_name'])) {
			$data['error_newdb_name'] = $this->error['newdb_name'];
		}
		
		if (isset($this->error['sync_by'])) {
			$data['error_sync_by'] = $this->error['sync_by'];
		}
		

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['newdb_host'])) {
			$data['newdb_host'] = $this->request->post['newdb_host'];
		} elseif (!empty($module_info)) {
			$data['newdb_host'] = $module_info['newdb_host'];
		} else {
			$data['newdb_host'] = 'localhost';
		}
		
		if (isset($this->request->post['newdb_port'])) {
			$data['newdb_port'] = $this->request->post['newdb_port'];
		} elseif (!empty($module_info)) {
			$data['newdb_port'] = $module_info['newdb_port'];
		} else {
			$data['newdb_port'] = '3306';
		}
		
		if (isset($this->request->post['newdb_user'])) {
			$data['newdb_user'] = $this->request->post['newdb_user'];
		} elseif (!empty($module_info)) {
			$data['newdb_user'] = $module_info['newdb_user'];
		} else {
			$data['newdb_user'] = '';
		}
		
		if (isset($this->request->post['newdb_password'])) {
			$data['newdb_password'] = html_entity_decode($this->request->post['newdb_password']);
		} elseif (!empty($module_info)) {
			$data['newdb_password'] = $module_info['newdb_password'];
		} else {
			$data['newdb_password'] = '';
		}
		
		if (isset($this->request->post['newdb_name'])) {
			$data['newdb_name'] = html_entity_decode($this->request->post['newdb_name']);
		} elseif (!empty($module_info)) {
			$data['newdb_name'] = $module_info['newdb_name'];
		} else {
			$data['newdb_name'] = '';
		}
		
		if (isset($this->request->post['newdb_prefix'])) {
			$data['newdb_prefix'] = html_entity_decode($this->request->post['newdb_prefix']);
		} elseif (!empty($module_info)) {
			$data['newdb_prefix'] = $module_info['newdb_prefix'];
		} else {
			$data['newdb_prefix'] = 'oc_';
		}
		
		//Sync Product ID's
		$data['list_sync_prod_id']	= array();
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'product_id',
			'name'	  => $this->language->get('text_id')
		);
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'model',
			'name'	  => $this->language->get('text_model')
		);
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'sku',
			'name'	  => $this->language->get('text_sku')
		);
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'upc',
			'name'	  => $this->language->get('text_upc')
		);
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'ean',
			'name'	  => $this->language->get('text_ean')
		);
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'jan',
			'name'	  => $this->language->get('text_jan')
		);
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'isbn',
			'name'	  => $this->language->get('text_isbn')
		);
		$data['list_sync_prod_id'][] = array(
			'id'	  => 'mpn',
			'name'	  => $this->language->get('text_mpn')
		);
			
		if (isset($this->request->post['sync_by'])) {
			$data['sync_by'] = $this->request->post['sync_by'];
		} elseif (!empty($module_info)) {
			$data['sync_by'] = $module_info['sync_by'];
		} else {
			$data['sync_by'] = 'product_id';
		}

		//Sync Product Categories
		$this->load->model('catalog/category');
		
		if (isset($this->request->post['sync_cat'])) {
			$sync_cat = $this->request->post['sync_cat'];
		} elseif (!empty($module_info) && isset($module_info['sync_cat'])) {
			$sync_cat = $module_info['sync_cat'];
		} else {
			$sync_cat = array();
		}

		$data['list_sync_categories'] = array();

		foreach ($sync_cat as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['list_sync_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}
		
		if (isset($this->request->post['sync_status'])) {
			$data['sync_status'] = $this->request->post['sync_status'];
		} elseif (!empty($module_info)) {
			$data['sync_status'] = $module_info['sync_status'];
		}
		
		if (isset($this->request->post['op_sync'])) {
			$data['op_sync'] = $this->request->post['op_sync'];
		} elseif (!empty($module_info)) {
			$data['op_sync'] = $module_info['op_sync'];
		}
		
		if (isset($this->request->post['op_sync_lang'])) {
			$data['op_sync_lang'] = $this->request->post['op_sync_lang'];
		} elseif (!empty($module_info)) {
			$data['op_sync_lang'] = $module_info['op_sync_lang'];
		}
		
		if (isset($this->request->post['sync_difference'])) {
			$data['sync_difference'] = $this->request->post['sync_difference'];
		} elseif (!empty($module_info)) {
			$data['sync_difference'] = $module_info['sync_difference'];
		}
		
		if (isset($this->request->post['subtract_constant'])) {
			$data['subtract_constant'] = $this->request->post['subtract_constant'];
		} elseif (!empty($module_info)) {
			$data['subtract_constant'] = $module_info['subtract_constant'];
		}
		
		$data['heading_title']				= $this->language->get('heading_title');
		$data['text_module_title']			= $this->language->get('text_module_title');
		$data['text_database_host']			= $this->language->get('text_database_host');
		$data['text_database_host_port']	= $this->language->get('text_database_host_port');
		$data['text_user']					= $this->language->get('text_user');
		$data['text_password']				= $this->language->get('text_password');
		$data['text_database_name']			= $this->language->get('text_database_name');
		$data['text_database_prefix']		= $this->language->get('text_database_prefix');
		
		$data['text_enabled']				= $this->language->get('text_enabled');
		$data['text_disabled']				= $this->language->get('text_disabled');

		$data['entry_name'] 				= $this->language->get('entry_name');
		$data['entry_status'] 				= $this->language->get('entry_status');
		
		$data['button_save']				= $this->language->get('button_save');
		$data['button_cancel']				= $this->language->get('button_cancel');
		$data['button_add_module']			= $this->language->get('button_add_module');
		$data['button_remove']				= $this->language->get('button_remove');
		$data['error_field']				= $this->language->get('error_field');
		
		$data['text_sync_by']				= $this->language->get('text_sync_by');
		$data['help_sync_by']				= $this->language->get('help_sync_by');
		
		$data['text_sync_cat'] 				= $this->language->get('text_sync_cat');
		$data['help_sync_cat'] 				= $this->language->get('help_sync_cat');
		$data['entry_category'] 			= $this->language->get('entry_category');
		
		$data['text_sync_status']			= $this->language->get('text_sync_status');
		$data['help_sync_status']			= $this->language->get('help_sync_status');
		
		$data['text_option_sync']			= $this->language->get('text_option_sync');
		$data['help_option_sync']			= $this->language->get('help_option_sync');
		$data['text_yes'] 					= $this->language->get('text_yes');
		$data['text_no'] 					= $this->language->get('text_no');
		$data['text_option_sync_lang']		= $this->language->get('text_option_sync_lang');
		$data['help_option_sync_lang']		= $this->language->get('help_option_sync_lang');
		
		$data['text_sync_difference']		= $this->language->get('text_sync_difference');
		$data['help_sync_difference']		= $this->language->get('help_sync_difference');
		
		$data['text_subtract_constant']		= $this->language->get('text_subtract_constant');
		$data['help_subtract_constant']		= $this->language->get('help_subtract_constant');
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
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
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);
		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/sync_product_quantity', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/sync_product_quantity', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/sync_product_quantity', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/sync_product_quantity', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

		$data['user_token'] = $this->session->data['user_token'];
		
		$data['header']						= $this->load->controller('common/header');
		$data['column_left']				= $this->load->controller('common/column_left');
		$data['footer']						= $this->load->controller('common/footer');
						
		$this->response->setOutput($this->load->view('extension/module/sync_product_quantity', $data));	

	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/sync_product_quantity')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$error_not_all = false;
		
		if (empty($this->request->post['name'])) {
			$this->error['name'] = true;
			$error_not_all = true;
		}

		if (empty($this->request->post['newdb_host'])) {
			$this->error['newdb_host'] = true;
			$error_not_all = true;
		}
		
		if (empty($this->request->post['newdb_port'])) {
			$this->error['newdb_port'] = true;
			$error_not_all = true;
		}
		
		if (empty($this->request->post['newdb_user'])) {
			$this->error['newdb_user'] = true;
			$error_not_all = true;
		}
		
		if (empty($this->request->post['newdb_name'])) {
			$this->error['newdb_name'] = true;
			$error_not_all = true;
		}
		
		if (empty($this->request->post['sync_by'])) {
			$this->error['sync_by'] = true;
			$error_not_all = true;
		}
		
		if ($error_not_all){
			$this->error['warning'] = $this->language->get('error_not_all');
		} else {
			//Check connection to data base with entered data by user
			$second_db_connect = @new mysqli($this->request->post['newdb_host'], $this->request->post['newdb_user'], $this->request->post['newdb_password'], $this->request->post['newdb_name'], $this->request->post['newdb_port']);
			
			if ($second_db_connect->connect_error) {
				$this->error['warning'] = sprintf($this->language->get('error_conection'), $second_db_connect->connect_error);
			}
		}
		
		return !$this->error;
	}
}
?>