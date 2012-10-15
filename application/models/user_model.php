<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
	}

	public function create_user() {
		$res = $this->db->query(
			'INSERT INTO users (registered) VALUES (?)'
		,array(time()));
		return $this->db->insert_id();
	}

	public function check_user($uid) {
		$res = $this->db->query(
			'SELECT * FROM users WHERE id=?'
		,array($uid));
		return $res->num_rows();
	}

	public function create_history($uid,$video_id,$duration) {
		$res = $this->db->query(
			'SELECT duration FROM xvideos WHERE id=?'
		,array($video_id));
		$res_row = $res->row();

		$res = $this->db->query(
			'SELECT svd_ratio FROM user_history WHERE user_id=? AND xvideos_id=?'
		,array($uid,$video_id));
		$svd_ratio_old = 0;
		if ($res->num_rows() > 0) {
			$res_row = $res->row();
			$svd_ratio_old = $res_row->svd_ratio;
		}
	
		$svd_ratio = ($duration / $res_row->duration) + $svd_ratio_old;

		$res = $this->db->query(
			'INSERT INTO user_history (user_id,xvideos_id,svd_ratio) VALUES (?,?,?)'
		,array($uid,$video_id,$svd_ratio));
	}

}

