<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Top_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}

	public function get_new_videos($region_tags) {
		$sql_where = ' ';
		foreach ($region_tags as $region_tag) {
			$sql_where .= '\'' . $region_tag . '\' OR ';
		}
		$sql_where = substr($sql_where,0,-4);
		$res = $this->db->query(
			'SELECT * FROM xvideos x
			INNER JOIN xvideos_tag xt
			ON x.id=xt.xvideos_id WHERE xt.tag='.$sql_where.'
			ORDER BY x.id DESC
			LIMIT 5'
		,array());
		return $res->result();
	}

	public function get_highly_rated() {
		$res = $this->db->query(
			'SELECT * FROM xvideos x
			INNER JOIN xvideos_scores xs
			ON x.id=xs.xvideos_id
			ORDER BY xs.score DESC
			LIMIT 5'
		,array());
		return $res->result();
	}

}
