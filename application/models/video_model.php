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

	public function all_videos($page) {
		$res = $this->db->query(
			'SELECT * FROM xvideos x
			ORDER BY x.id DESC
			LIMIT 61 OFFSET ?'
		,array(60*$page));
		return $res->result();
	}

	public function search_tag($query,$page) {
		$res = $this->db->query(
			'SELECT * FROM xvideos x
			INNER JOIN xvideos_tag xt
			ON x.id=xt.xvideos_id WHERE xt.tag=?
			ORDER BY x.id DESC
			LIMIT 61 OFFSET ?'
		,array($query,60*$page));
		return $res->result();
	}

	public function delete_tag($vid,$tag) {
		$res = $this->db->query(
			'DELETE FROM xvideos_tag WHERE xvideos_id=? AND tag=?'
		,array($vid,$tag));
		return $res;
	}

	public function add_tag($vid,$tag) {
		$res = $this->db->query(
			'INSERT INTO xvideos_tag (xvideos_id,tag,is_usertag) VALUE (?,?,1)'
		,array($vid,$tag));
		return $res;
	}

	public function get_rank($page) {
		$res = $this->db->query(
			'SELECT * FROM xvideos x
			INNER JOIN xvideos_scores xs
			ON x.id=xs.xvideos_id
			ORDER BY xs.score DESC
			LIMIT 61 OFFSET ?'
		,array(60*$page));
		return $res->result();
	}

}
