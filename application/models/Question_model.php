<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model
{

    /**
     * Get question
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function get_next_question()
    {
        if($this->session->has_userdata('question_id')) {
            $exam_id = $this->session->userdata('exam_id');
            $question_id = $this->session->userdata('question_id');
            $whereCondition = [
                'exam_id' => $exam_id,
                'id >' => $question_id,
            ];
        } else {
            $exam_id = $this->session->userdata('exam_id');
            $whereCondition = ['exam_id' => $exam_id];
        }

        $query = $this->db->select('id, question, codes, option1, option2, option3, option4, answer')
            ->limit(1)
            ->order_by('created_at ASC')
            ->get_where('questions', $whereCondition);

        if($query->num_rows()) {
            $question = $query->row_array();

            $this->session->set_userdata('question_id', $question['id']);


            return $question;
        }

        return false;
    }

    /**
     * Get count of questions in an exam
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return string
     */
    public function get_question_count($exam_id)
    {
        $this->db->get_where('questions', array('exam_id' => $exam_id));
        return $this->db->count_all_results();
    }

    /**
     * Get all questions
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function get_all_questions($exam_id)
    {
        $this->db->select('id, question, codes, option1, option2, option3, option4, answer');
        $query = $this->db->get_where('questions', array('exam_id' => $exam_id));
        return $query->result_array();
    }
}
