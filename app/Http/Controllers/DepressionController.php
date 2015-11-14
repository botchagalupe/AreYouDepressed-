<?php namespace App\Http\Controllers;

use View;
use Auth;
use Response;
use Redirect;
use Request;
use Validator;
use Hash;
use URL;
use Crypt;
use App\Setting;
use App\Depression;

use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

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
					'password',
					'choice'
				]);

		$validator = Validator::make( $data, [
		                    'password'  => 'required',
		                    'choice'     => 'required'
		                ]);

		$encryptedPassword = Crypt::encrypt( $data['password'] );

		$this->areYouDepressed( $encryptedPassword, $data['choice'] );

		return Redirect::route('admin');
	}

	public function areYouDepressed( $encryptedPassword, $isDepressed ){
		$decryptedPassword = Crypt::decrypt($encryptedPassword);

		try{
			$storedPassword = Setting::where('name', 'password')->firstOrFail( );
			if( Hash::check( $decryptedPassword, $storedPassword->setting )  ){
				Depression::create( [ 'is_depressed' => $isDepressed ]);
			} else {
				abort(404);
			}
		} catch( ModelNotFoundException $e ){
			echo "Please set a password for admin by adding your password to the .env file and going to " . URL::to('/') . "/password";
			dd();
		}
	}

	public function setPassword( ){
		$hashedPassword = Hash::make( env('ADMIN_PASSWORD') );

		try {
			$passwordSetting = Setting::where('name', 'password')->firstOrFail( );
			$passwordSetting->setting = $hashedPassword;
			$passwordSetting->save();
		} catch ( ModelNotFoundException $e) {
			Setting::create(['name' => 'password', 'setting' => $hashedPassword]);
		}

		return Redirect::route('admin');
	}

	public function areTheyDepressed( ){
		try {
			$depressionStatus = Depression::firstOrFail();
			$depressionStatus = $depressionStatus->is_depressed;
		} catch (ModelNotFoundException $e) {
			$depressionStatus = 'Unknown';
		}

		return View::make('depression.index')->with('depressionStatus', $depressionStatus);
	}
}
