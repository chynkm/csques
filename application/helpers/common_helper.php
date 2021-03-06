<?php

/**
 * Retrieve assets with versioning for cache busting
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  string $value
 *
 * @return string
 */
function asset_url($value = '')
{
   return site_url('assets/'.$value).'?ver='.md5_file('assets/'.$value);
}

/**
 * Populate the form
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  string $field_name
 * @param  array $field_array
 * @param  string $default
 *
 * @return string
 */
function populate_value($field_name, $field_array, $default = "")
{
    if(is_array(set_value ($field_name)))
        return isset($field_array[$field_name]) ? $field_array[$field_name] : null;

    if(isset($field_array[$field_name]) && !is_null($field_array[$field_name]))
        return $field_array[$field_name];
    else
        return set_value ($field_name,$default);
}

/**
 * Returns the site name
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return string
 */
function get_site_name()
{
    return 'MCQP';
}

/**
 * Returns the domain name
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return string
 */
function get_domain_name()
{
    return 'MCQP.IN';
}

/**
 * Checks whether a user is logged in or not
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return boolean
 */
function check_login()
{
    $CI = get_instance();
    return ($CI->session->userdata('user_validated') && $CI->session->userdata('user_id')) ? TRUE : FALSE;
}

/**
 * Sets flash message for status
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param [boolean] $status
 * @param [string] $message
 *
 */
function set_flash_message($status, $message)
{
    $CI = &get_instance();
    $CI->session->set_flashdata('status', $status);
    $CI->session->set_flashdata('msg', $message);
}

/**
 * FOR SHOWING SUCCESS/ERROR MESSAGES
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  boolean $status [$status = TRUE for success message; $status = FALSE for failed message]
 * @param  string $msg
 *
 * @return view
 */
function get_status_message($status,$msg)
{
    $CI = &get_instance();
    if(isset($status))
    {
        $data['set_msg']    = $msg;
        $data['set_status'] = $status;
        return $CI->load->view('common/status_message', $data, TRUE);
    }
}

/**
 * Debug and die
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  string|array $variable
 *
 * @return void
 */
function dd($variable = '')
{
    echo '<pre>';
    print_r($variable);
    die;
}

/**
 * Remove space method for array_filter command
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  string $value
 *
 * @return boolean
 */
function remove_space($value)
{
    return $value != '';
}

/**
 * Generate the view for answer_key table for MATCH THE FOLLOWING questions
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  array $question
 *
 * @return view
 */
function get_answer_key_table($question)
{
    if(! is_null($question['codes']) && strlen($question['codes'])) {

        $CI = &get_instance();
        $data['codes'] = array_filter(explode(' ', $question['codes']), 'remove_space');
        $data['answers'] = [
            'A' => array_filter(explode(' ', $question['option1']), 'remove_space'),
            'B' => array_filter(explode(' ', $question['option2']), 'remove_space'),
            'C' => array_filter(explode(' ', $question['option3']), 'remove_space'),
            'D' => array_filter(explode(' ', $question['option4']), 'remove_space')
        ];

        return $CI->load->view('question/answer_key_table', $data, TRUE);
    }
}

/**
 * Get the client IP address
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return string
 */
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

/**
 * Get the remaining time for an exam
 * @todo - not used, need to be removed
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return string
 */
function get_remaining_time($date_time_end) {
    $date_time_start = new DateTime();
    $date_time_end = new DateTime($date_time_end);
    $date_diff = $date_time_start->diff($date_time_end);
    return $date_diff->format("%H:%i:%s");
}

/**
 * Calculate the exam's remaining time
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @return int|null
 */
function calculate_exam_remaining_time() {
    $CI = &get_instance();
    if(! is_null($CI->session->paper_end_time)) {
        return intval($CI->session->paper_end_time - time());
    }

    return null;
}
