<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Lesson;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonsRequest;
use App\Http\Requests\Admin\UpdateLessonsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class LessonsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Gate::allows('lesson_access')) {
            return abort(401);
        }

        $lessons = Lesson::whereIn('course_id',Course::ofTeacher()->pluck('id'));
        if($request -> input('course_id')){
            $lessons = $lessons -> where('course_id',$request->input('course_id'));
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('lesson_delete')) {
                return abort(401);
            }
            $lessons = $lessons-> onlyTrashed()->get();
        } else {
            $lessons = $lessons-> get();
        }

        return view('admin.lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating new Lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('lesson_create')) {
            return abort(401);
        }
        
        $courses = \App\Course::ofTeacher()->get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.lessons.create', compact('courses'));
    }

    /**
     * Store a newly created Lesson in storage.
     *
     * @param  \App\Http\Requests\StoreLessonsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonsRequest $request)
    {
        if (! Gate::allows('lesson_create')) {
            return abort(401);
        }

        $request = $this->saveFiles($request);
        $lesson = Lesson::create($request->all() + ['position' =>Lesson::where('course_id',$request->course_id)->max('position') + 1]);

        $data = $request->all();

        $rules = [
            'title' => 'required',
            'lesson_image' => 'file|mimes:jpg,jpeg,png',
            'slug' => 'required',
            'video' => 'file|mimes:mp4,mov,avi,wmv',
            'presentation' => 'file|mimes:pptx,ppt',
            'full_text' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id]);
        }else {
            $lessonPart = new Lesson();

            if ($request->video) {
                $video = $request->video;
                $video_new_name = time() . $video->getClientOriginalName();
                $videoFullPath = $video->move('assets/files/lessons/videos', $video_new_name);
                $lessonPart->video = $videoFullPath;
            }

            $lessonPart->save();
            Session::flash('success', ['title' => trans('messages.insert'), 'body' => trans('messages.insert_success')]);


            return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id]);
        }
    }


    /**
     * Show the form for editing Lesson.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('lesson_edit')) {
            return abort(401);
        }
        
        $courses = \App\Course::ofTeacher()->get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $lesson = Lesson::findOrFail($id);

        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    /**
     * Update Lesson in storage.
     *
     * @param  \App\Http\Requests\UpdateLessonsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonsRequest $request, $id)
    {
        if (!Gate::allows('lesson_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $lesson = Lesson::findOrFail($id);
        $lesson->update($request->all());


        $data = $request->all();
        $rules = [
            'video' => 'file|mimes:mp4,mov,avi,wmv',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id]);
        } else {

            Session::flash('success', ['title' => trans('messages.update'), 'body' => trans('messages.update_success')]);
            return redirect()->route('admin.lessons.index', ['course_id' => $request->course_id]);
        }
    }

    /**
     * Display Lesson.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('lesson_view')) {
            return abort(401);
        }
        
        $courses = \App\Course::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');$tests = \App\Test::where('lesson_id', $id)->get();

        $lesson = Lesson::findOrFail($id);

        return view('admin.lessons.show', compact('lesson', 'tests'));
    }


    /**
     * Remove Lesson from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::findOrFail($id);
        $lesson->deletePreservingMedia();

        return redirect()->route('admin.lessons.index');
    }

    /**
     * Delete all selected Lesson at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('lesson_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Lesson::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore Lesson from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->restore();

        return redirect()->route('admin.lessons.index');
    }

    /**
     * Permanently delete Lesson from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('lesson_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->forceDelete();

        return redirect()->route('admin.lessons.index');
    }
}
