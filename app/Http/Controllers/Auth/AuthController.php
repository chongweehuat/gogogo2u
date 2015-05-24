<?php namespace App\Http\Controllers\Auth;

use Redirect;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->registrar->create($request->all());

		flash('Thanks for signing up! Please check your email.');

		return redirect('/auth/login');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt(array_merge($credentials, ['confirmed' => 1]), $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
			->withInput($request->only('email', 'remember'))
			->withErrors([
				'email' => 'Credentials are invalid or email is not confirmed.',
			]);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param $confirmation_code
	 * @return \Illuminate\Http\Response
	 */
	public function getConfirm($confirmation_code)
	{
		if( ! $confirmation_code)
		{
			return $this->invalidConfirmationCodeRedirect();
		}

		$user = User::whereConfirmationCode($confirmation_code)->first();

		if ( ! $user)
		{
			return $this->invalidConfirmationCodeRedirect();
		}

		$user->confirmed = 1;
		$user->confirmation_code = null;
		$user->save();

		flash()->success('You have successfully verified your account.');

		return Redirect::to('/auth/login');
	}

	public function getResendConfirmationCode()
	{
		return view('auth/resend-confirmation-code');
	}

	public function postResendConfirmationCode(Request $request)
	{
		$user = User::where('email', $request->get('email'))->first();

		if (! $user)
		{
			return redirect($this->loginPath())
				->withInput($request->only('email'))
				->withErrors([
					'email' => 'User with such email does not exists',
				]);
		}

		$this->registrar->sendConfirmationEmail($user);

		flash('Email with confirmation link was sent');

		return Redirect::back();
	}

	private function invalidConfirmationCodeRedirect()
	{
		flash()->error('Confirmation code is invalid');
		return Redirect::to('/');
	}
}
