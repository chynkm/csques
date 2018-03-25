<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends CI_Model
{

    /**
     * Get subject listing with slug as key
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function get_subject_slug_list()
    {
        $query = $this->db->select('slug, subject')
            ->from('subjects')
            ->order_by('subject ASC')
            ->get();

        $data = [];

        foreach ($query->result() as $row) {
            $data[$row->slug] = $row->subject;
        }

        return $data;
    }

    /**
     * Get exam listing
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function get_exam_list($subject_slug = null)
    {
        $this->db->select('e.id, paper, subject, month, year')
            ->from('exams e')
            ->join('subjects s', 's.id = subject_id');

        if($subject_slug) {
            $this->db->where('s.slug', $subject_slug);
        }

        $query = $this->db->order_by('subject ASC, year DESC, month ASC')->get();

        $data = [];

        foreach ($query->result() as $row) {
            $data[$row->id] = $row->subject.' Paper '.$row->paper.' '.ucfirst($row->month).' '.$row->year;
        }

        return $data;
    }

}
