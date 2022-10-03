<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PasswordReset;
use App\School;
use Mail;
use Redirect;
use Session;
use Hash;
use Auth;
class UserController extends Controller
{
    public function loginFrom(){
    	return view("login");
    }
    /*****Login as School*****/
    public function login(Request $request){
        $validatedData = $request->validate([
            'email'    => 'required',
            'password' => 'required'
        ]);

        $email      = $request['email'];
        $password   = $request['password'];
        if(Auth::attempt(['email' => $email, 'password' => $password, 'type' => "S" ])){
            if(Auth::user()->status == "0"){
                Auth::logout();
                return Redirect::to("/login")->with("error","Your accout has been suspended");
                die;
            }
            return Redirect::to('/');
        }else{
            return Redirect::back()->with("error","You have entered invaild credentails, please try again");
        }
    }

    /*****Forgot Password*****/
    public function forgotPassword(){
    	return view("forgot-pasword");
    }

    /*****Request To Reset Password(email goes for reset password)*****/
    public function requestPassword(Request $req){
        $validatedData = $req->validate([
	        'email' => 'required'
    	]);
        $email = trim($req['email']);
    	$checkEmailExist = User::where("email",$email)->first();
    	if(isset($checkEmailExist)){
    		$randomToken =  $this->generateRandomString(10);
            PasswordReset::where("email",$email)->delete();
            PasswordReset::insert(['email' => $email, 'token' => $randomToken, 'created_at' => date("Y-m-d H:i:s") ]);/*Insert token in the password_resets table--*/
    	   /*Send Email to user to reset passwors--*/
            $getUserName =  User::where("email",$email)->select("name")->first();
            $userName    =  $getUserName->name;
            $data = ["token" => $randomToken, "name" => $userName];
            Mail::send('Emails.reset-password', $data, function ($message) use ($email) {
                $msg = "Password Reset";
                $message->to($email)->subject('Restore: '.$msg);
            });
            return Redirect::back()->with("success","Password reset request has been successfully sent to your email");
        }else{
    		return Redirect::back()->with("error","This email is not registered with us, Please try again");
    	}
    }

    /*****Show Reset Password Form*****/
    public function resetPasswordForm($token){
        if(isset($token)){
            /*check if token exist in password_resets table--*/
           $checkTokenExist = PasswordReset::where("token",$token)->first();
           if(isset($checkTokenExist)){
             return view("reset-password",['reset_token' => $token]);
           }else{
              Session::flash('error', 'This link is expired'); 
              return Redirect::to("/login");
           }
        }else{
            /*check if token not exist--*/
            Session::flash('error', 'This link is invalid'); 
            return Redirect::to("/login");
        }
    }

    /*****Reset Password*****/
    public function resetPassword(Request $req){
       $token       = $req['reset-token'];
       $newPassword = $req['new_password'];
       $checkEmailIdFromToken = PasswordReset::where("token",$token)->first();
       if($checkEmailIdFromToken){
         $email    = $checkEmailIdFromToken->email;
         $password = Hash::make($newPassword);
         $getUserFromEmail = User::where("email",$email)->select("id","name")->first();
         $userId   = $getUserFromEmail->id;
         $userName = $getUserFromEmail->name;
         User::where("id",$userId)->update(["password" => $password]);/*update password in Users table*/
         School::where("user_id",$userId)->update(['plain_password' => $newPassword]);/*update plain_password in Schools table*/
         
         $data = ["name" => $userName];
         Mail::send('Emails.password-changed', $data, function ($message) use ($email) {
                $msg = "Password Changed";
                $message->to($email)->subject('Restore: '.$msg);
         });
         PasswordReset::where("email",$email)->delete();
         Session::flash('success', 'Password changed successfully'); 
         return Redirect::to("/login");
       }else{
         Session::flash('error', 'Password changed failed'); 
         return Redirect::to("/login");
       }
    }

    /*****Change Password*****/
    public function changePassword(Request $req){
        if(isset($req->change_for) && $req->change_for == "A"){
            $userId = Auth::guard("admin")->id();
            $checkEmailExist = User::where("email", $req['admin_email'])->where("id","!=",$userId)->count();
            if($checkEmailExist > 0){
                return $this->responseInJSON("-3","Email already taken");
                die;
            }
            $newEmail = $req['admin_email'];
        }else{
            $userId = Auth::id();
        }
        $school_name = $req['school_name'];
        User::where("id",$userId)->update(['name' => $school_name]);
        if(isset($req['principle_name']) && !empty($req['principle_name'])){
             $principleName = $req['principle_name'];
            School::where("user_id",$userId)->update(['principle_name' => $principleName]);
        }
       
        if((isset($req['new_password']) && !empty($req['new_password'])) || (isset($req['current_password']) && !empty($req['current_password']))){
            $getUserPasswordFromId = User::where("id",$userId)->select("email","password")->first();
            $databaseHashedPassword = $getUserPasswordFromId->password;
            $current_password = $req['current_password'];
            $newPassword     = $req['new_password'];
            
            if(!empty($current_password)){
                if(empty($newPassword)){
                    return $this->responseInJSON("-2","Enter new password");
                    die;
                }  
            }

            if(!empty($newPassword)){
                if(empty($current_password)){
                    return $this->responseInJSON("-1","Enter current password");
                    die;
                }  
            }

            /*If current and new password is set--*/
            if(Hash::check($current_password, $databaseHashedPassword)){
                $newPassword     = $req['new_password'];
                $newPasswordHash = Hash::make($newPassword);
                $updatedArray = ['password' => $newPasswordHash];
                if(isset($newEmail)){
                    $updatedArray['email'] = $newEmail;
                }
                User::where("id",$userId)->update($updatedArray);/*update Password/Email in user--*/
                School::where("user_id",$userId)->update(['plain_password' => $newPassword]);
                return $this->responseInJSON("1","Profile edited successfully");
                die;
            }else{
                return $this->responseInJSON("-1","Current Password not matched");
                die;
            }
        }else{
                if(isset($newEmail)){
                    $updatedArray = ['email' => $newEmail];
                    User::where("id",$userId)->update($updatedArray);
                }

              return $this->responseInJSON("1","Profile edited successfully");
        }
    }

     /*****LogOut School*****/
    public function logout(){
        Auth::logout();
        return Redirect::to("/login");  
    }
}
