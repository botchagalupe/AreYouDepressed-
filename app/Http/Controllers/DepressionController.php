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
use Mail;
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
					'choice',
					'lower_bound',
					'upper_bound',
					'name',
					'email',
					'settings'
				]);

		if( $data['settings'] != 'being-set'){
			// If we're just using yes or no
			$validator = Validator::make( $data, [
			                    'password'  => 'required',
			                    'choice'     => 'required'
			                ]);

	        if( $validator->fails( ) ){
	        	// If validation fails, redirect back to 
	        	// registration form with errors
	            return Redirect::back( )
	                    ->withErrors( $validator )
	                    ->withInput( );
	        }

			$this->areYouDepressed( $data['choice'], $data['password'] );
		} else{
			// If we're only setting settings
			
			$validator = Validator::make( $data, [
			                    'lower_bound'  	=> 'numeric|min:0|max:24',
			                    'upper_bound'   => 'numeric|min:0|max:24',
			                    'email' 		=> 'email',
			                    'password'  => 'required',
			                ]);

	        if( $validator->fails( ) ){
	        	// If validation fails, redirect back to 
	        	// registration form with errors
	            return Redirect::back( )
	                    ->withErrors( $validator )
	                    ->withInput( );
	        }

	        $name = Setting::where('name', 'name')->first();
			$email = Setting::where('name', 'email')->first();
			$email_period_lower_bound = Setting::where('name', 'email_period_lower_bound')->first();
			$email_period_upper_bound = Setting::where('name', 'email_period_upper_bound')->first();

			$name->setting = $data['name'];
			$name->save();
			$email->setting = $data['email'];
			$email->save();
			$email_period_lower_bound->setting = $data['lower_bound'];
			$email_period_lower_bound->save();
			$email_period_upper_bound->setting = $data['upper_bound'];
			$email_period_upper_bound->save();

		}

		

		return Redirect::route('admin');
	}

	public function handleEmail( $encryptedMessage ){
		$lastEmail = Setting::where('name', 'last_email')->first()->setting;

		if( (time() - $lastEmail) < (60 * 60) ){
			// If last email was less than 60 minutes ago
			// (Prevents clicking an old link)
			$choice = Crypt::decrypt($encryptedMessage);
			$this->areYouDepressed( $choice );

			// Make emails one-use-only
			$lastEmail = Setting::where('name', 'last_email')->first();
			$lastEmail->setting = time() - (60 * 60);
			$lastEmail->save();
		}

		return Redirect::route('admin');
	}

	public function areYouDepressed( $isDepressed, $password = null){

		if( $password == null ){
			Depression::create( [ 'is_depressed' => $isDepressed ]);
		} else {
			try{
				$storedPassword = Setting::where('name', 'password')->firstOrFail( );
				if( Hash::check( $password, $storedPassword->setting )  ){
					Depression::create( [ 'is_depressed' => $isDepressed ]);
				} else {
					abort(404);
				}
			} catch( ModelNotFoundException $e ){
				echo "Please set a password for admin by adding your password to the .env file and going to " . URL::to('/') . "/password";
				dd();
			}
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
			$depressionStatus = Depression::orderBy('created_at', "DESC")->firstOrFail();
			$depressionStatus = $depressionStatus->is_depressed;
		} catch (ModelNotFoundException $e) {
			$depressionStatus = 'Unknown';
		}

		return View::make('depression.index')->with('depressionStatus', $depressionStatus);
	}

	public static function sendEmail( ){
		$lowerBound = Setting::where('name', 'email_period_lower_bound')->first()->setting;
		$upperBound = Setting::where('name', 'email_period_upper_bound')->first()->setting;
		$currentHour = (int)date('H');

		$email = Setting::where('name', 'email')->first()->setting;
		$name = Setting::where('name', 'name')->first()->setting;

		$lastEmail = Setting::where('name', 'last_email')->first();
		$lastEmail->setting = time();
		$lastEmail->save();

		// Encrypt yes and no so people can't accidentally trigger a choice
		$yes = Crypt::encrypt( "yes" );
		$no = Crypt::encrypt( "no" );

		if( $currentHour <= $lowerBound && $currentHour >= $upperBound ){
			// Do not send emails unless they're outside the set bounds
			$baseUrl = URL::to('/');
			Mail::send('emails.reminder', ["yes" => $yes, "no" => $no, 'baseUrl' => $baseUrl], function ($m) use ($email, $name) {
	            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

	            $m->to($email, $name)->subject('Are You Depressed?');
	        });
		}
	}
}
