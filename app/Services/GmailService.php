<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    private Gmail $gmail;

    public function __construct()
    {
        $client = new Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->setAccessType('offline');

        $client->setAccessToken([
            'refresh_token' => config('services.google.refresh_token'),
        ]);

        $this->gmail = new Gmail($client);
    }

    public function send(
        string $to,
        string $subject,
        string $html,
        ?string $attachment = null,
        ?string $filename = null
    ): void {
        $boundary = uniqid('np', true);

        $raw = "From: HealthPass <".config('mail.from.address').">\r\n";
        $raw .= "To: {$to}\r\n";
        $raw .= "Subject: {$subject}\r\n";
        $raw .= "MIME-Version: 1.0\r\n";
        $raw .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n\r\n";

        $raw .= "--{$boundary}\r\n";
        $raw .= "Content-Type: text/html; charset=UTF-8\r\n";
        $raw .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $raw .= $html."\r\n\r\n";

        if ($attachment !== null && $filename !== null) {
            $raw .= "--{$boundary}\r\n";
            $raw .= "Content-Type: application/pdf; name=\"{$filename}\"\r\n";
            $raw .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n";
            $raw .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $raw .= chunk_split(base64_encode($attachment))."\r\n";
        }

        $raw .= "--{$boundary}--";

        $message = new Message();
        $message->setRaw(
            rtrim(strtr(base64_encode($raw), '+/', '-_'), '=')
        );

        $this->gmail->users_messages->send('me', $message);
    }
}