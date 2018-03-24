<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('question_model');
    }

    public function show()
    {
        $data['question'] = $this->question_model->getNextQuestion();

        $this->template
            ->title(get_site_name(), 'Question')
            ->build('question/show', $data);
    }

    public function exam($exam_id)
    {
        $this->session->set_userdata('exam_id', $exam_id);
        $this->session->unset_userdata('question_id');
        redirect('question/show');
    }

}
