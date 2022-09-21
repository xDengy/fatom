<?php

namespace App\Http\Controllers;

use App\Helpers\FileMail;
use App\Models\Settings;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ModalController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function modal(Request $request) {
        $filePath = null;
        $message = [];
        if($request->file('uploadCB')) {
            $fileName = time() . '_' . $request->file('uploadCB')->getClientOriginalName();
            $fileStore = $request->file('uploadCB')
                ->storeAs('uploads', $fileName, 'public');

            $filePath = '/storage/' . $fileStore;

            $message['as'] = 'file.' . explode('/', $request->file('uploadCB')->getMimeType())[1];
            $message['mime'] = $request->file('uploadCB')->getMimeType();
            $message['file'] = $filePath;
        }

        $requestData = $request->post();
        $message[] = 'Домен: ' . $requestData['domain'] . "<br>";
        $message[] = 'Имя: ' . $requestData['userNameCB'] . "<br>";
        $message[] = 'Телефон: ' . $requestData['userPhoneCB'] . "<br>";
        $message[] = 'Текст сообщения: ' . $requestData['userTextCB'] . "<br>";

        Mail::to(Settings::first()->email)
            ->send(new FileMail($message));

        $zayavkaData = [
            'domain'  => $requestData['domain'],
            'name'    => $requestData['userNameCB'],
            'tel'     => $requestData['userPhoneCB'],
            'message' => $requestData['userTextCB'],
            'file'    => $filePath
        ];

        DB::table('zayavkas')->insert($zayavkaData);
        return redirect()->back();
    }
}
