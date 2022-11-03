<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Image;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            // laravel Static email pass check function

            // $validated = $request->validate([
            //     'email' => 'required|email|max:255',
            //     'password' => 'required',
            // ]);


            // Custom Email Password Check

                $rules = [
                    'email' => 'required|email|max:255',
                    'email.email' => 'Valid Email is required',
                    'password.required' => 'Password is required',
                ];
                $rules = [
                    'email' => 'required|email|max:255',
                    'password' => 'required',
                ];
                $customMessages = [
                    'email.required' => 'Email is required',
                    'email.email' => 'Valid Email Address is required',
                    'password.required' => 'Password is required',
                ];
                $this->validate($request,$rules,$customMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message','Invalid Emal or Password');
            }

            
        }
        // echo $password = Hash::make('123456'); die();
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
    public function checkAdminPassword(Request $request){
        $data = $request->all();
        // echo "<pre>";
        // print_r($data);die;
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    function updateAdminPassword(Request $request){
        // echo "<pre>"; print_r(Auth::guard('admin')->user());die();
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);die();
            // Check if current password entered by admin is correct
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                // Check if new password is matching with confirm password
                if($data['new_password']==$data['confirm_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('Success_message','Your New password is Updated Successfully!');
                }else{
                    return redirect()->back()->with('error_message','Your New password is not matched with Confirm Password!');

                }
            }else{
                return redirect()->back()->with('error_message','Your Current password is Incorrect!');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function updateAdminDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die();

            $rules= [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Number is required',
            ];
            $this->validate($request,$rules,$customMessages);
            
            // Upload Admin Image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                // echo "<pre>"; print_r($image_tmp); die();
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // echo "<pre>"; print_r($extension); die();
                    // Generate new image name
                    $imageName = rand(111,9999).'.'.$extension;
                    // echo "<pre>"; print_r($imageName); die();
                    $imagePath = 'admin/images/photos/'.$imageName;
                    // echo "<pre>"; print_r($imagePath); die();
                    // Upload Image
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName="";
            }

            //Update Admin Detail
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            return redirect()->back()->with('Success_message','Admin details updated successfully!');
        }
        return view('admin.settings.update_admin_details');
    }
}
