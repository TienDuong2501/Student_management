<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeWork;
use App\Http\Requests\HomeWorkCreateRequest;
use App\Http\Requests\HomeWorkUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Response;

class HomeWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeworks = HomeWork::orderBy('id', 'DESC')->paginate(10);
        return view('homework.index')->with(['homeworks' => $homeworks, 'authUser' => auth()->user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role == 1) {
            return view('homework.create');
        }

        return redirect()->route('homeworks.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeWorkCreateRequest $request)
    {
        if (auth()->user()->role == 1) {
            if ($request->hasFile('home_work')) {
                $file = $request->home_work;
                $prefixPath = 'homework-uploaded-files/' . now()->format('Ymd');

                $uploadedFile = Storage::disk('public')->putFile($prefixPath, $file);
                HomeWork::create([
                    'name' => $request->name,
                    'home_work' => $request->name,
                    'original_name' => $file->getClientOriginalName(),
                    'saved_path' => $uploadedFile,
                    'hash' => Hash::make(now()->format('Ymd')),
                ]);

                return redirect()->route('homeworks.index')->with(['success' => 'created homework successfully']);
            }

            return redirect()->route('homeworks.index')->with(['error' => 'created homework failed']);
        }

        return redirect()->route('homeworks.index');
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
    public function edit(HomeWork $homework)
    {
        if (auth()->user()->role == 1) {
            return view('homework.edit')->with(['homeWork' => $homework]);
        }

        return redirect()->route('homeworks.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeWorkUpdateRequest $request, HomeWork $homework)
    {
        if (auth()->user()->role == 1) {
            if ($request->hasFile('home_work')) {
                $file = $request->home_work;
                $prefixPath = 'homework-uploaded-files/' . now()->format('Ymd');
                Storage::disk('public')->delete($homework->saved_path);
                $uploadedFile = Storage::disk('public')->putFile($prefixPath, $file);
                $homework->name = $request->name;
                $homework->home_work = $request->name;
                $homework->original_name = $file->getClientOriginalName();
                $homework->saved_path = $uploadedFile;
                $homework->hash = Hash::make(now()->format('Ymd'));
                $homework->save();

                return redirect()->route('homeworks.index')->with(['success' => 'updated homework successfully']);
            }

            $homework->name = $request->name;
            $homework->home_work = $request->name;
            $homework->save();

            return redirect()->route('homeworks.index')->with(['success' => 'updated homework successfully']);
        }

        return redirect()->route('homeworks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeWork $homework)
    {
        if (auth()->user()->role == 1) {
            Storage::disk('public')->delete($homework->saved_path);

            if ($homework->delete()) {
                return redirect()->route('homeworks.index')->with(['success' => 'deleted homework successfully']);
            }

            return redirect()->route('homeworks.index')->with(['error' => 'deleted homework failed']);
        }

        return redirect()->route('homeworks.index');
    }

    public function download(HomeWork $homework)
    {
        return response()->download(storage_path('app/public/' . $homework->saved_path));
    }
}
