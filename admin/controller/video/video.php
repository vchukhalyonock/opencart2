<?php
class ControllerVideoVideo extends Controller {

	public function index() {
		$this->load->language('video/video');

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
			: 1;

		$startVideo = ($page - 1) * $this->config->get('config_limit_admin');

		$data['order'] = isset($this->request->get['order'])
			? $this->request->get['order']
			: ORDER_BY_ID | ORDER_ASC;

		$data['group_id'] = isset($this->request->get['group_id'])
			? $this->request->get['groupId']
			: null;

		$url = '';

		if(isset($data['select_status'])) {
			$url .= "&select_status=" . $data['select_status'];
		}

		if(isset($data['search_string'])) {
			$url .= "&search_string=" . $data['search_string'];
		}

		if(isset($data['groupId'])) {
			$url .= "&group_id=" . $data['group_id'];
		}

		$data['order_id'] = $this->url->link('video/video', 'token=' . $this->session->data['token'] . '&order=' . ORDER_BY_ID . $url, true);
		$data['order_email'] = $this->url->link('video/video', 'token=' . $this->session->data['token'] . '&order=' . ORDER_BY_EMAIL . $url, true);
		$data['order_name'] = $this->url->link('video/video', 'token=' . $this->session->data['token'] . '&order=' . ORDER_BY_NAME . $url, true);
		$data['order_featured'] = $this->url->link('video/video', 'token=' . $this->session->data['token'] . '&order=' . (ORDER_BY_FEATURED | ORDER_DESC) . $url, true);
		$data['order_status'] = $this->url->link('video/video', 'token=' . $this->session->data['token'] . '&order=' . ORDER_BY_STATUS . $url, true);

		$url = '';

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
				$this->config->get('config_limit_admin')
				);

		$pagination = new Pagination();
		$pagination->total = $data['videos']['total'];
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('video/video', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] =
			sprintf(
				$this->language->get('text_pagination'),
				($data['videos']['total'])
					? (($page - 1) * $this->config->get('config_limit_admin')) + 1
					: 0,
				((($page - 1) * $this->config->get('config_limit_admin')) > ($data['videos']['total'] - $this->config->get('config_limit_admin')))
					? $data['videos']['total']
					: ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')),
					$data['videos']['total'], ceil($data['videos']['total'] / $this->config->get('config_limit_admin'))
			);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_login'] = $this->language->get('button_login');
		$data['button_unlock'] = $this->language->get('button_unlock');

		$data['text_list'] = $this->language->get('text_list');

		$data['column_id'] = $this->language->get('column_id');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_featured'] = $this->language->get('column_featured');
		$data['column_customer_link'] = $this->language->get('column_customer_link');
		$data['column_channel_id'] = $this->language->get('column_channel_id');
		$data['column_actions'] = $this->language->get('column_actions');

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('video/video', $data));
	}
}
?>