<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}

	public function id($id) {
		$this->load->model('Video_model');
		$this->load->library('user_agent');
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/id',array(
					'datas'=>$this->Video_model->show($id),
					'ismobile'=>$this->agent->is_mobile(),
					'isadmin'=>$this->session->userdata('is_admin')
				),TRUE),
			'jsmethod'=>'video',
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
			$this->cache->save($cache_id, $search_result,86400);
		}
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/search',array(
					'datas'=>$search_result,
					'current_page'=>$page,
					'query'=>$query
				),TRUE),
			'jsmethod'=>'search'
		));
	}

	public function search_tag_ajax($query,$page) {
		$this->load->model('Video_model');
		$cache_id = 'search_tag.'.$query.'.'.$page;
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->search_tag($query,$page-1);
			$this->cache->save($cache_id, $search_result,86400);
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
