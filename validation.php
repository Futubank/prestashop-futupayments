<?php

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/futubank.php');

$futubank = new Futubank();

Logger::AddLog(
	'[Futubank] Post request from: '.$_SERVER['REMOTE_ADDR'].' with POST: '.print_r($_POST, true),
	3, null, null, null, true
);

if ($futubank->active)
	$futubank->validation();
	
