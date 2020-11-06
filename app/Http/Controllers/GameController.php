<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\GameCreateRequest;
use App\Http\Requests\GameUpdateRequest;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::orderBy('id', 'DESC')->paginate(10);
        return view('game.index')->with(['games' => $games, 'role' => auth()->user()->role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('game.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;
            $prefixPath = 'game-uploaded-files/' . now()->format('Ymd');
            $formatName = str_replace(' ', '_', $file->getClientOriginalName());

            Storage::disk('public')->putFileAs($prefixPath, $file, $formatName);
            Game::create([
                'name' => $request->name,
                'suggestion' => $request->suggestion,
                'file' => $file->getClientOriginalExtension(),
            ]);

            return redirect()->route('games.index')->with(['success' => 'created game successfully']);
        }

        return redirect()->route('games.index')->with(['error' => 'created game failed']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        return view('game.edit')->with(['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GameUpdateRequest $request,Game $game)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;
            $prefixPath = 'game-uploaded-files/' . now()->format('Ymd');
            $formatName = str_replace(' ', '_', $file->getClientOriginalName());
            Storage::disk('public')->delete($prefixPath . ''. $formatName);
            Storage::disk('public')->putFileAs($prefixPath, $file, $formatName);
            $game->name = $request->name;
            $game->suggestion = $request->suggestion;
            $game->file = $file->getClientOriginalExtension();
            $game->save();
            return redirect()->route('games.index')->with(['success' => 'updated game successfully']);
        }

        $game->name = $request->name;
        $game->suggestion = $request->suggestion;
        $game->save();

        return redirect()->route('games.index')->with(['success' => 'updated game successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        if ($game->delete()) {
            return redirect()->route('games.index')->with(['success' => 'deleted game successfully']);
        }

        return redirect()->route('games.index')->with(['error' => 'deleted game failed']);
    }

    public function showGame(Game $game)
    {
        return view('game.play')->with(['game' => $game]);
    }

    public function play(Request $request, Game $game)
    {
        $prefixPath = 'game-uploaded-files/' . now()->format('Ymd');
        $answer = str_replace(' ', '_', $request->answer . '.' . $game->file);
        if (Storage::disk('public')->exists($prefixPath . '/' . $answer)) {
            return redirect(url('/') . '/storage/' . $prefixPath . '/' . $answer);
        }

        return redirect()->back()->with(['error' => 'your answer is incorrect, try again!']);
    }
}
