<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Logs;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
        	'firstname' => $request->firstname,
        	'lastname' => $request->lastname,
        	'date_of_birth' => $request->date_of_birth,
        	'username' => $request->username,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
         ]);

        $token = auth()->login($user);

        $this->log("User Signed up", $request->username." signed up");
        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $this->log("User logged in", " logged in");
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        $this->log("User logged out", " logged out");

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    public function log($action, $details) {
            $user = Auth::api();
            $id = $user->id;

            $log = new Logs();
            $log->userid = $user->id;
            $log->action = $action;
            $log->details = $details;
            $log->save();
            //$query = DB::table('logs')->insert(['userid' => $id, 'action' => $action, 'details' => $details]);                
              
    }
}
