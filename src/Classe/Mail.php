<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = 'e9825437f180fbfab2a630eab2a20485';
    private $api_key_secret = 'c65c48e55375b6af3edd72cd50bcb994';

    public function send($to_email, $to_name, $subject, $content)
    {
            $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);

            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "justincornu@gmail.com",
                            'Name' => "Site E-commerce"
                        ],
                        'To' => [
                            [
                                'Email' => $to_email,
                                'Name' => $to_name
                            ]
                        ],
                        'TemplateID' => 5641547,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $content
                        ]            
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success();
    }
}
?>