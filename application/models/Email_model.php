<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model
{
    private $_batchImport;

    public function setBatchImport($batchImport)
    {
        $this->_batchImport = $batchImport;
    }

    //save data
    public function importData()
    {
        $data = $this->_batchImport;
        $this->db->insert_batch('emails', $data);
    }

    public function getIdByEmail($email)
    {
        $this->db->select('id');
        $this->db->from('import');
        $this->db->where('email', $email);
        return $query = $this->db->get()->result_array();
    }

    public function emails_sent($id, $limit = FALSE, $offset = FALSE)
    {

        if ($limit){
            $this->db->limit($limit, $offset);
        }

        $this->db->select('e.subject, e.content, e.date, i.email');
        $this->db->from('emails as e');
        $this->db->where('sender_id', $id);
        $this->db->join('import as i', 'e.recipient_id = i.id');
        $this->db->order_by('e.date', 'desc');
        return $query = $this->db->get()->result_array();
    }

    // count rows with specific id in them
    public function rows_count($id){
        $this->db->select();
        $this->db->from('emails');
        $this->db->where('sender_id', $id);
        return $query = $this->db->get()->num_rows();
    }
}