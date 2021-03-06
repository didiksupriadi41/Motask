<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Applicant;
use Auth;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $requester_id = Auth::user()->id;
        $requester = User::find($requester_id);
        if ($requester == null) {
            abort(404);
        }

        // Deny access on others profile except for admin
        if (Auth::user()->id != $id && $requester->role != 'admin' && $requester->role != 'project_manager') {
            abort(403);
        }

        //retrieve user
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }

        // Deny access on admin's profile
        if ($user->role == 'admin' && $requester->role != 'admin') {
            abort(403);
        }

        $projectsOpened = array();
        $projectsUnOpened = array();
        $applied = array();
        //retrieve projects based on role
        if ($user->role == 'project_manager') {
            $projectsOpened = Project::where([['created_by', $user->email], ['status', 'Open']])->get();
            $projectsUnOpened = Project::where([['created_by', $user->email], ['status', '!=', 'Open']])->get();
        } elseif ($user->role == 'admin') {
            $projectsOpened = Project::where('status', 'Open')->get();
            $projectsUnOpened = Project::where('status', '!=', 'Open')->get();
        } elseif ($user->role == 'marketing') {
            $projectsOpened = Project::where([['created_by', $user->email], ['status', 'Open']])->get();
            $projectsUnOpened = Project::where([['created_by', $user->email], ['status', '!=', 'Open']])->get();
        }

        if ($user->role != 'programmer') {
            foreach ($projectsOpened as $project) {
                $project->applicants = Applicant::where('project_id', $project->id)->count();
            }
        }

        $applications = array();
        $applications = Applicant::where('applicant_id', Auth::user()->id)->get();
        if (!($applications->isEmpty())) {
            foreach ($applications as $ap) {
                $project = Project::find($ap->project_id);
                $ap->project_title = $project->title;
                $ap->status = $project->status;
                $ap->deadline = $project->deadline;
                if ($project->manpro_id == null) {
                    $ap->manpro = 'None';
                } else {
                    $ap->manpro = User::find($project->manpro_id)->name;
                }
            }
        }

        return view('user', [
            'user' => $user,
            'projectsOpened' => $projectsOpened,
            'projectsUnOpened' => $projectsUnOpened,
            'applied' => $applications,
            ]);
    }

    public function update(Request $request, $id)
    {
        $requester_id = Auth::user()->id;
        $requester = User::find($requester_id);
        if ($requester == null) {
            abort(404);
        }

        //deny edit other's profile
        if (Auth::user()->id != $id) {
            abort(403);
        }

        //retrieve user
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'line' => 'required|max:255',
            'phone' => 'required|max:255',
            'linkedin' => 'required|max:255',
            'git' => 'required|max:255',
            'resume' => 'nullable|file|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        // $this->authorize('update', $requester);

        $requester->phone = $request->phone;
        $requester->linkedin = $request->linkedin;
        $requester->git = $request->git;
        if ($requester->line != null) {
            $requester->line = $request->line;
        } 
        if ($requester->phone != null) {
            $requester->phone = $request->phone;
        } 
        if ($requester->linkedin != null) {
            $requester->linkedin = $request->linkedin;
        } 
        if ($requester->git != null) {
            $requester->git = $request->git;
        } 
        if($request->hasFile('resume')){
            $filenameWithxt = $request->file('resume')->getClientOriginalName();
            $filename = pathinfo($filenameWithxt, PATHINFO_FILENAME);
            $ext = $request->file('resume')->getClientOriginalExtension();
            if($requester->resume != null){
                $filenameToStore = Auth::user()->name.'.'.$ext;
                $path = $request->file('resume')->storeAs('public/resumes', $filenameToStore);
            } else {
                if(\File::exists(public_path('resumes/'.Auth::user()->name.'.'.$ext))){
                    \File::delete(public_path('resumes/'.Auth::user()->name.'.'.$ext));
                }
                $filenameToStore = Auth::user()->name.'.'.$ext;
                $path = $request->file('resume')->storeAs('public/resumes', $filenameToStore);
            }
            $requester->resume = $filenameToStore;
        } 
        $requester->save();

        return redirect('/user/'.$requester_id);
    }

    public function edit($id)
    {
        $requester_id = Auth::user()->id;
        $requester = User::find($requester_id);
        if ($requester == null) {
            abort(404);
        }

        //deny edit other's profile
        if (Auth::user()->id != $id) {
            abort(403);
        }

        //retrieve user
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }

        return view('user.edit', [
            'user' => $user,
            ]);
    }
}
