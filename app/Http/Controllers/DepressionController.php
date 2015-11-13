<?php namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use Hash;
use App\Setting;
use App\Depression;

class DepressionController extends Controller
{
	
/*
|--------------------------------------------------------------------------
| User Controller
|--------------------------------------------------------------------------
|
| 
|
*/
	public function adminForm( ){
		return View::make('admin.index');
	}

	public function handleAdmin( ){
		$data = Request::only([
					'password' => 'required',
					'choice'
				]);

		dd( $data );

		return Redirect::route('admin');
	}

	public function areYouDepressed( $encryptedPassword, $isDepressed ){
		$decryptedPassword = Crypt::decrypt($encryptedPassword);

		$storedPassword = Setting::where('name', 'password');

		if( Hash::make( $decryptedPassword ) == $storedPassword ){
			Depression::create( [ 'is_depressed' => $isDepressed ]);
		} else {
			abort(404);
		}
	}
}
