<?php

class Webrtc extends MX_Controller{

	public function index()
	{
		$this->load->view($this->config->item('webrtc') . '/index', []);
	}

	public function rtc()
	{
                // set header response
                $this->output->set_header('HTTP/1.0 200 OK');
                $this->output->set_header('HTTP/1.1 200 OK');
                $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
                $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
                $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
                $this->output->set_header('Pragma: no-cache');
                // send result alongside with headers
                $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
                exit();
	}
}