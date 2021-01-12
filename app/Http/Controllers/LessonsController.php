<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Schoolclass;
use App\Director;
use App\Staff;
use App\Term;
use App\Arm;
use App\Classsubject;
use App\Lesson;
use Illuminate\Http\Request;
use Image;
use Storage;

use Illuminate\Support\Facades\DB;

class LessonsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of lessons for specific classsubject.
     *
     * @param  int  $id (ID of classsubject that referenced the listing)
     * @return \Illuminate\Http\Response
     */
    public function listing($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if($data['user']->role == 'Staff')
        {
            $db_check = array(
                'user_id'   => $data['user']->id,
                'school_id' => $data['school']->id
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('lessons.listing')->with($data);
    }

    /**
     * Show the form for creating video lesson.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function newvideo($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if($data['user']->role == 'Staff')
        {
            $db_check = array(
                'user_id'   => $data['user']->id,
                'school_id' => $data['school']->id
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('lessons.newvideo')->with($data);
    }

    /**
     * Show the form for creating audio lesson.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function newaudio($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if($data['user']->role == 'Staff')
        {
            $db_check = array(
                'user_id'   => $data['user']->id,
                'school_id' => $data['school']->id
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('lessons.newaudio')->with($data);
    }

    /**
     * Show the form for creating audio lesson.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function newphoto($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if($data['user']->role == 'Staff')
        {
            $db_check = array(
                'user_id'   => $data['user']->id,
                'school_id' => $data['school']->id
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('lessons.newphoto')->with($data);
    }

    /**
     * Show the form for creating text document lesson.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function newtext($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if($data['user']->role == 'Staff')
        {
            $db_check = array(
                'user_id'   => $data['user']->id,
                'school_id' => $data['school']->id
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('lessons.newtext')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'classsubject_id' => ['required'],
            'name'      => ['required', 'max:191'],
            'type'      => ['required', 'in:Video,Audio,Photo,Text'],
            'arm_count' => ['required', 'numeric']
        ]);
        
        $classsubject = Classsubject::find($request->input('classsubject_id'));
        if(empty($classsubject))
        {
            return redirect()->route('dashboard');
        }
        elseif($classsubject->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if($request->input('type') == 'Video' OR $request->input('type') == 'Audio')
        {
            $this->validate($request, [
                'medialink'      => ['required', 'url', 'max:191']
            ]);

            $medialink = $request->input('medialink');
        }
        elseif($request->input('type') == 'Photo')
        {
            $this->validate($request, [
                'photo' => ['required', 'image', 'max:1999']
            ]);

            if($request->hasFile('photo'))
            {
                $image = $request->file('photo');
                $filename = $school_id . '-' . time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/lesson_photo/' . $filename);
                Image::make($image)->save($location);
    
                $medialink = $filename;
            }
            else
            {
                $request->session()->flash('error', "An unexpected error occured!");
                return redirect()->route('lessons.newphoto', $classsubject->id);
            }
        }
        elseif($request->input('type') == 'Text')
        {
            $this->validate($request, [
                'text_document' => ['required','max:1999']
            ]);

            if($request->hasFile('text_document'))
            {
                if ($request->file('text_document')->isValid()) 
                {
                    $uploaded_file = $request->file('text_document');
                    $extension = $uploaded_file->getClientOriginalExtension();
                    if($extension != 'docx' && $extension !='doc' && $extension != 'xls' && $extension != 'xlsx' &&
                        $extension != 'pdf')
                    {
                        $request->session()->flash('error', "Invalid document file type.");
                        return redirect()->route('lessons.newtext', $classsubject->id);
                    }
                    $filename = $school_id . '-' . time() . '.' . $extension;
                    $path = $request->text_document->storeAs('lesson_docs', $filename);
        
                    $medialink = $filename;
                }
                else
                {
                    $request->session()->flash('error', "An unexpected error occured! Error code: 22.1");
                    return redirect()->route('lessons.newtext', $classsubject->id);
                }
            }
            else
            {
                $request->session()->flash('error', "An unexpected error occured!");
                return redirect()->route('lessons.newtext', $classsubject->id);
            }
        }
        
        $arm_count = $request->input('arm_count');

        $lesson = new Lesson;

        $lesson->school_id  = $school_id;
        $lesson->subject_id = $classsubject->subject_id;
        $lesson->term_id    = $term_id;
        $lesson->name       = $request->input('name');
        $lesson->type       = $request->input('type');
        $lesson->medialink  = $medialink;
        $lesson->user_id    = $user_id;

        $lesson->save();

        for ($i=0; $i < $arm_count; $i++) {
            if($request->input($i) > 0)
            {
                DB::insert('insert into arm_lesson (arm_id, lesson_id) values (?, ?)', [$request->input($i), $lesson->id]);
            }
        }

        $request->session()->flash('success', 'Lesson added.');

        return redirect()->route('lessons.listing', $classsubject->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id=0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            $request->session()->flash('error', 'Error 4' );
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'confirmation_to_delete' => ['required', 'in:DELETE'],
            'classsubject_id'        => ['required']
        ]);

        $lesson = Lesson::find($id);

        if(empty($lesson))
        {
            $request->session()->flash('error', 'Error 2: Attempt to delete unavailable resource.' );
            return redirect()->route('dashboard');
        }

        DB::delete('delete from arm_lesson where lesson_id = ?', [$id]);

        $lesson->delete();
        $request->session()->flash('success', 'Item deleted');
        
        return redirect()->route('lessons.listing', $request->input('classsubject_id'));
    }
}
