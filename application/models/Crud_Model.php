<?php

class Crud_Model extends CI_Model
{
    protected $table = null;
    protected $primary_key = null;

    // -----------------------------------------------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param null $id
     * @param null $order_by
     * @usage
     * All: $this->User_model->get();
     * Single: $this->User_model->get(2);
     * Custom: $this->User_model->get(['age' => 32, 'gender' => 'male']);
     */
    public function get($id = null, $order_by = null)
    {
       if ( is_numeric($id) ) {
            $this->db->where($this->primary_key, $id);
       }
        if ( is_array($id) ) {
            foreach ($id as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ( $order_by != null ) {
            $this->db->order_by($order_by);
        }
        $q = $this->db->get($this->table);
        return $q->result();
    }

    // -----------------------------------------------------------------------------------------------------------------
    /**
     * @param $data
     * @usage:
     * $this->User_model->insert($data)
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // -----------------------------------------------------------------------------------------------------------------
    /**
     * @param $where
     * @param $new_data
     * @usage
     * $this->User_model->uupdate(['login' => 'new_login', 'passw' => 'newpass'], 3)
     * $this->User_model->uupdate(['login' => 'new_login'],  ['passw' => 'newpass'], 3)
     */
    public function update($new_data, $where)
    {
        if ( is_numeric($where) ) {
            $this->db->where($this->primary_key, $where);
        } else if ( is_array($where) ) {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
        } else {
            die("You must pass parameter to update mehtod");
        }
        $this->db->update($this->table, $new_data);
        return $this->db->affected_rows();
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param $data
     * @param bool|false $id
     * @return mixed
     * @usage insertUpdate(['name' => 'mohamed'], 12)
     */
    public function insertUpdate($data, $id = false)
    {
        if ( !$id ) {
            die("You must pass id parameter to insertUpdate() method.");
        }
        $this->db->select($this->primary_key);
        $this->db->where($this->primary_key, $id);
        $q = $this->db->get($this->table);
        $result = $q->num_rows();

        if ( $result == 0 ) {
            // Insert
            return $this->insert($data);
        }
        // Update
        return $this->update($data, $id);
    }

    // -----------------------------------------------------------------------------------------------------------------

    public function delete($id)
    {
        if ( is_numeric($id) ) {
            $this->db->where($this->primary_key, $id);
        }
        elseif ( is_array($id) ) {
            foreach ($id as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        else {
            die("You must pass id parameter to delete() method");
        }
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
}