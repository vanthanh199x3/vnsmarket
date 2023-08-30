<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\User;
use App\Models\Wallet;
use App\Models\UserWallet;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function credentials(Request $request){
        return ['email'=>$request->email,'password'=>$request->password,'status'=>'active','role'=>'admin'];
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
        // dd($provider);
     return Socialite::driver($provider)->redirect();
    }
 
    public function Callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if($user){
            Auth::login($user);
            
        }else{
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
                'role'          => 'user',
            ]);

            Auth::login($user);
            
            // create default wallet
            $wallets = Wallet::all();
            foreach($wallets as $wallet) {
                UserWallet::updateOrCreate([
                    'user_id' => Auth::id(),
                    'wallet_id' => $wallet->id, 
                ],[
                    'user_id' => Auth::id(),
                    'wallet_id' => $wallet->id,
                    'status' => 1,
                ]);
            }
        }
        
        Session::put('user', $userSocial->getEmail());
        if (session()->has('redirectLogin')) {
            return redirect()->to(session('redirectLogin'))->with('success','Bạn đã đăng nhập bằng ' . $provider . ' thành công');
        } else {
            return redirect()->route('home')->with('success','Bạn đã đăng nhập bằng ' . $provider . ' thành công');
        }
        // return redirect('/')->with('success','Bạn đã đăng nhập bằng ' . $provider . ' thành công');
    }
}
