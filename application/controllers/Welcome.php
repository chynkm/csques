<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// $this->load->view('welcome_message');
		$data = [];
		$this->template
            ->title('Welcome to CI', get_site_name())
            ->build('question/show', $data);
	}

    /**
     * About page for the application
     *
     * @todo - need to complete the functionality
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
	public function about()
	{
        $data['meta_description'] = 'MCQP is a free testing service rendered for all candidates attending CBSE NET(UGC NET)';
		$this->template
            ->title('About MCQP', get_site_name())
            ->build('about', $data);
	}
}
