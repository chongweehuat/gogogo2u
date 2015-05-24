<?php namespace App\Services;

use App\User;
use Validator;
use Mail;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @param  bool  $emailConfirmation
	 * @return User
	 */
	public function create(array $data, $emailConfirmation = true)
	{
		$confirmation_code = str_random(30);

		// Do not save user until we send confirmation email,
		// if email fails user can just resubmit form
		$user = new User([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'confirmed' => 1,
		]);

		if ($emailConfirmation) {
			$user->confirmation_code = $confirmation_code;
			$user->confirmed = false;
			$this->sendConfirmationEmail($user);
		}

		$user->save();

		return $user;
	}

	public function sendConfirmationEmail($user)
	{
		Mail::send('emails.verify', compact('user'), function($message) use ($user) {
			$message->from('chongweehuat@gmail.com', 'Gogogo2u');
			$message->to($user->email, $user->name)
				->subject('Verify your email address');
		});
	}

}
