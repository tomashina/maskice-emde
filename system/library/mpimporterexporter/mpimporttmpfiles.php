<?php
namespace MpImporterExporter;
class MpImportTmpFiles {
	/**
	 * Manage .json files creation, deletion at particular location i.e: inside storage folder
	 *
	 *
	 */
	const FORMAT = ".json";
	const MAX_RECORDS = 1000;
	const TMP_DIR = 'mpoints_tmp_impexp/';

	// i.e: category_import, product_import, etc
	private $action;
	private $handle;
	private $handles = [];
	private $data = [];
	private $filename;
	private $path;

	public function open($action) {
		$this->mkDir(DIR_CACHE . self :: TMP_DIR);

		// explode action to detect if it having path
		$parts = explode("/", $action);
		$p = '';
		foreach ($parts as $key => $value) {
			$p .= $value .'/';
			$this->mkDir(DIR_CACHE . self :: TMP_DIR . $p);
		}
		// $this->mkDir(DIR_CACHE . self :: TMP_DIR . $action . '/');
		$this->path = DIR_CACHE . self :: TMP_DIR . $action . '/';
		$this->action = end($parts);
		$this->fopen();
	}

	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	private function fopen($i='') {
		$this->filename = "tmp." . $this->action . $i . self :: FORMAT;
		$this->handle = fopen($this->path . $this->filename, 'w');
		$this->handles[] = $this->handle;
	}

	public function save() {
		// check length of data array, as soon as reach 1000 save into file.
		// https://www.php.net/manual/en/function.array-chunk.php
		$chunks = array_chunk($this->data, self :: MAX_RECORDS, true);
		foreach ($chunks as $k => $chunk) {
			if ($k > 0) {
				$this->fopen($k);
			}
			$this->write($chunk);
		}

		$this->data = [];
	}

	private function write($m) {
		// fwrite($this->handle, json_encode($m, JSON_PRETTY_PRINT));
		fwrite($this->handle, json_encode($m));
	}

	public function close() {
		foreach ($this->handles as $h) {
			fclose($h);
		}
		// delete all tmp files and delete directory
		$action = str_replace(DIR_CACHE . self :: TMP_DIR, '', $this->path);


	}

	public function getFiles() {
		$files = [];
		$dirs = scandir($this->path);

		foreach ($dirs as $dir) {
			if (in_array($dir, ['.','..'])) {
				continue;
			}
			$files[] = $dir;
		}
		return $files;
	}



	public function get($key) {
		$return = null;
		$dirs = scandir($this->path);

		foreach ($dirs as $dir) {
			if (in_array($dir, ['.','..'])) {
				continue;
			}
			$content = $this->getContent($dir);
			if (isset($content[$key])) {
				$return = $content[$key];
				break;
			}
		}
		return $return;
	}


	public function getContent($filename) {
		$content = [];

		if (file_exists($this->path . $filename)) {

			$size = filesize($this->path . $filename);
			if ($size) {
				$data = file_get_contents($this->path . $filename, FILE_USE_INCLUDE_PATH, null);
				$content = json_decode($data, 1);

			}
		}

		return $content;
	}

	protected function mkDir($dir,$permission=0777) {
		if(!is_dir($dir)) {
			$oldmask = umask(0);
			mkdir($dir, $permission);
			umask($oldmask);
		}
	}

}