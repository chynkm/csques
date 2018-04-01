<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model
{

    /**
     * Get question and process POST submission
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return array|boolean
     */
    public function get_next_question()
    {
        if($this->input->post()) {
            switch ($this->input->post('submit')) {
                case 'previous':
                    $this->session->set_userdata('question_trial_paper_id', $this->session->userdata('question_trial_paper_id') - 1);
                    break;
                case 'next':
                    $this->session->set_userdata('question_trial_paper_id', $this->session->userdata('question_trial_paper_id') + 1);
                    break;
                default:
                    $this->session->set_userdata('paper_completed', 1);
                    redirect('question/score');
                    break;
            }
            redirect('question/show');
        }

        $query = $this->db->select('q.id, question, codes, option1, option2, option3, option4, answer, user_answer, fake_id')
            ->join('question_trial_paper qtp', 'qtp.question_id = q.id')
            ->get_where('questions q', ['qtp.id' => $this->session->userdata('question_trial_paper_id')]);

        if($query->num_rows()) {
            return $query->row_array();
        }

        return false;
    }

    /**
     * Save user answer to DB
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return boolean
     */
    public function save_answer()
    {
        $result = $this->db->update('question_trial_paper',
            ['user_answer' => $this->input->post('answer')],
            [
                'id' => $this->session->userdata('question_trial_paper_id'),
                'user_answer IS NULL' => null
            ]);

        $this->db->query("UPDATE question_trial_paper qtp
            JOIN questions q on qtp.question_id = q.id
            SET result = IF(user_answer = answer, 'correct', 'incorrect')
            WHERE qtp.id = ".$this->session->userdata('question_trial_paper_id'));

        return $result;
    }

    /**
     * Get score of the exam
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return string
     */
    public function get_score()
    {
        $query = $this->db->select("
            COUNT(CASE WHEN result = 'correct' THEN 1 END) correct_answer_count,
            COUNT(CASE WHEN result = 'incorrect' THEN 1 END) incorrect_answer_count,
            max(fake_id) as total_questions")
            ->get_where('question_trial_paper', ['trial_paper_id' => $this->session->userdata('trial_paper_id')]);


        if($query->num_rows()) {
            return $query->row_array();
        }

        return false;
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
     * @param  boolean $test_exam
     *
     * @return void
     */
    public function create_trial_paper($paper_id, $test_exam = false)
    {
        $paper_end_time = $test_exam ? $this->get_end_time_for_paper($paper_id) : null;
        $this->db->insert('trial_papers', [
            'paper_id' => $paper_id,
            'ip_address' => get_client_ip(),
            'end_time' => $paper_end_time,
        ]);

        $trial_paper_id = $this->db->insert_id();

        if($test_exam) {
            $insert_from_select_query = "INSERT INTO question_trial_paper(question_id, trial_paper_id)
                SELECT id, $trial_paper_id FROM questions WHERE paper_id = $paper_id order by rand()";
        } else {
            $insert_from_select_query = "INSERT INTO question_trial_paper(question_id, trial_paper_id)
                SELECT id, $trial_paper_id FROM questions WHERE paper_id = $paper_id";
        }

        $this->db->query($insert_from_select_query);
        $this->db->query("UPDATE question_trial_paper JOIN (SELECT @fake_id := 0) temp
            SET fake_id=@fake_id:=@fake_id+1 WHERE trial_paper_id = $trial_paper_id");

        $this->db->select_min('id', 'min_id')->select_max('id', 'max_id');
        $query = $this->db->get_where('question_trial_paper', "trial_paper_id = $trial_paper_id");

        // unset all session data
        $this->session->unset_userdata([
            'question_trial_paper_id',
            'question_trial_paper_min_id',
            'question_trial_paper_max_id',
            'trial_paper_id',
            'paper_completed',
            'paper_end_time',
        ]);

        $this->session->set_userdata([
            'question_trial_paper_id' => $query->row()->min_id,
            'question_trial_paper_min_id' => $query->row()->min_id,
            'question_trial_paper_max_id' => $query->row()->max_id,
            'trial_paper_id' => $trial_paper_id,
            'paper_end_time' => $paper_end_time,
        ]);
    }

    /**
     * Get end timestamp for paper in timed test
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  int $paper_id
     *
     * @return int
     */
    private function get_end_time_for_paper($paper_id)
    {
        $query = $this->db->select('allotted_time')->get_where('papers', ['id' => $paper_id]);
        $allotted_time = $query->row()->allotted_time;

        return intval(strtotime("+$allotted_time seconds"));
    }

    /**
     * Get the current attended paper slug and subject slug
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return string
     */
    public function get_attended_paper_slug_and_subject_slug()
    {
        $query = $this->db->select('p.slug paper_slug, s.slug subject_slug')
            ->join('trial_papers tp', 'paper_id = p.id')
            ->join('subjects s', 'subject_id = s.id')
            ->get_where('papers p', ['tp.id' => $this->session->userdata('trial_paper_id')]);

        return $query->row_array();
    }
}
