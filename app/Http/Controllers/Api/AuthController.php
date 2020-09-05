<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    private $client;
    
    public function __construct(){
        $this->client = Client::find(2);
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'identificador' => 'required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($loginData)){
            return response()->json([],400);
        }

        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->identificador,
            'password' => $request->password,
            'scope' => '*',
        ];

        $proxy = Request::create('oauth/token', 'POST', $params);
        $usuario = User::where('identificador','=',$request->identificador)->first();
        $nombre = $usuario->nombre_completo();
        $response = app()->handle($proxy);
        $responseBody = json_decode($response->getContent(), true);
        User::where('identificador',$request->identificador)->update(['token' => $request->token]);
        return $responseBody + ['role' => $usuario->role_id] + ['nombre' => $nombre];

        
    }



    public function logout(Request $request){
        User::where('identificador',Auth::user()->identificador)->update(['token' => null]);  
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);  

        $accessToken->revoke();
        return response()->json([],204);

    }
    
}
