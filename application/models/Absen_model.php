<?php

class Absen_model extends CI_Model
{
   
    public function getShift()
    {
         return $this->db->get('ref_parameter_shift')->result_array();
    }

    public function getAbsen()
    {
    //     $query = $this->db->query("select * from `tbl_user`");
    //    return $query->result_array();
        return $this->db->get('data_absen')->result_array();
    }

    public function createAbsen($data)
    {
        $this->db->insert('data_absen', $data);
        return $this->db->affected_rows();
    }

    
}