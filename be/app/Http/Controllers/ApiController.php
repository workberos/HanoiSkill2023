<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\Registration;
use App\Models\Session_registration;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function events()
    {
        return response()->json(['events' => Event::where('date', '<', now())->with('organizer')->get()], 200);
    }
    public function event($os, $es)
    {
        $organizer = Organizer::where('slug', $os)->first();
        if (!$organizer) return response()->json(['message' => 'Không tìm thấy nhà tổ chức'], 404);

        $event = Event::where('slug', $es)->first();

        if (!$event) return response()->json(['message' => 'không tìm thấy sự kiện'], 404);


        return $event;
    }

    public function login(Request $request)
    {
        try {
            $user = Attendee::where('lastname', $request->lastname)
                ->where('registration_code', $request->registration_code)
                ->first();
            $user->update([
                'login_token', md5($user->username)
            ]);

            return response()->json([$user], 200);
        } catch (\Throwable $th) {
            if (!$user) return response()->json(['message' => 'Đăng nhập không hợp lệ'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = Attendee::where('login_token', $request->token)->first();
        if (!$user) return response()->json(['message' => 'token không hợp lệ'], 401);

        $user->update([
            'login_token', null
        ]);

        return response()->json(['message' => 'Đăng xuất thành công'], 200);
    }

    public function registration(Request $request, $os, $es)
    {
        try {
            $organizer = Organizer::where('slug', $os)->first();
            if (!$organizer) return response()->json(['message' => 'Không tìm thấy nhà tổ chức'], 404);

            $event = Event::where('slug', $es)->first();

            if (!$event) return response()->json(['message' => 'không tìm thấy sự kiện'], 404);
            $user = Attendee::where('login_token', $request->token)->first();
            if (!$user) return response()->json(['message' => 'token không hợp lệ'], 401);

            $registration = Registration::create([
                'attendee_id' => $user->id,
                'ticket_id' => $request->ticket_id,
                'registration_time' => now()
            ]);

            if(isset($request->session_ids)) {
                foreach (json_decode($request->session_ids) as $session_id) {
                    Session_registration::create([
                        'registration_id' => $registration->id,
                        'session_id' => $session_id
                    ]);
                }
            }
            return response()->json(['message' => 'Đăng ký thành công'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Đăng ký thất bại'], 401);
        }
    }

    public function registrations(Request $request){
        $attendee = Attendee::where('login_token', $request->token)->first();
        if (!$attendee) return response()->json(['message' => 'Người dùng chưa đăng nhập'], 401);

        $registrations = Registration::where('attendee_id', $attendee->id)->get();

        return response()->json(['registrations' => $registrations], 200);

    }
}
