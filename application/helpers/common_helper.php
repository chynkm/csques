<?php

/**
 * Retrieve assets
 *
 * @author Karthik M <chynkm@gmail.com>
 *
 * @param  string $value
 *
 * @return string
 */
function asset_url($value = '')
{
   return base_url('assets/'.$value);
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
    return 'CS CBSE';
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
function dd($variable)
{
    echo '<pre>';
    print_r($variable);
    die;
}
