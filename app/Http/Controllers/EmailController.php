<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Http\Requests\UserRequest;
use App\Mail\ExelMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendUserEmail(EmailRequest $request): object
    {

        $email = $request->input('email');

        $pathToFile = $request->file('report')->storeAs('usersExelReports', 'export.xlsx');
        Mail::to($email)->send(new ExelMail($pathToFile));
        return redirect()->route('users.index');

    }
}
