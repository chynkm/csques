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
     * @param  string $subject_slug
     *
     * @return array|bool
     */
    public function get_exam_list($subject_slug)
    {
        $this->db->select('p.slug, paper, subject, month, year')
            ->where('s.slug', $subject_slug)
            ->from('papers p')
            ->join('subjects s', 's.id = subject_id');

        $query = $this->db->order_by('subject ASC, year DESC, month ASC')->get();

        if($query->num_rows()) {
            $data = [];
            foreach ($query->result() as $row) {
                $data[$row->slug] = $row->subject.' Paper '.$row->paper.' '.ucfirst($row->month).' '.$row->year;
            }
            return $data;
        }

        return false;
    }

}
