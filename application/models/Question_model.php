<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model
{
    public function getNextQuestion() {
        if($this->session->has_userdata('question_id')) {
            $exam_id = $this->session->userdata('exam_id');
            $question_id = $this->session->userdata('question_id');
            $whereCondition = [
                'exam_id' => $exam_id,
                'id >' => $question_id
            ];
        } else {
            $exam_id = $this->session->userdata('exam_id');
            $whereCondition = ['exam_id' => $exam_id];
        }

        $result = $this->db->select('id, question, option1, option2, option3, option4, answer')
            ->limit(1)
            ->order_by('created_at ASC')
            ->get_where('questions', $whereCondition);

        if($result->num_rows()) {
            $question = $result->row_array();

            $this->session->set_userdata('question_id', $question['id']);
            return $question;
        }

        return false;
    }

    public function getQuestionCount($exam_id) {
        $this->db->get_where('questions', array('exam_id' => $exam_id));
        return $this->db->count_all_results();
    }

}
