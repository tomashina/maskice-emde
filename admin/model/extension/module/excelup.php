<?php
/*
 * Excelup OpenCart Extension by OpencartBot
 * https://opencartbot.com/en/excelup
 * Released under CC BY-ND 3.0 license
 */

class ModelExtensionModuleExcelup extends Model {

	public function getProductId($field, $value) {
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE " . $this->db->escape($field) . " = '" . $this->db->escape($value) . "'");
		if ($query->num_rows) {
			return $query->row['product_id'];
		} else {
			return 0;
		}
	}

	public function updateProduct($product_id, $price, $special, $quantity) {
		$values = '';
		if ($price !== false) {
			$values .= "price = '" . (float)$price . "',";
		}
		if (is_numeric($quantity)) {
			$values .= " quantity = '" . (int)$quantity . "',";
		}
		if ($quantity > 0) {
			$values .= " status = '1',";
		}
		$values = trim($values, ',');
		
		if ($values) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET " . $values . " WHERE product_id = '" . (int)$product_id . "'");
		}

		if ($special === 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		} elseif ($special !== false) {
			$query_special = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
			if ($query_special->num_rows) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_special SET price = '" . (float)$special . "' WHERE product_id = '" . (int)$product_id . "'");
			} elseif ($this->config->get('module_excelup_special_new')) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '1', priority = '1', price = '" . (float)$special . "', date_start = '0000-00-00', date_end = '0000-00-00'");
			}
		}
	}

}