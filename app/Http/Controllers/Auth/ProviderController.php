<?php namespace App\Http\Controllers\Auth;

use App\UserOauth;
use Auth;
use Socialize;
use Redirect;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProviderController extends Controller {

	protected $providers = ['google', 'facebook'];

	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
	}

	public function getLogin($provider = null)
	{
		if (! in_array($provider, $this->providers)) throw new NotFoundHttpException();

		return Socialize::with($provider)->redirect();
	}

	public function getCallback($provider)
	{
		$socializeUser = Socialize::with($provider)->user();

		if ($currentUser = Auth::user())
		{
			UserOauth::create([
				'provider' => $provider,
				'provider_user_id' => $socializeUser->id,
				'user_id' => $currentUser->id,
			]);

			return Redirect::intended('home#');
		}

		$userOauth = UserOauth::where('provider', $provider)->where('provider_user_id', $socializeUser->getId())->first();

		if (! $userOauth)
		{
			$userOauth = UserOauth::create([
				'provider' => $provider,
				'provider_user_id' => $socializeUser->id,
			]);
		}

		$user = $userOauth->user;

		$userEmail = $socializeUser->getEmail();

		if (! $userEmail) $userEmail = $socializeUser->getId() . '@' . $provider . '.com';

		if (! $user) {
			$user = User::where('email', $userEmail)->first();

			if (! $user) {
				$user = $this->registrar->create([
					'name' => $socializeUser->getName(),
					'email' => $userEmail,
					'password' => $this->generatePassword(),
				], false);
			}

			$userOauth->user_id = $user->id;
			$userOauth->save();
		}

		$this->auth->login($user, true);

		return Redirect::intended('home#');
	}

	private function generatePassword($length = 10)
	{
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	public function getDisconnect($providerName)
	{
		$currentUser = Auth::user();

		$currentUser->socialiteProviders()->where('provider', $providerName)->delete();

		return Redirect::back();
	}

}
