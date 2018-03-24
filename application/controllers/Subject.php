<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('subject_model');
    }

    public function index()
    {
        $data['subjects'] = $this->subject_model->getSubjectSlugList();

        $this->template
            ->title(get_site_name(), 'Subject listing')
            ->build('subject/index', $data);
    }

    public function show($subject_slug)
    {
        $data['exams'] = $this->subject_model->getExamList($subject_slug);

        $this->template
            ->title(get_site_name(), 'Exam listing')
            ->build('subject/show', $data);
    }

}