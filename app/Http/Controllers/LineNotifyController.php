<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth; // นำเข้า Auth
use App\Models\LineNotify; // นำเข้าโมเดล LineNotify

class LineNotifyController extends Controller
{
    protected $clientId = 'rxaKbwgr4FbFL8q8Lu6P07';
    protected $clientSecret = '1fUVO7SeYoUpFxMLEuC6uK0fDV1nlho6XHoLtkkw53P';
    protected $redirectUri = 'https://ab23-1-47-93-170.ngrok-free.app/callback';

    public function redirectToLineNotify()
    {
        $authorizationUrl = "https://notify-bot.line.me/oauth/authorize?" . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => 'notify',
            'state' => csrf_token(), // เพื่อป้องกันการโจมตี CSRF
        ]);

        return redirect($authorizationUrl);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->query('code');
        $state = $request->query('state');

        if ($state !== csrf_token()) {
            abort(403, 'Invalid CSRF token');
        }

        $client = new Client();
        $response = $client->post('https://notify-bot.line.me/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $accessToken = $data['access_token'];

        // บันทึก access token ในฐานข้อมูล
        $user = Auth::user(); // รับข้อมูลผู้ใช้ที่ล็อกอิน
        LineNotify::updateOrCreate(
            ['user_id' => $user->id], // เงื่อนไขในการอัพเดต
            ['access_token' => $accessToken] // ข้อมูลที่ต้องการบันทึก
        );

        return redirect('/')->with('success', 'เชื่อมต่อกับ LINE Notify เรียบร้อยแล้ว');
    }
}
