<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Video_model');
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$this->load->library('cacheman');
	}

	private function _index($page,$no_print) {
		$cache_id = 'index.'.$page;
		if ($video_result = $this->cache->get($cache_id)) {
		}
		else {
			$video_result = $this->Video_model->all_videos($page-1);
			$this->cache->save($cache_id, $video_result,43200);
		}
		return $this->load->view('video/search',array(
			'datas'=>$video_result,
			'current_page'=>$page,
		),$no_print);
	}

	public function index() {
		$this->load->view('layout',array(
			'body'=>$this->_index(1,true),
			'jsmethod'=>'search',
			'ismobile'=>$this->agent->is_mobile()
		));
	}

	public function index_ajax($page=1) {
		$this->_index($page,false);
	}

	private function _rank($page,$no_print) {
		$cache_id = 'rank.'.$page;
		if ($rank_result = $this->cache->get($cache_id)) {
		}
		else {
			$rank_result = $this->Video_model->get_rank($page-1);
			$this->cache->save($cache_id, $rank_result,43200);
		}
		return $this->load->view('video/search',array(
			'datas'=>$rank_result,
			'current_page'=>$page,
		),$no_print);
	}

	public function rank($page=1) {
		$this->load->view('layout',array(
			'body'=>$this->_rank($page,true),
			'jsmethod'=>'search',
			'ismobile'=>$this->agent->is_mobile()
		));
	}

	public function rank_ajax($page=1) {
		$this->_rank($page,false);
	}

	public function id($id) {
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
			'ismobile'=>$this->agent->is_mobile()
			)
		);
	}

	public function _search_tag($query,$page,$no_print) {
		$query = urldecode($query);
		$cache_id = 'search_tag.'.$query.'.'.$page;
		if ($search_result = $this->cache->get($cache_id)) {
		}
		else {
			$search_result = $this->Video_model->search_tag($query,$page-1);
			$this->cache->save($cache_id, $search_result,86400);
		}
		return $this->load->view('video/search',array(
			'datas'=>$search_result,
			'current_page'=>$page,
			'query'=>$query
		),$no_print);
	}

	public function search_tag($query,$page=1) {
		$this->load->view('layout',array(
			'body'=>
				$this->_search_tag($query,$page,true),
			'jsmethod'=>'search',
			'title'=>$query,
			'ismobile'=>$this->agent->is_mobile()
		));
	}

	public function search_tag_ajax($query,$page=1) {
		$this->_search_tag($query,$page,false);
	}

	public function delete_tag() {
		$tag = $this->input->post('tag');
		$this->cacheman->delete_entry('search_tag.'.$tag);
		$result = $this->Video_model->delete_tag($this->input->post('video_id'),$tag);
		echo $result ? 'ok' : 'fail';
	}

	public function add_tag() {
		$tag = $this->input->post('tag');
		$this->cacheman->delete_entry('search_tag.'.$tag);
		$result = $this->Video_model->add_tag($this->input->post('video_id'),$tag);
		echo $result ? 'ok' : 'fail';
	}

}
