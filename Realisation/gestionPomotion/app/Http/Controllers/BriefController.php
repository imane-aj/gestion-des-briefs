<?php

namespace App\Http\Controllers;

use App\Models\Brief;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BriefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $briefs = Brief::all();
        return view('briefs.index', ['briefs' => $briefs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('briefs.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $brief = Brief::create([
            'name'  => $request->name,
            'livraisonDate' => $request->livraisonDate,
            'recuperationDate' => $request->recuperationDate,
            'token' => Str::random()
        ]);
        return redirect()->route('brief.index')->with(['true' => 'Le brief à été ajouté avec succé']);
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
    public function edit($token)
    {
        //
        $brief = Brief::where('token', $token)->firstOrFail();
        $tasks = $brief->tasks;
        return view('briefs.edit', ['brief' => $brief, 'tasks' => $tasks]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $token)
    {
        //
        $brief = Brief::where('token',$token)->firstOrFail();
        $brief->update([
            'name' => $request->name,
            'livraisonDate'    => $request->livraisonDate,
            'recuperationDate' => $request->recuperationDate
        ]);
        return redirect()->route('brief.index', $brief->token)
        ->with(['true' => 'Le brief à été modifié avec succé']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($token)
    {
        //
        $brief = Brief::where('token', $token)->firstOrFail();
        $brief->delete();
        return back();
    }
}
