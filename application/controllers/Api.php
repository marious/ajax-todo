<?php

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Todo_Model');
        $this->load->model('Note_Model');

    }

    // =================================================================================================================

    private function _required_login()
    {
        if ( !$this->session->userdata('user_id') ) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized']));
            return false;
        }
    }

    // =================================================================================================================

    public function login()
    {
        $this->output->set_content_type('application_json');

        $config = [
            [
                'field'  => 'login',
                'label' => 'Login name',
                'rules' => 'trim|required|min_length[3]|max_length[50]|alpha_numeric',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[5]'
            ],
        ];

        $this->form_validation->set_rules($config);

        if ( $this->form_validation->run() == false ) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return false;
        }

        $login = $this->input->post('login');
        $password = $this->input->post('password');

        if ( count($this->User_Model->get(['login' => $login])) ) {

            $user = $this->User_Model->get(['login' => $login])[0];

            if ( isset($user->password) && Make::Verify($password, $user->password) ) {

                $user_data = [
                    'user_id' => $user->user_id,
                    'login' => $login,
                ];

                $this->session->set_userdata($user_data);

                $this->output->set_output(json_encode(['result' => 1]));

            }
        }

        else {
            $this->output->set_output(json_encode(['result' => 0]));
        }
    }

    // =================================================================================================================

    public function register()
    {
        $this->output->set_content_type('application/json');

        $config = [
            [
                'field' => 'login',
                'label' => 'Login Name',
                'rules' => 'trim|required|min_length[2]|max_length[50]|is_unique[user.login]'
            ],
            [
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'trim|required|valid_email|is_unique[user.email]'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[5]|max_length[50]'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[password]'
            ],
        ];

        $this->form_validation->set_message('is_unique', 'The {field} field already exist please choose another one');
        $this->form_validation->set_rules($config);

        if ( $this->form_validation->run() == false ) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => $this->form_validation->error_array()]));
            return false;
        }

        $data = [
            'login'      => $this->input->post('login'),
            'email'      => $this->input->post('email'),
            'password'   => Make::Hash($this->input->post('password')),
            'date_added' => date('Y-m-d H:i:s'),
        ];

        $insert = $this->User_Model->insert($data);
        if ( $insert ) {
            $this->output->set_output(json_encode(['result' => 1]));
        } else {
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'The user not created']));
        }
    }

    // =================================================================================================================

    public function get_todo($id = null)
    {
        $this->_required_login();

        if ($id != null) {
            $result = $this->Todo_Model->get([
                'todo_id' => $id,
                'user_id' => $this->session->userdata('user_id'),
            ]);
        }
        else {
            $result = $this->Todo_Model->get([
                'user_id' => $this->session->userdata('user_id')
            ]);
        }

        $this->output->set_output(json_encode($result));
    }

    // =================================================================================================================

    public function create_todo()
    {
        $this->_required_login();

        $this->form_validation->set_rules('content', 'Content', 'trim|required|max_length[255]');
        if ( $this->form_validation->run() == false ) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => $this->form_validation->error_array()
            ]));
            return false;
        }

        $data = [
            'user_id' => $this->session->userdata('user_id'),
            'content' => $this->input->post('content'),
            'date_added' => date('Y-m-d H:i:s'),
        ];

        $result = $this->Todo_Model->insert($data);
        if ( $result ) {

            $this->output->set_output(json_encode([
                'result' => 1,
                'data' => array(
                    'todo_id' => $result,
                    'content' => $data['content'],
                    'complete' => 0
                )
            ]));
            return false;
        }

        $this->output->set_output(json_encode([
            'result' => 0,
            'error' => 'Could not insert record',
        ]));
    }

    // =================================================================================================================

    public function update_todo()
    {
        $this->_required_login();
        $todo_id = $this->input->post('todo_id');
        $completed = $this->input->post('completed');

        $result = $this->Todo_Model->update([
            'completed' => $completed,
            'date_modified' => date('Y-m-d H:i:s')
        ], $todo_id);

        if ($result) {
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }

        $this->output->set_output(json_encode(['result' => 0]));
        return false;
    }

    // =================================================================================================================

    public function delete_todo()
    {
        $this->_required_login();
        $todo_id = $this->input->post('todo_id');

        $result = $this->Todo_Model->delete(['todo_id' => $todo_id]);
        if ( $result ) {
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }
        $this->output->set_output(json_encode(['result' => 0, 'msg' => 'Could not delete']));
        return false;

    }

    // =================================================================================================================

    public function create_note()
    {
        $this->_required_login();

        $this->form_validation->set_rules('title', 'Content', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('content', 'Content', 'trim|required|max_length[255]');
        if ( $this->form_validation->run() == false ) {
            $this->output->set_output(json_encode([
                'result' => 0,
                'error' => $this->form_validation->error_array()
            ]));
            return false;
        }

        $data = [
            'user_id' => $this->session->userdata('user_id'),
            'content' => $this->input->post('content'),
            'title' => $this->input->post('title'),
            'date_added' => date('Y-m-d H:i:s'),
        ];

        $result = $this->Note_Model->insert($data);
        if ( $result ) {

            $this->output->set_output(json_encode([
                'result' => 1,
                'data' => array(
                    'note_id' => $result,
                    'title' => $data['title'],
                    'content' => $data['content'],
                )
            ]));
            return false;
        }

        $this->output->set_output(json_encode([
            'result' => 0,
            'error' => 'Could not insert record',
        ]));
    }

    // =================================================================================================================


    public function get_note($id = null)
    {
        $this->_required_login();

        if ($id != null) {
            $result = $this->Note_Model->get([
                'note_id' => $id,
                'user_id' => $this->session->userdata('user_id'),
            ]);
        }
        else {
            $result = $this->Note_Model->get([
                'user_id' => $this->session->userdata('user_id')
            ]);
        }

        $this->output->set_output(json_encode($result));
    }

    // =================================================================================================================

    public function update_note()
    {
        $this->_required_login();

        $note_id = $this->input->post('note_id');


         $this->Note_Model->update([
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'date_modified' => date('Y-m-d H:i:s')
        ], $note_id);


        $this->output->set_output(json_encode(['result' => 1]));
        return false;
    }

    // =================================================================================================================

    public function delete_note()
    {
        $this->_required_login();

        $this->_required_login();
        $note_id = $this->input->post('note_id');

        $result = $this->Note_Model->delete(['note_id' => $note_id]);
        if ( $result ) {
            $this->output->set_output(json_encode(['result' => 1]));
            return false;
        }
        $this->output->set_output(json_encode(['result' => 0, 'msg' => 'Could not delete']));
        return false;
    }
}