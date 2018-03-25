<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model
{

    /**
     * Get question
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array|boolean
     */
    public function get_next_question()
    {
        if($this->input->post()) {
            if($this->input->post('answer')) {
                $this->db->update('question_trial_paper',
                    ['user_answer' => $this->input->post('answer')],
                    ['id' => $this->session->userdata('question_trial_paper_id')]);
            }

            switch ($this->input->post('submit')) {
                case 'previous':
                    $this->session->set_userdata('question_trial_paper_id', $this->session->userdata('question_trial_paper_id') - 1);
                    break;
                case 'next':
                    $this->session->set_userdata('question_trial_paper_id', $this->session->userdata('question_trial_paper_id') + 1);
                    break;
                default:
                    # code...
                    break;
            }
            redirect('question/show');
        }

        $question_trial_paper_id = $this->session->userdata('question_trial_paper_id');
        $whereCondition = ['qtp.id' => $question_trial_paper_id];

        $query = $this->db->select('q.id, question, codes, option1, option2, option3, option4, answer, user_answer, fake_id')
            ->join('question_trial_paper qtp', 'qtp.question_id = q.id')
            ->get_where('questions q', $whereCondition);

        if($query->num_rows()) {
            $question = $query->row_array();
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
    public function get_question_count($paper_id)
    {
        $this->db->get_where('questions', array('paper_id' => $paper_id));
        return $this->db->count_all_results();
    }

    /**
     * Get all questions
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array
     */
    public function get_all_questions($paper_id)
    {
        $this->db->select('id, question, codes, option1, option2, option3, option4, answer');
        $query = $this->db->get_where('questions', array('paper_id' => $paper_id));
        return $query->result_array();
    }

    /**
     * Get paper id for paper slug
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $paper_slug
     *
     * @return int|boolean
     */
    public function get_paper_id($paper_slug)
    {
        $this->db->select('id');
        $query = $this->db->get_where('papers', ['slug' => $paper_slug]);

        if($query->num_rows()) {
            return intval($query->row()->id);
        }

        return false;
    }

    /**
     * Create trial paper
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  int $paper_id
     *
     * @return void
     */
    public function create_trial_paper($paper_id)
    {
        $this->db->insert('trial_papers', [
            'paper_id' => $paper_id,
            'ip_address' => get_client_ip(),
        ]);

        $trial_paper_id = $this->db->insert_id();
        $this->db->query("INSERT INTO question_trial_paper(question_id, trial_paper_id)
            SELECT id, $trial_paper_id FROM questions WHERE paper_id = $paper_id");
        $this->db->query('SET @pos := 0');
        $this->db->query("UPDATE question_trial_paper SET fake_id = (SELECT @pos := @pos + 1)
            WHERE trial_paper_id = $trial_paper_id ORDER BY updated_at DESC");

        $this->db->select_min('id', 'min_id')->select_max('id', 'max_id');
        $query = $this->db->get_where('question_trial_paper', "trial_paper_id = $trial_paper_id");

        // unset all session data
        $this->session->unset_userdata([
            'question_trial_paper_id',
            'question_trial_paper_min_id',
            'question_trial_paper_max_id'
        ]);

        $this->session->set_userdata([
            'question_trial_paper_id' => $query->row()->min_id,
            'question_trial_paper_min_id' => $query->row()->min_id,
            'question_trial_paper_max_id' => $query->row()->max_id,
        ]);
    }
}
