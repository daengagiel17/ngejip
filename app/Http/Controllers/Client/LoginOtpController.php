<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\User;
use Auth;

class LoginOtpController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logoutOtp');
    }

    public function loginOtp($state){
        $user = User::find(1);
        Auth::login($user);
        return redirect()->route('home');

        // $url = 'https://www.accountkit.com/v1.0/basic/dialog/sms_login/';
        // $data = array(
        //     'app_id' => '560829467747070',
        //     'redirect' => 'https://ngejip.site/callback-otp',
        //     'state' => $state,
        //     'fbAppEventsEnabled' => 'true'
        //     );
        // $data = http_build_query($data);

        // return redirect()->to($url."?".$data);
    }

    public function callbackOtp(Request $request){	
        $state = $request->state;
        $stateArr = explode(" ", $request->state);

        if($request->status == "NOT_AUTHENTICATED" || $request == null){
            // Mengembalikan ke login otp
            return redirect()->route('login-otp', ['state', $state]);
            // return view('client/cek-harga', compact('booking','harga_detail'))->with('Error', 'You have not authenticated');
        }elseif($request->status == "PARTIALLY_AUTHENTICATED"){            
            // URL to get access token by code and app_id fb
            $url = "https://graph.accountkit.com/v1.0/access_token?grant_type=authorization_code&code=".$request['code']."&access_token=AA|560829467747070|1d3008d09a40d7364e57e893f34ba990";
            // Get data access token by url
            $get = json_decode(file_get_contents($url),true);
            // URL to get data phone by access token
            $verify_url = "https://graph.accountkit.com/v1.0/me/?access_token=".$get['access_token'];            
            // get data by verivy url
            $data = json_decode(file_get_contents($verify_url),true);

            // Cek data['phone']['number'] jika terdaftar ke pesan/home jika tidak maka isi data diri
            $user = User::where('nohp', $data['phone']['number'])->first();
            if($user == null){
                $dataEncrypt = [ "data" => $data, "state" =>  $state];
                $dataEncrypt = Crypt::encrypt($dataEncrypt);
                return redirect()->route('register-form', $dataEncrypt);
            }else{
                if($user->email == null || $user->name == null){
                    $data= [ "id" => $user->id, "state" =>  $request->state];
                    $data = Crypt::encrypt($data);
                    return redirect()->route('register-form', $data);    
                }

                Auth::login($user);
                if($stateArr[0] == "list-harga"){
                    return redirect()->route($stateArr[0],[$stateArr[1]]);
                }
                return redirect()->route($state);
            }
        }

    }

    public function registerForm($dataParam){
        try {
            $dataDecrypt = Crypt::decrypt($dataParam);
            $state = $dataDecrypt["state"];
            $data = $dataDecrypt["data"];
        } catch (DecryptException $e) {
            abort("404");
        }

        return view('client/register', compact('data', 'state'));
    }

    public function registerOtp(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users',
        ],[
            'email.required' => 'Nama is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email invalid format',
            'email.unique' => 'Email must be unique',
        ]);

        $user = new User;
        $user->name = $request->nama_pemesan;
        $user->nohp = $request->no_hp_pemesan;
        $user->email = $request->email;
        $user->password = bcrypt($request->idotp);
        $user->api_token = str_random(100);
        $user->save();
        Auth::login($user);

        $stateArr = explode(" ", $request->state);
        if($stateArr[0] == "list-harga"){
            return redirect()->route($stateArr[0],[$stateArr[1]]);
        }
        return redirect()->route($stateArr[0]);
    }

    public function logoutOtp(Request $request) {
        Auth::logout();
        return redirect()->route('home');
    }
}
