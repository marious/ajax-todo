<?php

class Home extends CI_Controller
{
    public function index()
    {
        // View
        $data['main_content'] = 'home/home_view';
        $this->load->view('home/inc/main', $data);
    }

    public function register()
    {
        // View
        $data['main_content'] = 'home/register_view';
        $this->load->view('home/inc/main', $data);
    }
}