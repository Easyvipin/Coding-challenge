<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interview;
use App\User;
use Illuminate\Support\Str;

class InterviewController extends Controller
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
        $interviews = Interview::all();

        return view('home')->with('interviews', $interviews);
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
        $file = $request->file('video');
        $name = time().$file->getClientOriginalName();
        // $file->move('/storage/available', $name);
        $file->storeAS('public/available', $name);

        $data = array_merge(['video' => "/storage/available/{$name}"], $request->all());

        $interview = new Interview;
        $interview->name = $request->input('name');
        $interview->slug = Str::slug($request->input('name', '-'));
        $interview->time = $request->input('time');
        $interview->note = $request->input('note');
        $interview->video = $name;
        if($interview->save()) {
            $request->session()->flash('success', ' Interview added');
        }else{
            $request->session()->flash('error', 'There was an error adding ');
        }


        return redirect()->back()->with('success', 'Interview Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interview = Interview::where('id', $id)->first();

        return view('interview.show')->with('interview', $interview);
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
    public function destroy($id)
    {
        //
    }
    public function add(Request $request)
    {
        // print_r("hello");
        // print_r($request->all());
        // exit();
        // dd($request);
        //
        if ($request->hasFile('video')) {

            $file = $request->file('video');
            $path = 'uploads/';
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = 'webm';
            $fileNameToStore = preg_replace('/\s+/', '_', $filename . '_' . time() . '.' . $extension);

            \Storage::disk('public')->putFileAs($path, $file, $fileNameToStore);

            $media = Media::create(['file_name' => $fileNameToStore]);

            return  response()->json(['success' => ($media) ? 1 : 0, 'message' => ($media) ? 'Video uploaded successfully.' : "Some thing went wrong. Try again !."]);
        }
    }

}
