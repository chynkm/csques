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
     * @todo - Rename the title
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function index()
    {
        $data['subjects'] = $this->subject_model->get_subject_slug_list();
        $data['meta_description'] = 'MCQP - One stop solution to learn and practice solving previous years CBSE NET(UGC NET) question papers';

        $this->template
            // ->title('Subject listing', get_site_name())
            ->title('CBSE NET(UGC NET) previous question papers', get_site_name())
            ->build('subject/index', $data);
    }

    /**
     * Show available exams for a Subject
     *
     * @todo - need to set flash data and echo the error when redirect fails
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @param  string $subject_slug
     *
     * @return view
     */
    public function show($subject_slug)
    {
        $data['papers'] = $this->subject_model->get_paper_list($subject_slug);
        if($data['papers'] === false) {
            redirect('/');
        }

        $data['subject'] = $this->subject_model->get_subject($subject_slug);
        $data['meta_description'] = 'MCQP - Learn and practice solving previous years (UGC NET) '.$data['subject'].' question papers';

        $this->template
            ->title($data['subject'].' question papers', get_site_name())
            ->build('subject/show', $data);
    }

}
