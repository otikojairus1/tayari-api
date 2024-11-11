<?php

namespace App\Http\Controllers;

use App\Mail\ScoreNotice;
use App\Mail\SendBroadcastEmail;
use App\Mail\SendOtpMail;
use App\Models\Kid;
use App\Models\ParentModel;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . ParentModel::class],
            'password' => ['required'],
            'account_type' => [''],
            'phone' => ['required'],
            'otp' => ['required'],
            'country' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['success' => false, 'data' => $response]);
        }

        $user = ParentModel::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'account_type'=>$request->account_type ? $request->account_type : null,
            'otp' => mt_rand(1000, 9999),
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->string('password')),
        ]);
        Mail::to($user->email)->send(new SendOtpMail($user));
        return response()->json(['success' => true, 'data' => $user]);
    }
    public function broadcast_email(Request $request){
            $users = ParentModel::all();     

        foreach($users as $user){
            $details = [
                'user'=>$user,
                'subject'=>$request->subject,
                'content'=>$request->content
            ];
            Mail::to($user->email)->send(new SendBroadcastEmail($details));
        }
         return response()->json(['success' => true, 'data' => $users]);


    }
    public function update_user(Request $request){
         $user = ParentModel::where('id', $request->id)->first();
        if ($user) {
            $data = $request->all();            
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $user->update($data);
        }
        return response()->json(['success' => true, 'data' => $user]);

    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['success' => false, 'data' => $response]);
        }

        $user = ParentModel::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'data' => 'wrong USER ACCOUNT used']);

        }
        if (Hash::check($request->password, $user->password)) {
            return response()->json(['success' => true, 'data' => $user]);
        }

        return response()->json(['success' => false, 'data' => 'wrong password used']);

    }

    

       public function register_admin(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . ParentModel::class],
            'password' => ['required'],
            // 'account_type'=>['required'],
            'phone' => ['required'],
            'otp' => ['required'],
            'country' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['success' => false, 'data' => $response]);
        }

        $user = ParentModel::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'account_type' => 'ADMIN',
            'otp' => mt_rand(1000, 9999),
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->string('password')),
        ]);
        Mail::to($user->email)->send(new SendOtpMail($user));
        return response()->json(['success' => true, 'data' => $user]);
    }


    public function get_all_system_users(){
        return response()->json(['success' => true, 'data' => ParentModel::where('account_type' ,'!=', null)->get()]);
        
    }

    public function register_teacher(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . ParentModel::class],
            'password' => ['required'],
            // 'account_type'=>['required'],
            'phone' => ['required'],
            'otp' => ['required'],
            'country' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['success' => false, 'data' => $response]);
        }

        $user = ParentModel::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'account_type' => 'TEACHER',
            'otp' => mt_rand(1000, 9999),
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->string('password')),
        ]);
        Mail::to($user->email)->send(new SendOtpMail($user));
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function add_kids(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => ['required'],
            'child_name' => ['required', 'string', 'max:255'],
            'child_dob' => ['required'],
            'user_level' => ['required'],
            'current_day' => ['required'],
            'current_unit' => ['required'],
            'content_progress' => ['required'],
            'streaks' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['success' => true, 'data' => $response]);
        }

        $user = Kid::create([
            'parent_id' => $request->parent_id,
            'child_name' => $request->child_name,
            'child_dob' => $request->child_dob,
            'user_level' => $request->user_level,
            'current_day' => $request->current_day,
            'current_unit' => $request->current_unit,
            'content_progress' => $request->content_progress,
            'streaks' => $request->streaks
        ]);
        return response()->json(['success' => true, 'data' => $user]);


    }


    public function update_kids(Request $request, $id)
    {
        $kid = Kid::find($id);
        // $kid->update($request->all());

        // Check if 'streaks' is in the request
        if ($request->has('streaks')) {
            // Add the request streaks to the current streaks
            $kid->streaks += $request->input('streaks');
        }

        // Update the other attributes
        $kid->update($request->except('streaks'));

        return response()->json(['success' => true, 'data' => $kid]);

    }


    public function modify_parents(Request $request, $id)
    {

        $parent = ParentModel::find($id);
        if ($parent) {
            $parent->update($request->all());
        return response()->json(['success' => true, 'data' => $parent]);

        }
        return response()->json(['success' => false, 'data' => 'no parent matches the details']);
    }


    public function verify(Request $request){
        $validator = Validator::make($request->all(), [
            'otp' => ['required'],
            'id' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['success' => true, 'data' => $response]);
        }
        $user = ParentModel::where('otp',$request->otp)->where('id',$request->id)->first();
        if(!$user){
            return response()->json(['success' => false, 'data' => 'invalid code']);
        }
        $user->otp = 'VERIFIED';
        $user->save();
        return response()->json(['success' => true, 'user_account_type'=>$user->account_type, 'data' => 'verified']);
    }

    public function get_kids(Request $request, $id)
    {
        $kid = Kid::where('parent_id', $id)->get();
        return response()->json(['success' => true, 'data' => $kid]);

    }


    public function get_all_kids()
    {
        $kid = Kid::all();
        return response()->json(['success' => true, 'data' => $kid]);

    }


    public function get_all_kids_by_parent($id)
    {
        $kid = Kid::where('parent_id', $id)->get();
        return response()->json(['success' => true, 'data' => $kid]);

    }

    


    public function add_kid_homework_progress(Request $request){
        $validator = Validator::make($request->all(), [
            'kid_id' => ['required'],
            'level' => ['required'],
            'day' => ['required'],
            'unit' => ['required'],
            'homework_score' => ['required'],
        ]);
        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['success' => true, 'data' => $response]);
        }
        $score = Score::updateOrCreate(
            [
                'kid_id' => $request->kid_id,
                'level' => $request->level,
                'day' => $request->day,
                'unit' => $request->unit,
            ],
            [
                'homework_score' => $request->homework_score,
            ]
        );
        // send notice
        $kid = Kid::where('id', $request->kid_id)->first();
        $parent = ParentModel::where('id', $kid->id)->first();
        Mail::to($parent->email)->send(new ScoreNotice($kid));
        return response()->json(['success' => true, 'data' => $score]);        
    }

    public function fetch_scores(Request $request, $id){
        $scores = Score::where('kid_id', $id)->with('kid')->get();
        return response()->json(['success' => true, 'data' => $scores]);
    }
}
