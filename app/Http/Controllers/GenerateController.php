<?php

namespace App\Http\Controllers;

use App\Format;
use App\Generate;
use App\GenerateUser;
use App\Jobs\ProcessGenerateTemplate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class GenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        die("index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $format = Format::where('id', Input::get('format'))->first();

        if ($request->has('format') && $format != null)
        {
            $fields = json_decode($format->fields);
            return view('generate.create', compact(['format', 'fields']));
        }


        $formats = Format::select(['id', 'name', 'format', 'description'])->orderby('name', 'asc')->get();
        return view('generate.selectFormat', compact('formats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $format = Format::where('id', $request->get("format"))->first();
        if ($format == null)
        {
            die("Nope.");
        }

        $fields = json_decode($format->fields);

        //get all field id's/names from Format and create array. Array to json
        $inputs = Array();
        foreach ($fields as $fieldid => $fieldprops)
        {
            if (!empty($request->get($fieldid)))
            {
                $inputs[$fieldid] = $request->get($fieldid);
            }
        }

        $generate = new Generate();
        $generate->content= json_encode($inputs);
        $generate->format_id = $format->id;
        $generate->save();

        $user = User::where('email', $request->get('email'))->first();
        if ($user == null)
        {
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->save();
        }

        $generate_user = new GenerateUser();
        $generate_user->user_id = $user->id;
        $generate_user->generate_id = $generate->id;
        $generate_user->save();

        ProcessGenerateTemplate::dispatch($generate)->onQueue('generate');

        //TODO: show text and estimated waiting time...
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        die("show");
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
}
