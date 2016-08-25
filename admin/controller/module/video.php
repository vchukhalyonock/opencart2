<?php
class ControllerModuleVideo extends Controller {

	public function index() {
		$this->load->language('module/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('video/channel');

		$this->getVideosList();
	}


	public function getVideosList() {
		$data['select_status'] = isset($this->request->get['select_status'])
			? $this->request->get['select_status']
			: null;

		$data['search_string'] = isset($this->request->get['search_string'])
			? $this->request->get['search_string']
			: null;

		$data['page'] = isset($this->request->get['page'])
			? $this->request->get['page']
			: 0;

		$startVideo = $page * ITEMS_ON_PAGE;

		$data['order'] = isset($this->request->get['order'])
			? $this->request->get['order']
			: ORDER_BY_ID | ORDER_ASC;

		$data['groupId'] = isset($this->request->get['group_id'])
			? $this->request->get['groupId']
			: null;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/video', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('module/video/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('module/video/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['videos'] = $this->model_video_channel
			->getAllVideos(
				$groupId,
				$search_string,
				$select_status,
				$order,
				$startVideo,
				ITEMS_ON_PAGE
				);


	}
}
?>