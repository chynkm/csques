<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
    'error_prefix' => '<p class="error_block">',
    'error_suffix' => '</p>'
];

$config['welcome/contact_us'] = [
    [
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'trim|required'
    ],
    [
        'field' => 'email',
        'label' => 'Email',
        'rules' => 'trim|required'
    ],
    [
        'field' => 'message',
        'label' => 'Message',
        'rules' => 'trim|required'
    ],
];
