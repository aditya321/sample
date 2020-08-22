<?php

namespace App\Http\Controllers;

use App\FormData;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DataTables;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function submitForm(Request $request)
    {
        $formdata = FormData::whereEmail($request->email)->first();
        if(!$formdata) {
            $formdata = new FormData();
        }
        $imagePath = Storage::disk('public_uploads')->putFile('Profiles', $request->file('image'));
        $pdfPath = Storage::disk('public_uploads')->putFile('PDF', $request->file('resume'));
        $formdata->firstname = $request->firstname;
        $formdata->lastname = $request->lastname;
        $formdata->address = $request->address;
        $formdata->dob = date('Y-m-d', strtotime($request->dob));
        $formdata->image = $imagePath;
        $formdata->resume = $pdfPath;
        $formdata->city = $request->city;
        $formdata->country = $request->country;
        $formdata->password = Hash::make($request->password);
        $formdata->email = $request->email;
        $formdata->save();
        $data = array();
        $data['success'] = true;
        $data['message'] = "Form Submitted Successfully";
        return $data;
    }

    public function home(){
        $results = FormData::get();
        return view('admin.dashboard')->with('results', $results);
    }

    public function getFormData(Request $request){
        if($request->ajax())
        {
            $results = FormData::latest()->with('notes')->get();
            foreach ($results as $result){
                $noteData = "";
                foreach ($result->notes as $note){
                    if ($noteData == ""){
                        $noteData = $note->note;
                    }
                    else {
                        $noteData = $noteData.", ".$note->note;
                    }
                }
                $result->notesString = $noteData;
            }
            return DataTables::of($results)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm add-note">ADD Notes</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.dashboard');
    }

    public function addNote(Request $request){
        $note = new Note();
        $note->note = $request->note;
        $note->tags = $request->tags;
        $note->form_data_id = $request->id;
        $note->save();
        return $request;
    }
}
