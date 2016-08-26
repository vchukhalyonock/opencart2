<?php
class ControllerVideoVideo extends Controller {

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

		$page = isset($this->request->get['page'])
			? $this->request->get['page']
			: 0;

		$startVideo = $page * ITEMS_ON_PAGE;

		$data['order'] = isset($this->request->get['order'])
			? $this->request->get['order']
			: ORDER_BY_ID | ORDER_ASC;

		$data['group_id'] = isset($this->request->get['group_id'])
			? $this->request->get['groupId']
			: null;

		$url = '&page=' . $page;

		if(isset($data['select_status'])) {
			$url .= "&select_status=" . $data['select_status'];
		}

		if(isset($data['search_string'])) {
			$url .= "&search_string=" . $data['search_string'];
		}

		if(isset($data['order'])) {
			$url .= "&order=" . $data['order'];
		}

		if(isset($data['groupId'])) {
			$url .= "&group_id=" . $data['group_id'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('video/video', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('video/video/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('video/video/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['videos'] = $this->model_video_channel
			->getAllVideos(
				$data['group_id'],
				$data['search_string'],
				$data['select_status'],
				$data['order'],
				$startVideo,
				ITEMS_ON_PAGE
				);

		$pagination = new Pagination();
		$pagination->total = $data['videos']['total'];
		$pagination->page = $page;
		$pagination->limit = ITEMS_ON_PAGE;
		$pagination->url = $this->url->link('video/video', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('video/video', $data));
	}
}
?>