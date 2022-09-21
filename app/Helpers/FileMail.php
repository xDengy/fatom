<?php

namespace App\Helpers;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Mail\Mailable;

class FileMail extends Mailable
{
    public $data;

    /*
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /*
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $requestData = $this->data;
        $text = '';
        foreach ($requestData as $key => $reqData) {
            if ($key !== 'as' && $key !== 'file' && $key !== 'mime') {
                $text .= $reqData;
            }
        }

        return $this->from('notify@umax.agency', 'Fatom')->subject('Сообщение с сайта Fatom')->view(
            'emails.file'
        )->html($text)
            ->attach(public_path($requestData['file']), [
                'as' => $requestData['as'],
                'mime' => $requestData['mime'],
            ]);
    }
}
