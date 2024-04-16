<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::select('id', 'type_id', 'name', 'author', 'description', 'image')
            ->with(['type:id,name,color', 'technologies:id,name,color'])
            ->orderBy('id', 'DESC')->paginate(12);

        foreach ($projects as $project) {
            $project->image = !empty($project->image) ? asset('/storage/' . $project->image) : null;
        }
        return response()->json([
            'result' => $projects,
            'success' => true
        ]);
    }

    /**
         * Display a listing filtered by type of the resource.
         *
        //  * @return \Illuminate\Http\Response
         */
    public function projectsByType($type_id)
    {
        /* Cerco prima il tipo tra quelli presenti in DB */
        $type = Type::find($type_id);

        /* Controllo se non c'è e mando un json con errore, che riprenderò al momento della chiamata */
        if (empty($type)) {
            return response()->json([
                'message' => 'Type not found',
                'success' => false,
            ]);
        }

        $projects = Project::select('id', 'type_id', 'name', 'author', 'description', 'image')
            ->where('type_id', $type_id)
            ->with(['type:id,name,color', 'technologies:id,name,color'])
            ->orderBy('id', 'DESC')->paginate(12);

        foreach ($projects as $project) {
            $project->image = !empty($project->image) ? asset('/storage/' . $project->image) : null;
        }
        return response()->json([
            'result' => $projects,
            'type' => $type,
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     //  * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::select('id', 'type_id', 'name', 'author', 'description', 'image')
            ->where('id', $id)
            ->with(['type:id,name,color', 'technologies:id,name,color'])
            ->first();

        if (empty($project)) {
            return response()->json([
                'message' => 'Project not found',
                'success' => false,
            ]);
        }

        $project->image = !empty($project->image) ? asset('/storage/' . $project->image) : null;

        return response()->json([
            'result' => $project,
            'success' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
