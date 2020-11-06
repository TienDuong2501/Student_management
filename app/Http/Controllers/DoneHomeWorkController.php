<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeWork;
use App\Models\DoneHomeWork;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DoneHomeWorkCreateRequest;
use App\Http\Requests\DoneHomeWorkUpdateRequest;

class DoneHomeWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 1) {
            $doneHomeworks  = DoneHomeWork::orderBy('id', 'DESC')->paginate(10);

            return view('done_homework.index')->with(['done_homeworks' => $doneHomeworks]);
        }

        $doneHomeworks  = DoneHomeWork::where('student_id', auth()->id())->orderBy('id', 'DESC')->paginate(10);

        return view('done_homework.index')->with(['done_homeworks' => $doneHomeworks]);

        // return redirect()->route('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $homeworks = HomeWork::get();
        return view('done_homework.create')->with(['homeworks' => $homeworks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoneHomeWorkCreateRequest $request)
    {
        if ($request->hasFile('result')) {
            $file = $request->result;
            $prefixPath = 'answers-uploaded-files/' . now()->format('Ymd');

            $uploadedFile = Storage::disk('public')->putFile($prefixPath, $file);
            DoneHomeWork::create([
                'home_work_id' => $request->home_work_id,
                'student_id' => auth()->id(),
                'result' => $uploadedFile,
                'description' => $request->description,
                'original_name' => $file->getClientOriginalName(),
                'saved_path' => $uploadedFile,
            ]);

            return redirect()->route('done_homeworks.index')->with(['success' => 'created homework successfully']);
        }

        return redirect()->route('done_homeworks.index')->with(['error' => 'created homework failed']);
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
    public function edit(DoneHomeWork $done_homework)
    {
        $homeworks = HomeWork::get();
        return view('done_homework.edit')->with(['doneHomeWork' => $done_homework, 'homeworks' => $homeworks]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoneHomeWorkUpdateRequest $request, DoneHomeWork $done_homework)
    {
        if ($request->hasFile('result')) {
            $file = $request->result;
            $prefixPath = 'answers-uploaded-files/' . now()->format('Ymd');
            Storage::disk('public')->delete($done_homework->saved_path);
            $uploadedFile = Storage::disk('public')->putFile($prefixPath, $file);
            $done_homework->home_work_id = $request->home_work_id;
            $done_homework->student_id = auth()->id();
            $done_homework->result = $uploadedFile;
            $done_homework->description = $request->description;
            $done_homework->original_name = $file->getClientOriginalName();
            $done_homework->saved_path = $uploadedFile;
            $done_homework->save();

            return redirect()->route('done_homeworks.index')->with(['success' => 'updated answers successfully']);
        }
        $done_homework->home_work_id = $request->home_work_id;
        $done_homework->description = $request->description;
        $done_homework->save();

        return redirect()->route('done_homeworks.index')->with(['success' => 'updated answers successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoneHomeWork $done_homework)
    {
        Storage::disk('public')->delete($done_homework->saved_path);

        if ($done_homework->delete()) {
            return redirect()->route('done_homeworks.index')->with(['success' => 'deleted answer successfully']);
        }

        return redirect()->route('done_homeworks.index')->with(['error' => 'deleted answer failed']);
    }
}
