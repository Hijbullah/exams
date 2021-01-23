<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Batch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Batch/Index', [
            'filters' => request()->all('search'),
            'batches' => Batch::filter(request()->only('search'))
                ->withCount(['exams'])
                ->latest()
                ->paginate(10)
                ->transform(function ($batch) {
                    return [
                        'id' => $batch->id,
                        'name' => $batch->name,
                        'slug' => $batch->slug,
                        'exams_count' => $batch->exams_count,
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
        return Inertia::render('Admin/Batch/Create');
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
            'name' => ['required', 'unique:batches', 'max:255'],
            'detail' => ['nullable', 'string'],
        ]);

        Batch::create([
            'batch_id' => Str::random(13),
            'name' => $request->name,
            'slug' => Str::of($request->name)->limit(100)->slug(),
            'detail' => $request->detail,
            'status' => true
        ]);

        return Redirect::route('admin.batches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        return Inertia::render('Admin/Batch/Edit', [
            'batch' => $batch->only('id','slug', 'name', 'detail')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'name' => ['required', 'max:255', Rule::unique('batches')->ignore($batch->id)],
            'detail' => ['nullable', 'string'],
        ]);

        $batch->name = $request->name;

        if($batch->isDirty('name'))
        {
           $batch->slug = Str::of($request->name)->limit(100)->slug();
        }

        $batch->detail = $request->detail;
        $batch->save();
        return Redirect::route('admin.batches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();
        return Redirect::route('admin.batches.index');
    }
}
