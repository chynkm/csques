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
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function about()
    {
        $data['meta_description'] = 'MCQP is a free testing service rendered for all candidates attending CBSE NET(UGC NET) exam';
        $this->template
            ->title('About', get_site_name())
            ->build('welcome/about', $data);
    }

    /**
     * Privacy policy page
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function privacy_policy()
    {
        $data['meta_description'] = 'MCQP privacy policy';
        $this->template
            ->title('Privacy policy', get_site_name())
            ->build('welcome/privacy_policy', $data);
    }

    /**
     * Contact-us page
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function contact_us()
    {
        if($this->input->post()) {
            if($this->form_validation->run()) {
                $this->_send_email();
                redirect('thank-you');
            }

            $data['contact_form'] = $this->input->post();
        } else {
            $data['contact_form'] = [];
        }

        $data['meta_description'] = 'MCQP contact us form';
        $this->template
            ->title('Contact us', get_site_name())
            ->build('welcome/contact_us', $data);
    }

    /**
     * Send email about contact form
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return void
     */
    private function _send_email()
    {
        $this->load->library('email');

        $this->email->from('noreply@mcqp.in', 'MCQP - no reply');
        $this->email->to('chynkm@gmail.com');

        $this->email->subject('New contact form submission '.date('Y-m-d H:i:s'));
        $email_message = 'Name: '.$this->input->post('name').'<br/>';
        $email_message .= 'Email: '.$this->input->post('email').'<br/>';
        $email_message .= 'Message: '.$this->input->post('message').'<br/>';

        $this->email->message($email_message);

        $this->email->send();
    }

    /**
     * 404 page
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
	public function not_found()
	{
        $data['meta_description'] = 'MCQP - 404 not found';
        $this->output->set_status_header(404);
		$this->template
            ->title('404 not found', get_site_name())
            ->build('welcome/not_found', $data);
	}

    /**
     * Thank you page
     *
     * @author Karthik M <chynkm@gmail.com>
     *
     * @return view
     */
    public function thank_you()
    {
        $this->template
            ->title('404 not found', get_site_name())
            ->build('welcome/thank_you');
    }

    public function ajax_get_plugin()
    {
        /*if (isset($_SERVER["HTTP_ORIGIN"]) === true) {
            $origin = $_SERVER["HTTP_ORIGIN"];
            $allowed_origins = array(
                "http://cscbse.test",
            );
            if (in_array($origin, $allowed_origins, true) === true) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Allow-Methods: POST');
                header('Access-Control-Allow-Headers: Content-Type');
            }
            if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
                exit; // OPTIONS request wants only the policy, we can stop here
            }
        }

        error_log(print_r($_REQUEST, true), 3, "errors.log");

        $mysqli = new mysqli("127.0.0.1", "root", "", "cscbse") or die('Error: Unable to connect to MySQL: '.mysqli_connect_error());
        $query = "INSERT INTO
        feedbacks(browser, browser_version, os, os_version, mobile, element_path, element_html, url, device_width, device_height, document_width,
            document_height, vertex_x, vertex_y, user_agent) VALUES
            ({$_POST['browser']}, {$_POST['browser_version']}, {$_POST['os']}, {$_POST['os_version']}, {$_POST['mobile']},
            {$_POST['element_path']}, {$_POST['element_html']}, {$_POST['url']}, {$_POST['device_width']}, {$_POST['device_height']},
            {$_POST['document_width']}, {$_POST['document_height']}, {$_POST['vertex_x']}, {$_POST['vertex_y']}, {$_POST['user_agent']})";


        $mysqli->query($query);

        // printf ("New Record has id %d.\n", $mysqli->insert_id);

        $mysqli->close();

        echo 'ok';
        die;*/
        $data = [];
        return $this->load->view('welcome/plugin', $data);
    }
}
