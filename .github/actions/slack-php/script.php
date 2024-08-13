<?php
require_once 'vendor/rmccue/requests/src/Autoload.php';
WpOrg\Requests\Autoload::register();

// require 'vendor/autoload.php';
// use Dotenv\Dotenv;
// $dotenv = Dotenv::createImmutable(__DIR__);
// $dotenv->load();


$INPUT_SLACK_WEBHOOK = $_ENV['INPUT_SLACK_WEBHOOK']; 
$INPUT_MESSAGE = $_ENV['INPUT_MESSAGE']; 

// Debugging
if (!$INPUT_SLACK_WEBHOOK) {
    die("Error: WEBHOOK_SLACK variable is not set or is empty.");
}

$response =  WpOrg\Requests\Requests::post(
  $INPUT_SLACK_WEBHOOK,
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
                    "text" => $INPUT_MESSAGE,
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

echo "::group::Slack Response\n";
var_dump($response);
echo "::endgroup::\n";

if(!$response->success) {
  echo $response->body;
  exit(1);
}