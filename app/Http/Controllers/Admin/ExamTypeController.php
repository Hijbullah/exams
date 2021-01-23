<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\ExamType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ExamTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/ExamType/Index', [
            'filters' => request()->all('search'),
            'examTypes' => ExamType::filter(request()->only('search'))
                ->withCount('exams')
                ->latest()
                ->paginate(10)
                ->transform(function ($examType) {
                    return [
                        'id' => $examType->id,
                        'name' => $examType->name,
                        'slug' => $examType->slug,
                        'exams_count' => $examType->exams_count,
                        // 'students_count' => $examType->students_count
                    ];
                })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/ExamType/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:exam_types', 'max:255'],
        ]);

        ExamType::create([
            'name' => $request->name,
            'slug' => Str::of($request->name)->limit(100)->slug(),
        ]);

        return Redirect::route('admin.exam-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamType  $examType
     * @return \Illuminate\Http\Response
     */
    public function show(ExamType $examType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamType  $examType
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamType $examType)
    {
        return Inertia::render('Admin/ExamType/Edit', [
            'examType' => $examType->only('id','slug', 'name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamType  $examType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamType $examType)
    {
        $request->validate([
            'name' => ['required', 'max:255', Rule::unique('exam_types')->ignore($examType->id)]
        ]);

        $examType->name = $request->name;

        if($examType->isDirty('name'))
        {
           $examType->slug = Str::of($request->name)->limit(100)->slug();
        }

        $examType->save();
        return Redirect::route('admin.exam-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamType  $examType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamType $examType)
    {
        $examType->delete();
        return Redirect::route('admin.exam-types.index');
    }
}
