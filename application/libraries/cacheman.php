<?php

class Cacheman {

	public function __construct() {
		$this->CI =& get_instance();
	}

	public function delete_entry($needle) {
	//	$this->CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$cache_entries = $this->CI->cache->cache_info();
		foreach ($cache_entries['cache_list'] as $cache_list) {
			$result = strpos($cache_list['info'],$needle);
			if ($result !== FALSE) {
				$this->CI->cache->delete($cache_list['info']);
			}
		}
	}

	public function show_entry() {
	//	$this->CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		echo '<pre>';
		print_r($this->CI->cache->cache_info());
		echo '</pre>';
	}

}
