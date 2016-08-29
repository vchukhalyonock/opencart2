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

		$allVideos = $this->model_video_channel
			->getAllVideos(
				$data['group_id'],
				$data['search_string'],
				$data['select_status'],
				$data['order'],
				$startVideo,
				$this->config->get('config_limit_admin')
				);

		foreach ($allVideos['result'] as $video) {
			
			$data['videos']['result'][] = array_merge($video, 
				array(
					'edit' => $this->url->link('video/video/edit', 'token=' . $this->session->data['token'] . '&video_id=' . $video['id'] . $url, true)
				)
			);
		}

		$data['videos']['total'] = $allVideos['total'];

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('video/video', $data));
	}


	public function add() {
		$this->load->language('video/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('video/channel');


		$this->getVideoForm();
	}


	public function edit() {
		$this->load->language('video/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('video/channel');


		$this->getVideoForm();
	}



	public function getVideoForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['video_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_customer_link'] = $this->language->get('entry_customer_link');
		$data['entry_channel_link'] = $this->language->get('entry_channel_link');
		$data['entry_featured'] = $this->language->get('entry_featured');

		$data['status_new'] = $this->language->get('status_new');
		$data['status_download'] = $this->language->get('status_download');
		$data['status_downloaded'] = $this->language->get('status_downloaded');
		$data['status_upload'] = $this->language->get('status_upload');
		$data['status_not_ready'] = $this->language->get('status_uploaded');
		$data['status_ready'] = $this->language->get('status_ready');
		$data['status_error_upload'] = $this->language->get('status_error_upload');
		$data['status_error_download'] = $this->language->get('status_error_download');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_get_content'] = $this->language->get('button_get_content');

		$data['token'] = $this->session->data['token'];

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('video/video', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['form_id'])) {
			$data['action'] = $this->url->link('video/video/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] =
				$this->url->link(
					'video/video/edit',
					'token=' . $this->session->data['token'] . '&video_id=' . $this->request->get['video_id'] . $url,
					true);
		}

		$data['cancel'] = $this->url->link('video/video', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['video_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$video = $this->model_video_channel->getVideo($this->request->get['video_id']);
		}


		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($video)) {
			$data['name'] = $video['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['decription'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (!empty($video)) {
			$data['description'] = $video['description'];
		} else {
			$data['description'] = '';
		}

		if (isset($this->request->post['customer_link'])) {
			$data['customer_link'] = $this->request->post['customer_link'];
		} elseif (!empty($video)) {
			$data['customer_link'] = $video['customerLink'];
		} else {
			$data['customer_link'] = '';
		}

		if (isset($this->request->post['channel_link'])) {
			$data['channel_link'] = $this->request->post['channel_link'];
		} elseif (!empty($video)) {
			$data['channel_link'] = $video['channelLink'];
		} else {
			$data['channel_link'] = '';
		}

		if (isset($this->request->post['featured'])) {
			$data['featured'] = $this->request->post['featured'];
		} elseif (!empty($video)) {
			$data['featured'] = $video['featured'];
		} else {
			$data['featured'] = 0;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('video/video_form', $data));
	}


	public function getYoutubeContent() {
		if(isset($this->request->get['video_id'])) {
			$videoId = $this->request->get['video_id'];
			$content = getYoutubeVideoInfoContent(strval($videoId));

			if(empty($content)) {
				$this->response->setOutput(jsno_encode(
					array(
						'result' => false
						)
					)
				);
			}
			elseif(($conts = json_decode($content)) == false) {
				$this->response->setOutput(jsno_encode(
					array(
						'result' => false
						)
					)
				);
			}
			else {
				$this->response->setOutput(json_encode(
					array(
						'result' => true,
						'name' => $conts->items[0]->snippet->title,
						'description' => $conts->items[0]->snippet->description
						)
					)
				);
			}
		}
		else {
			$this->response->setOutput(json_encode(array('result' => false)));
		}
	}
}
?>