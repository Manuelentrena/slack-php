<?php
require 'vendor/autoload.php';
require_once 'vendor/rmccue/requests/src/Autoload.php';
WpOrg\Requests\Autoload::register();

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$WEBHOOK_SLACK = $_ENV['WEBHOOK_SLACK']; 

// Debugging
if (!$WEBHOOK_SLACK) {
    die("Error: WEBHOOK_SLACK variable is not set or is empty.");
}

$response =  WpOrg\Requests\Requests::post(
  $WEBHOOK_SLACK,
  array(
    'Content-Type' => 'application/json'
  ),
  json_encode(array (
    'blocks' => 
        array (
            array (
                "type" => "section",
                "text" => array (
                    "type" => "mrkdwn",
                    "text" => 'Message',
                ),
            ),
            array (
                "type" => "section",
                "fields" => array (
                    array (
                        "type" => "mrkdwn",
                        "text" => "*Repository:*\nRepository",
                    ),
                    array (
                        "type" => "mrkdwn",
                        "text" => "*Event:*\nEvent",
                    ),
                    array (
                        "type" => "mrkdwn",
                        "text" => "*Ref:*\nRef",
                    ),
                    array (
                        "type" => "mrkdwn",
                        "text" => "*SHA:*\nSHA",
                    ),
                ),
            ),
        ),
  ))
);

if(!$response->success) {
  echo $response->body;
  exit(1);
}