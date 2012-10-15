<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

	public function id($id) {
		$this->load->model('Video_model');
		$this->load->library('user_agent');
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/id',array(
					'datas'=>$this->Video_model->show($id),
					'ismobile'=>$this->agent->is_mobile()
				),TRUE),
			'jsmethod'=>'video',
			)
		);
	}

	public function search_tag($query,$page=1) {
		$this->load->model('Video_model');
		$this->load->view('layout',array(
			'body'=>
				$this->load->view('video/search',array(
					'datas'=>$this->Video_model->search_tag($query,$page-1),
					'current_page'=>$page,
					'query'=>$query
				),TRUE),
			'jsmethod'=>'search'
		));
	}

	public function search_tag_ajax($query,$page) {
		$this->load->model('Video_model');
		$this->load->view('video/search',array(
			'datas'=>$this->Video_model->search_tag($query,$page-1),
			'current_page'=>$page,
			'query'=>$query
		));
	}

}
