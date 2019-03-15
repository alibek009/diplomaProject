@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.questions.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.questions.fields.question')</th>
                            <td field-key='question'>{!! $question->question !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.questions.fields.question-image')</th>
                            <td field-key='question_image'>@if($question->question_image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $question->question_image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $question->question_image) }}"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.questions.fields.score')</th>
                            <td field-key='score'>{{ $question->score }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#questions_options" aria-controls="questions_options" role="tab" data-toggle="tab">Questions options</a></li>
<li role="presentation" class=""><a href="#tests" aria-controls="tests" role="tab" data-toggle="tab">Tests</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="questions_options">
<table class="table table-bordered table-striped {{ count($questions_options) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.questions-options.fields.question')</th>
                        <th>@lang('quickadmin.questions-options.fields.option-text')</th>
                        <th>@lang('quickadmin.questions-options.fields.correct')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($questions_options) > 0)
            @foreach ($questions_options as $questions_option)
                <tr data-entry-id="{{ $questions_option->id }}">
                    <td field-key='question'>{{ $questions_option->question->question ?? '' }}</td>
                                <td field-key='option_text'>{!! $questions_option->option_text !!}</td>
                                <td field-key='correct'>{{ Form::checkbox("correct", 1, $questions_option->correct == 1 ? true : false, ["disabled"]) }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('questions_option_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.questions_options.restore', $questions_option->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('questions_option_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.questions_options.perma_del', $questions_option->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('questions_option_view')
                                    <a href="{{ route('admin.questions_options.show',[$questions_option->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('questions_option_edit')
                                    <a href="{{ route('admin.questions_options.edit',[$questions_option->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('questions_option_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.questions_options.destroy', $questions_option->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="tests">
<table class="table table-bordered table-striped {{ count($tests) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.tests.fields.course')</th>
                        <th>@lang('quickadmin.tests.fields.lesson')</th>
                        <th>@lang('quickadmin.tests.fields.title')</th>
                        <th>@lang('quickadmin.tests.fields.description')</th>
                        <th>@lang('quickadmin.tests.fields.questions')</th>
                        <th>@lang('quickadmin.tests.fields.published')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($tests) > 0)
            @foreach ($tests as $test)
                <tr data-entry-id="{{ $test->id }}">
                    <td field-key='course'>{{ $test->course->title ?? '' }}</td>
                                <td field-key='lesson'>{{ $test->lesson->title ?? '' }}</td>
                                <td field-key='title'>{{ $test->title }}</td>
                                <td field-key='description'>{!! $test->description !!}</td>
                                <td field-key='questions'>
                                    @foreach ($test->questions as $singleQuestions)
                                        <span class="label label-info label-many">{{ $singleQuestions->question }}</span>
                                    @endforeach
                                </td>
                                <td field-key='published'>{{ Form::checkbox("published", 1, $test->published == 1 ? true : false, ["disabled"]) }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('test_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.tests.restore', $test->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('test_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.tests.perma_del', $test->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('test_view')
                                    <a href="{{ route('admin.tests.show',[$test->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('test_edit')
                                    <a href="{{ route('admin.tests.edit',[$test->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('test_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.tests.destroy', $test->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.questions.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


