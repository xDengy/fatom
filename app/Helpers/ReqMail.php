<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReqMail extends Mailable
{
    public $data;
    /*
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this -> data = $data;
    }

    /*
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        $requestData = $this->data;
        $text = '';
        foreach($requestData as $reqData) {
            $text .= $reqData;
        }
        return $this->from('notify@umax.agency','Fatom')->subject('Сообщение с сайта Fatom')->html($text);
    }
}