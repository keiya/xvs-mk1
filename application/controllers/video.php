<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}

	public function index() {
		$this->load->model('Video_model');
		$cache_id = 'index.1';
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->all_videos(0);
			$this->cache->save($cache_id, $search_result,43200);
		}
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/search',array(
					'datas'=>$search_result,
					'current_page'=>1,
				),TRUE),
			'jsmethod'=>'search',
		));
	}

	public function index_ajax($page) {
		$this->load->model('Video_model');
		$cache_id = 'index.'.$page;
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->all_videos($page-1);
			$this->cache->save($cache_id, $search_result,43200);
		}
		$this->load->view('video/search',array(
			'datas'=>$search_result,
			'current_page'=>$page,
		));
	}

	public function rank() {
		$this->load->model('Video_model');
		$cache_id = 'rank.1';
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->get_rank(0);
			$this->cache->save($cache_id, $search_result,43200);
		}
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/search',array(
					'datas'=>$search_result,
					'current_page'=>1,
				),TRUE),
			'jsmethod'=>'search',
		));
	}

	public function rank_ajax($page) {
		$this->load->model('Video_model');
		$cache_id = 'rank.'.$page;
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->get_rank($page-1);
			$this->cache->save($cache_id, $search_result,43200);
		}
		$this->load->view('video/search',array(
			'datas'=>$search_result,
			'current_page'=>$page,
		));
	}

	public function id($id) {
		$this->load->model('Video_model');
		$this->load->library('user_agent');
		$datas = $this->Video_model->show($id);
		//$datas[0]->embed_tag = preg_replace("/\"always\"/","\"never\"",$datas[0]->embed_tag);
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/id',array(
					'datas'=>$datas,
					'ismobile'=>$this->agent->is_mobile(),
					'isadmin'=>$this->session->userdata('is_admin')
				),TRUE),
			'jsmethod'=>'video',
			'title'=>$datas[0]->title,
			)
		);
	}

	public function search_tag($query,$page=1) {
		$query = urldecode($query);
		$this->load->model('Video_model');
		$cache_id = 'search_tag.'.$query.'.'.$page;
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->search_tag($query,$page-1);
			$this->cache->save($cache_id, $search_result,43200);
		}
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/search',array(
					'datas'=>$search_result,
					'current_page'=>$page,
					'query'=>$query
				),TRUE),
			'jsmethod'=>'search',
			'title'=>$query,
		));
	}

	public function search_tag_ajax($query,$page) {
		$this->load->model('Video_model');
		$cache_id = 'search_tag.'.$query.'.'.$page;
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->search_tag($query,$page-1);
			$this->cache->save($cache_id, $search_result,43200);
		}
		$this->load->view('video/search',array(
			'datas'=>$search_result,
			'current_page'=>$page,
			'query'=>$query
		));
	}

	public function delete_tag() {
		$this->load->model('Video_model');
		$result = $this->Video_model->delete_tag($this->input->post('video_id'),$this->input->post('tag'));
		echo $result ? 'ok' : 'fail';
	}

	public function add_tag() {
		$this->load->model('Video_model');
		$result = $this->Video_model->add_tag($this->input->post('video_id'),$this->input->post('tag'));
		echo $result ? 'ok' : 'fail';
	}

}
