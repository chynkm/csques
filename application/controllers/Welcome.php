<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
            ->title('Thank you', get_site_name())
            ->build('welcome/thank_you');
    }
}
