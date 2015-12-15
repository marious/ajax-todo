<?php

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
    }

    public function index()
    {
        // Get all users
        $users = $this->User_Model->get();
        var_dump($users);
        $this->output->enable_profiler(true);
    }

    public function single()
    {
        // Get single user
        $user = $this->User_Model->get(['login' => 'mohamed']);
        var_dump($user);
    }

    public function add()
    {
        $data = [
            'login' => 'abdo',
            'email' => 'abdo@gmail.com',
            'password' => '123456'
        ];
        $add_user = $this->User_Model->insert($data);
        var_dump($add_user);
    }

    public function update()
    {
        $data = ['login' => 'omar'];
        $user_id = 3;
        $update = $this->User_Model->update($data, $user_id);
        var_dump($update);
        $this->output->enable_profiler(true);
    }

    public function delete()
    {
        $delete = $this->User_Model->delete(['login' => 'omar']);
        var_dump($delete);
        $this->output->enable_profiler(true);
    }
}