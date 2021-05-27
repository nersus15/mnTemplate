<?php
// Config untuk autoload helper dan library
$config['autoload']['helpers'] = array('main_helper', 'qbuilder');
$config['autoload']['hooks'] = array('common');

if(SECURE_FORM)
    $config['autoload']['helpers'][] ='forms_helper';
