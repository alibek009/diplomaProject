@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.questions-options.title')</h3>
    
    {!! Form::model($questions_option, ['method' => 'PUT', 'route' => ['admin.questions_options.update', $questions_option->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('question_id', trans('quickadmin.questions-options.fields.question').'', ['class' => 'control-label']) !!}
                    {!! Form::select('question_id', $questions, old('question_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('question_id'))
                        <p class="help-block">
                            {{ $errors->first('question_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('option_text', trans('quickadmin.questions-options.fields.option-text').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('option_text', old('option_text'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('option_text'))
                        <p class="help-block">
                            {{ $errors->first('option_text') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('correct', trans('quickadmin.questions-options.fields.correct').'', ['class' => 'control-label']) !!}
                    {!! Form::hidden('correct', 0) !!}
                    {!! Form::checkbox('correct', 1, old('correct', old('correct')), []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('correct'))
                        <p class="help-block">
                            {{ $errors->first('correct') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

