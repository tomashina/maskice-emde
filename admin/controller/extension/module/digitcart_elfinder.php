<?php
class ControllerExtensionModuleDigitCartElfinder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/digitcart_elfinder');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_digitcart_elfinder', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/digitcart_elfinder', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/digitcart_elfinder', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$vars = array(
			'status' => 0,
			'click' => 2,
			'watermark' => array(
				'status' => 0,
				'image' => '',
				'horizontal_selection' => 'right',
				'horizontal_px' => 5,
				'vertical_selection' => 'bottom',
				'vertical_px' => 5,
				'left' => false,
				'top' => false,
				'transparency' => 70
			)
		);

		foreach ($vars as $var => $default) {
			if (isset($this->request->post['module_digitcart_elfinder_' . $var])) {
				$data['module_digitcart_elfinder_' . $var] = $this->request->post['module_digitcart_elfinder_' . $var];
			} elseif ($this->config->get('module_digitcart_elfinder_' . $var)) {
				$data['module_digitcart_elfinder_' . $var] = $this->config->get('module_digitcart_elfinder_' . $var);
			} else {
				$data['module_digitcart_elfinder_' . $var] = $default;
			}
		}

		if (isset($this->request->post['module_digitcart_elfinder_watermark']['image'])) {
			$data['image'] = $this->request->post['module_digitcart_elfinder_watermark']['image'];
		} elseif ($this->config->get('module_digitcart_elfinder_watermark')) {
			$data['image'] = $this->config->get('module_digitcart_elfinder_watermark')['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['module_digitcart_elfinder_watermark']['image']) && is_file(DIR_IMAGE . $this->request->post['module_digitcart_elfinder_watermark']['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['module_digitcart_elfinder_watermark']['image'], 100, 100);
		} elseif ($this->config->get('module_digitcart_elfinder_watermark') && is_file(DIR_IMAGE . $this->config->get('module_digitcart_elfinder_watermark')['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->config->get('module_digitcart_elfinder_watermark')['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);


		$data['elfinder_url'] = $this->url->link('extension/module/digitcart_elfinder/elfinder', 'user_token='. $this->session->data['user_token'], true);

		$isCommonModified = false;

		$isSummernoteModified = false;

		$js_files = array(
			'common' => 'view/javascript/common.js',
			'summernote' => 'view/javascript/summernote/opencart.js',
		);

		foreach ($js_files as $file_name => $target_file) {
			$target_file = DIR_APPLICATION . $target_file;

			if ($file_name == 'common') {
				if (is_file($target_file)) {
					$original_contents = file_get_contents($target_file);
					if (stristr($original_contents, 'elfinder')) {
						$isCommonModified = true;
					}
				}
			}

			if ($file_name == 'summernote') {
				if (is_file($target_file)) {
					$original_contents = file_get_contents($target_file);
					if (stristr($original_contents, 'elfinder')) {
						$isSummernoteModified = true;
					}
				}
			}
		}

		$data['IsJsModified'] = $isCommonModified && $isSummernoteModified ? true : false;
		$data['common_js'] = $js_files['common'];
		$data['summernote_js'] = $js_files['summernote'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/digitcart_elfinder', $data));
	}

	public function productForm(&$route = false, &$data = false, &$output = false) {
		if ($this->config->get('module_digitcart_elfinder_status')) {
			$l = $this->load->language('extension/module/digitcart_elfinder');

			if ($this->request->server['HTTPS']) {
				$dir_image_url = HTTPS_CATALOG . 'image/';
			} else {
				$dir_image_url = HTTP_CATALOG . 'image/';
			}

			$h = '<footer';

			$r = '<style type="text/css">.ui-front.ui-widget.ui-widget-content.elfinder-button-search-menu.ui-corner-all {top: 68px;}</style><script id="digitcart-add-bulk-additional-images-script">
				$("#tab-image #images thead td:last-child").append("<a class=\"btn btn-info\" title=\"' . $l['button_add_bulk'] . '\" data-toggle=\"tooltip\" id=\"add-bulk-additional-images\"><i class=\"fa fa-magic\"></i></a>");
				$(document).on("click", "#add-bulk-additional-images", function() {
					if ($("#dc-elfinder-script").length) {
						$("<div style=\"z-index:999999\" id=\"dc-elfinder-dialog\" />").dialogelfinder({
							url : $("#dc-elfinder-script").data("elfinder-url"),
							width: "80%",
							height: "600px",
							onlyMimes: ["image"],
							commandsOptions: {
								getfile: { multiple: true }
							},
							getFileCallback: function(file) {
								var urls = $.map(file, function(f) { return f.url; });
								for(i in urls) {
									var imageFullUrl = decodeURI(urls[i]);
									var imageInputUrl = imageFullUrl.replace("' . $dir_image_url . '", "");
									html  = "<tr id=\"image-row" + image_row + "\">";
									html += "  <td class=\"text-left\"><a href=\"\" id=\"thumb-image" + image_row + "\"data-toggle=\"image\" class=\"img-thumbnail\"><img src=\"" + imageFullUrl + "\" style=\"max-width:100px;max-height:100px\" alt=\"\" title=\"\" data-placeholder=\"' . $data['placeholder'] . '\" /></a><input type=\"hidden\" name=\"product_image[" + image_row + "][image]\" value=\"" + imageInputUrl +"\" id=\"input-image" + image_row + "\" /></td>";
									html += "  <td class=\"text-right\"><input type=\"text\" name=\"product_image[" + image_row + "][sort_order]\" value=\"\" placeholder=\"' . $data['entry_sort_order'] . '\" class=\"form-control\" /></td>";
									html += "  <td class=\"text-left\"><button type=\"button\" onclick=\"$(this).parent().parent().remove();\" data-toggle=\"tooltip\" title=\"' . $data['button_remove'] . '\" class=\"btn btn-danger\"><i class=\"fa fa-minus-circle\"></i></button></td>";
									html += "</tr>";
									$("#images tbody").append(html);
									image_row++;
								}
								$("#dc-elfinder-dialog").remove();
							}
						});
					}
				});
			</script>';

			$output = str_replace(
				$h,
				$r . $h,
				$output
			);
		}
	}

	public function afterHeader(&$route = false, &$data = false, &$output = false) {
		if (isset($this->request->get['user_token']) && isset($this->session->data['user_token']) && ($this->request->get['user_token'] == $this->session->data['user_token'])) {
			if ($this->config->get('module_digitcart_elfinder_status')) {
				$elfinder_url = $this->url->link('extension/module/digitcart_elfinder/elfinder', 'user_token='.$this->session->data['user_token'], true);

				if ($this->request->server['HTTPS']) {
					$dir_image_url = HTTPS_CATALOG . 'image/';
				} else {
					$dir_image_url = HTTP_CATALOG . 'image/';
				}

				$elfinder_click = $this->config->get('module_digitcart_elfinder_click');

				$hook1 = '<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>';

				$replacement1 = '
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/jquery/jquery-ui-1.12.0.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/commands.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/common.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/contextmenu.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/cwd.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/dialog.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/fonts.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/navbar.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/places.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/quicklook.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/statusbar.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/theme.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/toast.css">
					<link rel="stylesheet" href="view/javascript/digitcart_elfinder/css/toolbar.css">
					<script src="view/javascript/digitcart_elfinder/jquery/jquery-ui-1.12.0.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.version.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/jquery.elfinder.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.mimetypes.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.options.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.options.netmount.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.history.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.command.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/elFinder.resources.js"></script>

					<script src="view/javascript/digitcart_elfinder/js/jquery.dialogelfinder.js"></script>

					<!-- elfinder default lang -->
					<script src="view/javascript/digitcart_elfinder/js/i18n/elfinder.en.js"></script>

					<!-- elfinder ui -->
					<script src="view/javascript/digitcart_elfinder/js/ui/button.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/contextmenu.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/cwd.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/dialog.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/fullscreenbutton.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/navbar.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/navdock.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/overlay.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/panel.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/path.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/places.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/searchbutton.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/sortbutton.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/stat.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/toast.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/toolbar.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/tree.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/uploadButton.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/viewbutton.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/ui/workzone.js"></script>

					<!-- elfinder commands -->
					<script src="view/javascript/digitcart_elfinder/js/commands/archive.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/back.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/chmod.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/colwidth.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/copy.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/cut.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/download.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/duplicate.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/edit.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/empty.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/extract.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/forward.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/fullscreen.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/getfile.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/help.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/hidden.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/hide.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/home.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/info.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/mkdir.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/mkfile.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/netmount.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/open.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/opendir.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/opennew.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/paste.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/places.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/preference.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/quicklook.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/quicklook.plugins.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/reload.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/rename.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/resize.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/restore.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/rm.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/search.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/selectall.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/selectinvert.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/selectnone.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/sort.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/undo.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/up.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/upload.js"></script>
					<script src="view/javascript/digitcart_elfinder/js/commands/view.js"></script>

					<!-- elfinder 1.x connector API support (OPTIONAL) -->
					<script src="view/javascript/digitcart_elfinder/js/proxy/elFinderSupportVer1.js"></script>

					<!-- Extra contents editors (OPTIONAL) -->
					<script src="view/javascript/digitcart_elfinder/js/extras/editors.default.js"></script>

					<!-- GoogleDocs Quicklook plugin for GoogleDrive Volume (OPTIONAL) -->
					<script src="view/javascript/digitcart_elfinder/js/extras/quicklook.googledocs.js"></script>
				';

				$hook2 = '</head>';

				$replacement2 = '
					<script id="dc-elfinder-script" data-elfinder-url="' . $elfinder_url . '">
						function dcElfinder($element) {
							var targetInput = $element.parent().find("input");
							var targetThumb = $element;
							$(\'<div style="z-index:999999" id="dc-elfinder-dialog" />\').dialogelfinder({
								url : $("#dc-elfinder-script").data("elfinder-url"),
								width: "80%",
								height: "600px",
								onlyMimes: ["image"],
								getFileCallback: function(file) {
									var file = file[0] ? file[0] : file;
									var fileUrl = file.url.replace("' . $dir_image_url . '", "");
									fileUrl = decodeURI(fileUrl);
									targetInput.val(fileUrl);
									$.ajax({
										url: "index.php?route=extension/module/digitcart_elfinder/generateThumb&user_token=" + getURLVar("user_token"),
										type: "post",
										data: "img=" + fileUrl,
										dataType: "json",
										success: function(json) {
											if (json["thumb"]) {
												$element.find("img").attr("src", json["thumb"]);
											}
										}
									});
									$("#dc-elfinder-dialog").remove();
								}
							});
						}
						function dcElfinderSummernote(element) {
							$(\'<div style="z-index:999999" id="dc-elfinder-dialog" />\').dialogelfinder({
								url : $("#dc-elfinder-script").data("elfinder-url"),
								width: "80%",
								height: "600px",
								onlyMimes: ["image"],
								commandsOptions: {
									getfile: { multiple: true }
								},
								getFileCallback: function(file) {
									var urls = $.map(file, function(f) { return f.url; });
									for(i in urls) {
										$(element).summernote("insertImage", decodeURI(urls[i]));
									}
									$("#dc-elfinder-dialog").remove();
								}
							});
						}';

				if ($elfinder_click == 1) {
					$replacement2 .= '
						$(document).on("click", ".ui-selectee", function() {
							$(this).dblclick();
						});
					';
				}

				$replacement2 .= '</script>';

				$output = str_replace(
					array(
						$hook1,
						$hook2,
					),
					array(
						$hook1 . $replacement1,
						$replacement2 . $hook2,
					),
					$output
				);
			}
		}
	}

	public function generateThumb() {
		$json = array();

		if (!empty($this->request->post['img'])) {
			$this->load->model('tool/image');

			$json['thumb'] = $this->model_tool_image->resize($this->request->post['img'], 100, 100);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function elfinder() {
        $elfinder_autoload = DIR_SYSTEM . '/library/elfinder/php/autoload.php';

        if (is_file($elfinder_autoload)) {
			if ($this->request->server['HTTPS']) {
				$dir_image_url = HTTPS_CATALOG . 'image/';
			} else {
				$dir_image_url = HTTP_CATALOG . 'image/';
			}

			require_once($elfinder_autoload);

			function access($attr, $path, $data, $volume, $isDir, $relpath) {
				$basename = basename($path);
				return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
						 && strlen($relpath) !== 1           // but with out volume root
					? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
					:  null;                                 // else elFinder decide it itself
			}

			$opts = array(
				//'debug' => true,
				'roots' => array(
					// Items volume
					array(
						'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
						'path'          => DIR_IMAGE . 'catalog/',              	    // path to files (REQUIRED)
						'URL'           => $dir_image_url . 'catalog/', 					// URL to files (REQUIRED)
						'tmbURL'        => $dir_image_url . 'catalog/.tmb/',
						'trashHash'     => 't1_Lw',                     // elFinder's hash of trash folder
						'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
						'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
						'uploadAllow'   => array('image'),// Mimetype `image` and `text/plain` allowed to upload
						'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
						'accessControl' => 'access',                    // disable and hide dot starting files (OPTIONAL)
					),
					// Trash volume
					array(
						'id'            => '1',
						'driver'        => 'Trash',
						'path'          => DIR_IMAGE . 'catalog/.trash/',
						'tmbURL'        => $dir_image_url . 'catalog/.trash/.tmb/',
						'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
						'uploadDeny'    => array('all'),                // Recomend the same settings as the original volume that uses the trash
						'uploadAllow'   => array('image'),// Same as above
						'uploadOrder'   => array('deny', 'allow'),      // Same as above
						'accessControl' => 'access',                    // Same as above
					)
				)
			);

			$watermark = $this->config->get('module_digitcart_elfinder_watermark');

			if (!empty($watermark['status']) && !empty($watermark['image'])) {
				if ($watermark['horizontal_selection'] == 'right') {
					$right = $watermark['horizontal_px'];
					$left = false;
				} else {
					$right = false;
					$left = $watermark['horizontal_px'];
				}

				if ($watermark['vertical_selection'] == 'bottom') {
					$bottom = $watermark['vertical_px'];
					$top = false;
				} else {
					$bottom = false;
					$top = $watermark['vertical_px'];
				}

				$opts['bind'] = array(
					'upload.presave' => array(
						'Plugin.Watermark.onUpLoadPreSave'
					)
				);

				$opts['plugin']['Watermark'] = array(
					'enable'         => true,       // For control by volume driver
					'source'         => DIR_IMAGE . $watermark['image'], // Path to Water mark image
					'right'    => $right,          // Margin right pixel
					'left'     => $left,          // Margin left pixel
					'bottom'   => $bottom,          // Margin bottom pixel
					'top'      => $top,          // Margin top pixel
					'quality'        => 95,         // JPEG image save quality
					'transparency'   => $watermark['transparency'],         // Water mark image transparency ( other than PNG )
					'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
					'targetMinPixel' => 200,        // Target image minimum pixel size
					'offDropWith'    => null        // To disable it if it is dropped with pressing the meta key
													// Alt: 8, Ctrl: 4, Meta: 2, Shift: 1 - sum of each value
													// In case of using any key, specify it as an array
				);
			}

			$elfinder = new elFinderConnector(new elFinder($opts));
			$elfinder->run();
        }
    }

	public function modifyJsFile() {
		$this->load->language('extension/module/digitcart_elfinder');

		$json = array();

		if (isset($this->request->post['js_files'])) {
			foreach ($this->request->post['js_files'] as $file_name => $target_file) {
				$target_file = DIR_APPLICATION . $target_file;

				if ($file_name == 'common') {
					if (is_file($target_file)) {
						$original_contents = file_get_contents($target_file);

						if (!stristr($original_contents, 'elfinder')) {
							$copy_operation = copy($target_file, $target_file . '_elfinder_backup');

							if ($copy_operation) {
								$json['common']['info'][] = $this->language->get('text_backup_created');

								$hook = "('#modal-image').remove();";

								$replacement ="if (typeof(dcElfinder) != 'undefined') {dcElfinder(\$element);\$element.popover('destroy');return false;}";

								$modified_contents = str_replace($hook, $hook . "\n" . $replacement, $original_contents
								);

								if (file_put_contents($target_file, $modified_contents)) {
									$json['common']['success'][] = $this->language->get('text_file_success');
								} else {
									$json['common']['error'][] = $this->language->get('text_an_error');
								}
							} else {
								$json['common']['error'][] = $this->language->get('text_error_backup');
							}
						} else {
							$json['common']['info'][] = $this->language->get('text_file_already');
						}
					} else {
						$json['common']['error'][] = $this->language->get('text_file__not_found');
					}
				}

				if ($file_name == 'summernote') {
					if (is_file($target_file)) {
						$original_contents = file_get_contents($target_file);

						if (!stristr($original_contents, 'elfinder')) {
							$copy_operation = copy($target_file, $target_file . '_elfinder_backup');

							if ($copy_operation) {
								$json['summernote']['info'][] = $this->language->get('text_backup_created');

								$hook = "('#modal-image').remove();";
								$replacement = "if (typeof(dcElfinderSummernote) != 'undefined') {dcElfinderSummernote(element);return false;}";

								$modified_contents = str_replace($hook, $hook . "\n" . $replacement, $original_contents);

								if (file_put_contents($target_file, $modified_contents)) {
									$json['summernote']['success'][] = $this->language->get('text_file_success');
								} else {
									$json['summernote']['error'][] = $this->language->get('text_an_error');
								}
							} else {
								$json['summernote']['error'][] = $this->language->get('text_error_backup');
							}
						} else {
							$json['summernote']['info'][] = $this->language->get('text_file_already');
						}
					} else {
						$json['summernote']['error'][] = $this->language->get('text_file__not_found');
					}
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function adminMenu($route = '', &$data = array(), $output = '') {
		if ($this->user->hasPermission('access', 'extension/module/digitcart_elfinder')) {
			$this->load->language('extension/module/digitcart_elfinder');

			$data['menus'][] = array(
				'id'       => 'menu-elfinder',
				'icon'	   => 'fa-image',
				'name'	   => $this->language->get('heading_menu'),
				'href'     => $this->url->link('extension/module/digitcart_elfinder', 'user_token=' . $this->session->data['user_token'], true),
				'children' => array()
			);
		}
	}

	public function install() {
		$this->load->model('setting/event');

		$this->model_setting_event->deleteEventByCode('digitcart_elfinder');

        $this->model_setting_event->addEvent('digitcart_elfinder', 'admin/view/common/column_left/before', 'extension/module/digitcart_elfinder/adminMenu');

		$this->model_setting_event->addEvent('digitcart_elfinder', 'admin/controller/common/header/after', 'extension/module/digitcart_elfinder/afterHeader');

		$this->model_setting_event->addEvent('digitcart_elfinder', 'admin/view/catalog/product_form/after', 'extension/module/digitcart_elfinder/productForm');

		$folder = DIR_IMAGE . 'catalog/.trash/';

		if (!is_dir($folder)) {
			mkdir($folder);
		}
	}

	public function uninstall() {
		$this->load->model('setting/event');

		$this->model_setting_event->deleteEventByCode('digitcart_elfinder');
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/digitcart_elfinder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}