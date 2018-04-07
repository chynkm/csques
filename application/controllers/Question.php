<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {

    /**
     * Constructor
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('question_model');
    }

    /**
     * Show a single question
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @todo - need to set flash data and echo the error when redirect fails
     *
     * @param  string $paper_slug
     *
     * @return view
     */
    public function show($paper_slug = '')
    {
        if($this->_paper_completed()) {
            redirect('question/score');
        }

        $data['question'] = $this->question_model->get_next_question();

        if($data['question'] === false) {
            redirect('/');
        }

        $this->template
            ->title('Question', get_site_name())
            ->build('question/show', $data);
    }

    /**
     * Set Exam info
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $paper_slug
     * @param  boolean $test_exam
     *
     * @return view
     */
    public function paper($paper_slug, $test_exam = false)
    {
        $paper_id = $this->_validate_paper_slug($paper_slug);

        $this->question_model->create_trial_paper($paper_id, $test_exam);

        redirect('question/show');
    }

    /**
     * return Valid slug ? paper_id : redirect to '/'
     *
     * @todo - need to set flash data and echo the error when redirect fails
     *       - check whether the redirect can be made to the last active page
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $paper_slug
     *
     * @return int|redirect
     */
    private function _validate_paper_slug($paper_slug)
    {
        $paper_id = $this->question_model->get_paper_id($paper_slug);
        if($paper_id === false) {
            redirect('/');
        }

        return $paper_id;
    }

    /**
     * Check whether the score page is accessed by user
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return boolean
     */
    private function _paper_completed()
    {
        return $this->session->has_userdata('paper_completed');
    }

    /**
     * List all questions
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $paper_slug
     *
     * @return view
     */
    public function index($paper_slug)
    {
        $paper_id = $this->_validate_paper_slug($paper_slug);

        $data['questions'] = $this->question_model->get_all_questions($paper_id);

        $this->template
            ->title('Question Listing', get_site_name())
            ->build('question/index', $data);
    }

    /**
     * Display score
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function score()
    {
        $data['score'] = $this->question_model->get_score();
        $data['attended_paper_slug_and_subject_slug'] = $this->question_model->get_attended_paper_slug_and_subject_slug();

        $this->template
            ->title('Score', get_site_name())
            ->build('question/score', $data);
    }

    /**
     * Save the submitted answer
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return boolean
     */
    public function ajax_save_answer()
    {
        echo $this->input->post('answer') ? $this->question_model->save_answer() : false;
    }

}
