<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}

	public function show($id) {
		$res = $this->db->query(
			'SELECT * FROM xvideos x
			INNER JOIN xvideos_tag xt
			ON x.id=xt.xvideos_id WHERE id=?'
		,array($id));
		return $res->result();
	}

	public function search_tag($query,$page) {
		$res = $this->db->query(
			'SELECT * FROM xvideos x
			INNER JOIN xvideos_tag xt
			ON x.id=xt.xvideos_id WHERE xt.tag=?
			LIMIT 61 OFFSET ?'
		,array($query,60*$page));
		return $res->result();
	}

}
