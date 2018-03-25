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
     * @return view
     */
    public function show()
    {
        $data['question'] = $this->question_model->get_next_question();

        $this->template
            ->title(get_site_name(), 'Question')
            ->build('question/show', $data);
    }

    /**
     * Set Exam info
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function exam($exam_id)
    {
        $this->session->set_userdata('exam_id', $exam_id);
        $this->session->unset_userdata('question_id');
        redirect('question/show');
    }

    /**
     * List all questions
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function index($exam_id)
    {
        $data['questions'] = $this->question_model->get_all_questions($exam_id);

        $this->template
            ->title(get_site_name(), 'Question Listing')
            ->build('question/index', $data);
    }

}
