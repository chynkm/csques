<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends CI_Model
{

    public function getSubjects()
    {
        $query = $this->db->select('id, subject')
            ->from('subjects')
            ->order_by('subject ASC')
            ->get();

        $data = [];

        foreach ($query->result() as $row) {
            $data[$row->id] = $row->subject;
        }

        return $data;
    }

    public function getExamList($subject_id = null)
    {
        $this->db->select('e.id, paper, subject, month, year')
            ->from('exams e')
            ->join('subjects s', 's.id = subject_id');

        if($subject_id) {
            $this->db->where('s.id', $subject_id);
        }

        $query = $this->db->order_by('subject ASC, year DESC, month ASC')->get();

        $data = [];

        foreach ($query->result() as $row) {
            $data[$row->id] = $row->subject.' Paper '.$row->paper.' '.ucfirst($row->month).' '.$row->year;
        }

        return $data;
    }

}
