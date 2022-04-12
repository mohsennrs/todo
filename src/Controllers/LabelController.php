<?php

namespace Hattori\ToDo\Controllers;

use Illuminate\Http\Request;

use Hattori\ToDo\Models\Label;
use Illuminate\Routing\Controller;
use Hattori\ToDo\Resources\LabelResource;
use Hattori\ToDo\Resources\LabelCollection;
use Hattori\ToDo\Requests\CreateLabelRequest;

class LabelController extends Controller
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
    public function index(Request $request)
    {
        $labels = Label::where('user_id', auth()->user()->id)->where(function($q) use($request) {
            if($request->get('text')) {
                $q->where('text', 'like', '%'.$request->get('text').'%');                
            }
        })->with(['tasks'])->get();

        return new LabelCollection($labels);
    }

    public function store(CreateLabelRequest $request)
    {
        $label = auth()->user()->labels()->create([
            'text' => $request->get('text')
        ]);

        return response(['message' => 'success', 'data' => new LabelResource($label)], 201);
    }
   
}
