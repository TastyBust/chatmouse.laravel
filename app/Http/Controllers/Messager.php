<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\user;
use Cookies;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Messager extends Controller
{
    //Системное получение всей информации
    public function showall()
    {

        return Message::all();
    }
    public function login(Request $request)
    {
        $user = user::where("username", $request->username)->first();
        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                return json_encode(array("aid" => $user->aid));
            } else return json_encode(array("error" => "bad login or password"));
        } else return json_encode(array("error" => "user doesnt exist"));
    }
    public function register(Request $request)
    {
        if (strlen($request->username) >= 5) {
            if (strlen($request->password) >= 5) {



                $user = new user;
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->aid = $request->link;
                $user->save();
                return json_encode(array("aid" => $user->aid));
            } else return json_encode(array("error" => "bad login or password"));
        } else return json_encode(array("error" => "bad login or password"));
    }

    public function getHash(Request $request)
    {

        $site = $request->site;
        if ($request->site && $request->name && $request->email) {
            if (message::latest()->get()) {
                $id = message::latest()->first();
            } else $id = 1;

            $secret = bin2hex(random_bytes(16));
            $user = new message;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->secret = $secret;
            $user->to = $site;
            $user->save();
            return json_encode(array('secret' => $secret, 'uid' => $id->id + 1));
        } else return json_encode(array('error' => 'bad parametrs'));
    }


    //Получение сообщений  для администрации
    public function getMessageAdmin(Request $request)
    {

        $admin = $request->admin;
        if ($admin != null) {
            $a = Message::where('refer', $admin)->first();
        }
        return $a;
    }
    //API для показа сообщения работает только чере пост. Используется uid.
    public function messagesu(Request $request)
    {
        $u = message::where('secret', $request->secret)->first();

        if (!$u) return json_encode(array('error' => 'bad secret key'));
        return $u->messages;
    }
    public function messagesa(Request $request)
    {
        $u = message::where('to', $request->site)->get();

        if (!$u) return json_encode(array('error' => 'bad aid key'));
        else
            return $u;
    }
    public function senderu(Request $request)
    {
        $u = message::where('secret', $request->secret)->first();
        if ($u) {
            if ($request->message != null) {
                $a = json_decode($u->messages, true);
                if ($a != null) {
                    $a[sizeof($a)] = array('Вы' => $request->message);
                    $u->messages = $a;
                    $u->save();
                    return json_encode(array('status' => 'OK'));
                } else {
                    $a[0] = array('Вы' => $request->message);
                    $u->messages = $a;
                    $u->save();
                    return json_encode(array('status' => 'OK'));
                }
            } else return json_encode(array('error' => 'bad request'));
        } else return json_encode(array('error' => 'bad secret key'));
    }
    public function sendera(Request $request)
    {
        $u = message::where('secret', $request->secret)->first();
        if ($u) {
            if ($request->message != null) {
                $a = json_decode($u->messages, true);
                if ($a != null) {
                    $a[sizeof($a)] = array('Консультант' => $request->message);
                    $u->messages = $a;
                    $u->save();
                    return json_encode(array('status' => 'OK'));
                } else {
                    $a[0] = array('Консультант' => $request->message);
                    $u->messages = $a;
                    $u->save();
                    return json_encode(array('status' => 'OK'));
                }
            } else return json_encode(array('error' => 'bad request'));
        } else return json_encode(array('error' => 'bad secret key'));
    }
}
