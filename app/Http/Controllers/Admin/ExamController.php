<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Exam;
use Inertia\Inertia;
use App\Models\Batch;
use App\Models\Subject;
use App\Models\ExamType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Exam/Index', [
            'filters' => request()->all('search'),
            'exams' => Exam::filter(request()->only('search'))
                // ->withCount(['exams'])
                ->latest()
                ->paginate(10)
                ->transform(function ($exam) {
                    return [
                        'id' => $exam->id,
                        'name' => $exam->name,
                        'total_question' => $exam->total_question,
                        'exam_schedule' => [
                            'start' => Carbon::parse($exam->exam_started_at)->toDayDateTimeString(),
                            'end' => Carbon::parse($exam->exam_ended_at)->toDayDateTimeString()
                        ],
                        'exam_status' => $exam->exam_status,
                        'batch' => $exam->batch()->first()->only('id', 'name')
                        // 'students_count' => $batch->students_count
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
        return Inertia::render('Admin/Exam/Create', [
            'batches' => Batch::all()->map->only('id', 'name'),
            'examTypes' => ExamType::all()->map->only('id', 'name'),
            'subjects' => Subject::all()->map->only('id', 'name')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return Carbon::parse($request->exam_end_at);
        
        $request->validate([
            'name' => ['required', 'unique:exams', 'max:255'],

            'batch' => ['required'],
            'exam_type' => ['required'],

            'total_question' => ['required', 'numeric', 'min:2', 'max:200'],
            'pass_mark' => ['nullable', 'numeric'],
            'exam_duration' => ['required', 'numeric'],

            'negative_mark' => [ 'nullable' ,'numeric', 'min:0', 'max:1'],

            'exam_start_at' => ['required'],
            'exam_end_at' => ['required'],

            'subjects' => ['required'],
        ]);
        
        $exam = new Exam;
        $exam->exam_id = Str::random(11);
        $exam->batch_id = $request->batch;
        $exam->name = $request->name;
        $exam->exam_type_id = $request->exam_type;
        $exam->total_question = $request->total_question;
        $exam->pass_mark = $request->pass_mark;
        $exam->exam_duration = $request->exam_duration;
        $exam->exam_started_at = Carbon::parse($request->exam_start_at);
        $exam->exam_ended_at = Carbon::parse($request->exam_end_at);
        $exam->subjects = $request->subjects;

        if($request->has_negative_mark)
        {
            $exam->has_negative_mark = true;
            $exam->negative_mark = $request->negative_mark;
        }

        $exam->save();
        return Redirect::route('admin.exams.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return Inertia::render('Admin/Exam/Show', [
            'exam' => [
                'id' => $exam->id,
                'name' => $exam->name,
                'exam_id' => $exam->exam_id,
                'batch_id' => $exam->batch_id,
                'exam_type_id' => $exam->exam_type_id,
                'total_question' => $exam->total_question,
                'pass_mark' => $exam->pass_mark,
                'exam_duration' => $exam->exam_duration,
                'exam_started_at' => Carbon::parse($exam->exam_started_at),
                'exam_ended_at' => Carbon::parse($exam->exam_ended_at),
                'subjects' => $exam->subjects,
                'has_negative_mark' => $exam->has_negative_mark ? true : false,
                'negative_mark' => $exam->negative_mark,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        return Inertia::render('Admin/Exam/Edit', [
            'batches' => Batch::all()->map->only('id', 'name'),
            'examTypes' => ExamType::all()->map->only('id', 'name'),
            'subjects' => Subject::all()->map->only('id', 'name'),
            'exam' => [
                'id' => $exam->id,
                'name' => $exam->name,
                'exam_id' => $exam->exam_id,
                'batch_id' => $exam->batch_id,
                'exam_type_id' => $exam->exam_type_id,
                'total_question' => $exam->total_question,
                'pass_mark' => $exam->pass_mark,
                'exam_duration' => $exam->exam_duration,
                'exam_started_at' => Carbon::parse($exam->exam_started_at),
                'exam_ended_at' => Carbon::parse($exam->exam_ended_at),
                'subjects' => $exam->subjects,
                'has_negative_mark' => $exam->has_negative_mark ? true : false,
                'negative_mark' => $exam->negative_mark,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => ['required', Rule::unique('exams')->ignore($exam->id), 'max:255'],
            'batch' => ['required'],
            'exam_type' => ['required'],
            'total_question' => ['required', 'numeric', 'min:2', 'max:200'],
            'pass_mark' => ['nullable', 'numeric'],
            'exam_duration' => ['required', 'numeric'],
            'negative_mark' => [ 'nullable' ,'numeric', 'min:0', 'max:1'],
            'exam_start_at' => ['required'],
            'exam_end_at' => ['required'],
            'subjects' => ['required'],
        ]);

        $exam->batch_id = $request->batch;
        $exam->exam_type_id = $request->exam_type;
        $exam->name = $request->name;
        $exam->total_question = $request->total_question;
        $exam->pass_mark = $request->pass_mark;
        $exam->exam_duration = $request->exam_duration;
        $exam->exam_started_at = Carbon::parse($request->exam_start_at);
        $exam->exam_ended_at = Carbon::parse($request->exam_end_at);
        $exam->subjects = $request->subjects;

        if($request->has_negative_mark)
        {
            $exam->has_negative_mark = true;
            $exam->negative_mark = $request->negative_mark;
        }else {
            $exam->has_negative_mark = false;
            $exam->negative_mark = 0.25;
        }

        $exam->save();
        return Redirect::route('admin.exams.show', $exam->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return Redirect::route('admin.exams.index');
    }
}
