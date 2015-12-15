<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ( !$this->session->userdata('user_id') ) {
            $this->logout();
        }
    }

    public function index()
    {
        // View
        $data['main_content'] = 'dashboard/dashboard_view';
        $this->load->view('dashboard/inc/main', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('./');
    }
}