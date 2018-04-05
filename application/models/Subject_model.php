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
            ->where('approved', 1)
            ->get();

        $data = [];

        foreach ($query->result() as $row) {
            $data[$row->slug] = $row->subject;
        }

        return $data;
    }

    /**
     * Get paper listing
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $subject_slug
     *
     * @return array|bool
     */
    public function get_paper_list($subject_slug)
    {
        $this->db->select('p.slug, p.paper, s.subject, p.month, p.year, count(q.id) question_count')
            ->where('s.slug', $subject_slug)
            ->where('p.approved', 1)
            ->from('papers p')
            ->join('questions q', 'p.id = paper_id')
            ->join('subjects s', 's.id = p.subject_id')
            ->group_by('p.id');

        $query = $this->db->order_by('subject ASC, year DESC, month ASC')->get();

        if($query->num_rows()) {
            $data = [];
            foreach ($query->result() as $row) {
                $paper_info = [
                    'slug' => $row->slug,
                    'name' => $row->subject.' Paper '.$row->paper.' '.ucfirst($row->month).' '.$row->year,
                    'question_count' => $row->question_count,
                ];
                $data[] = $paper_info;
            }
            return $data;
        }

        return false;
    }

    /**
     * Get subject from slug
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $subject_slug
     *
     * @return string|null
     */
    public function get_subject($subject_slug)
    {
        $query = $this->db->select('subject')->get_where('subjects', ['slug' => $subject_slug]);
        return $query->num_rows() ? $query->row()->subject : null;
    }

}
