<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use App\Users;
use App\Countries;
use App\Country_codes;
use App\timezones;
use App\edit_profile_settings;
use App\cms_email_templates;
use App\user_profiles;
use Session;
use Mail;
class EditProfileController extends Controller
{
    protected $url;
    public function __construct(UrlGenerator $url)
    {
        parent::__construct();
        $this->url = $url;
    }

    public function methodName()
    {
        $this->url->to('/');
    }
   
   public function index()
   {
        if(Session::get('user_id') == '')
        {
            return redirect(url('login'));
        }else{
            $userId = Session::get('user_id');
            $get_country = Countries::get();
            $FetchUserData = Users::where('id',$userId)->get();
            $FetchEditDataSettings = edit_profile_settings::where('user_id',$userId)->get();
            $GetTimezone = timezones::get();
            return view('profile_edit',compact('FetchUserData','get_country','GetTimezone','FetchEditDataSettings'));
        }
   }
   
   public function updateProfile(Request $request)
   {
        $userId = Session::get('user_id');
        $base_url = $this->url->to('/');
        $random_code = 'BTG'.rand(0,100000);
        $activation_link = $base_url.'/activation/'.$random_code;
        $email_verify = $request->input('email');
        $CheckEmail =  Users::where('id',$userId)->get();
        if($CheckEmail[0]->email != $email_verify)
        {
            $data = array('random_code'=>$random_code,'email_verification'=>$CheckEmail[0]->email_verification +1);
            $UpdateFieldEmailVerify = Users::where('id',$userId)->update($data);
            $records = cms_email_templates::where('slug','emailId_change_from_profile')->get()->toArray();
            if(count($records) > 0)
            {
                $username = $CheckEmail[0]->name;
                $msg = preg_replace("/&#?[a-z0-9]+;/i","",$records[0]['content']);
                $msg = str_replace("[user]",$username,$msg);
                $msg = str_replace("[confirm]",$activation_link,$msg);
                $data['msg'] = $msg; 
                Mail::send('mail_template', $data, function($message) use($email_verify){
                    $message->to($email_verify)->subject('Email verification link');
                });
            }
        }
        if($request->file('image') != 0)
        {
            $filename = $_FILES[image][name];
            $image = $request->file('image');
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $input['imagename'] = $filename;
            $destinationPath = public_path('assets/front_end/images');
            $image->move($destinationPath, $input['imagename']);
            $UpdatedData = array('email'=>$email_verify,
                          'age_group'=>$request->input('age_group'),
                          'gender'=>$request->input('gender'),
                          'country_id'=>$request->input('country'),
                          'country_code'=>$request->input('country_code'),
                          'contact_no'=>$request->input('contact_no'),
                          'currency'=>$request->input('currency'),
                          'city'=>$request->input('city'),
                          'random_code'=>$random_code,
                          'updation_date'=>date("Y-m-d H:i:s"),
                          'profile_picture'=>$input['imagename']
                          );
            $updateUsersData = Users::where('id',$userId)->update($UpdatedData);
            if($updateUsersData == true)
            {
                $request->session()->flash('success','Profile updated successfully.');
                echo 'success';
            }
            else{
                $request->session()->flash('status','Something went wrong!Please try again.');
                echo 'error';
            }
        }
        else{
            $UpdatedData = array('email'=>$email_verify,
                          'age_group'=>$request->input('age_group'),
                          'gender'=>$request->input('gender'),
                          'country_id'=>$request->input('country'),
                          'country_code'=>$request->input('country_code'),
                          'contact_no'=>$request->input('contact_no'),
                          'currency'=>$request->input('currency'),
                          'city'=>$request->input('city'),
                          'random_code'=>$random_code,
                          'updation_date'=>date("Y-m-d H:i:s"),
                          );
            $updateUsersData = Users::where('id',$userId)->update($UpdatedData);
            if($updateUsersData == true)
            {
                $request->session()->flash('success','Profile updated successfully.');
                echo 'success';
            }
            else{
                $request->session()->flash('status','Something went wrong!Please try again.');
                echo 'error';
            }
        }
   }
   
   public function EditSettingsFormSubmit(Request $request)
   {
        $userId = Session::get('user_id');
        if($request->input('Comment') == 1)
        {
            $comment = 1;
        }else{
            $comment = 0;
        }
        if($request->input('Mention') == 1)
        {
            $mention = 1;
        }else{
            $mention = 0;
        }
        if($request->input('Follow') == 1)
        {
            $follow = 1;
        }else{
            $follow = 0;
        }if($request->input('Badges') == 1)
        {
            $badges = 1;
        }else{
            $badges = 0;
        }
        $data = array('user_id'=>$userId,
                      'timezone'=>$request->input('timezone'),
                      'oddsFormat'=>$request->input('oddsFormat'),
                      'comment'=>$comment,
                      'mention'=>$mention,
                      'follow'=>$follow,
                      'badges'=>$badges,
                      'creation_date'=>date("Y-m-d H:i:s"),
                      'updation_date'=>date("Y-m-d H:i:s")
                      );
        //print_r($data);die;
        $checkUser = edit_profile_settings::where('user_id',$userId)->get()->toArray();
        if(!empty($checkUser))
        {
            $UpdateEditSettings = edit_profile_settings::where('user_id',$userId)->update($data);
            $request->session()->flash('success', 'Profile successfully updated');
            return redirect(url('edit-profile'));
        }else{
            $InsertEditSettings = edit_profile_settings::insert($data);
            $request->session()->flash('success', 'Profile successfully updated');
            return redirect(url('edit-profile'));
        }
        
        
   }
   
    public function accountActivation($id,Request $request)
    {
        if($id =='')
        {
            $request->session()->flash('success','You have already verified.');
            return redirect(url('login'));
        }
        $data = array('random_code'=>'','email_verification'=>0);
    	$query = Users::where('random_code',$id)->update($data);
        Session::forget('user_id');
        $request->session()->flash('success', 'You have successfully verified!Please login to continue.');
        return redirect(url('login'));
    }
   
   public function UpdateBio(Request $request)
   {
        $SelectedTab = $request->input('SelectedTab');
        Session::put('LastSelectedTab', $SelectedTab);
        $userId = Session::get('user_id');
        $Bio = $request->input('bio');
        $data = array('user_id'=>$userId,'bio'=>$Bio,'creation_date'=>date("Y-m-d H:i:s"),'updation_date'=>date("Y-m-d H:i:s"));
        $CheckUser = user_profiles::where('user_id',$userId)->get()->toArray();
        if(empty($CheckUser))
        {
            $InsertQuery = user_profiles::insert($data);
            $request->session()->flash('success', 'Your bio has been added');
            echo 'success';
        }else{
            $data = array('bio'=>$Bio,'updation_date'=>date("Y-m-d H:i:s")); 
            $UpdateQuery = user_profiles::where('user_id',$userId)->update($data);
            $request->session()->flash('success', 'Your bio has been updated');
            echo 'success';
        }
   }
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   public function TestPage()
   {
        return view('test_page');
   }
   
   public function test_upload(Request $request)
   {
        $allowed = array('csv') ;
		$filename1 = $_FILES['file']['name'];
        /*if($filename1 == '')
		{
			//$this->session->set_flashdata('error_message','No file selected.Please try again');
			//redirect(base_url('testing'));
		}
		$ext = pathinfo($filename1, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
			//$this->session->set_flashdata('error_message','Invalid File:Please Upload CSV File.');
			//redirect(base_url('testing'));
		}else
		{*/
			if($_FILES["file"]["size"] > 0)
			{
				$filename=$_FILES["file"]["tmp_name"];
                $file = fopen($filename, "r");
                ini_set("set_time_limit",0);
                ini_set("memory_limit","256M");
                ini_set('max_execution_time', 5000);
				while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
				{
				    //echo "<pre>";
                    //print_r($emapData);
                    /*$data = array('bookmaker_name'=>$emapData[0],
                                  'bookmaker_url'=>null,
                                  'status'=>1,
                                  'creation_date'=>date("Y-m-d H:i:s"),
                                  'updation_date'=>date("Y-m-d H:i:s")
                                  );*/
                    $data = array('CC'=>$emapData[0],
                                  'Coordinates'=>$emapData[1],
                                  'TZ'=>$emapData[2],
                                  'Comments'=>$emapData[3],
                                  'UTC offset'=>$emapData[4],
                                  'UTC DST offset'=>$emapData[5],
                                  'creation_date'=>date("Y-m-d H:i:s")
                                  );
                    $insert_data = timezones::insert($data);           
                
                }
                fclose($file);
                return view('test_page');
            }
        //}
    }
}
?>