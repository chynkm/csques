<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CI_Controller {

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

        $this->load->model('subject_model');
    }

    /**
     * List all subjects
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function index()
    {
        $data['subjects'] = $this->subject_model->get_subject_slug_list();

        $this->template
            ->title(get_site_name(), 'Subject listing')
            ->build('subject/index', $data);
    }

    /**
     * Show available exams for a Subject
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function show($subject_slug)
    {
        $data['exams'] = $this->subject_model->get_exam_list($subject_slug);

        $this->template
            ->title(get_site_name(), 'Exam listing')
            ->build('subject/show', $data);
    }

}
