@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.courses.title')</h3>
    @can('course_create')
    <p>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('course_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.courses.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.courses.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($courses) > 0 ? 'datatable' : '' }} @can('course_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('course_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        @if (Auth::user()->isAdmin())
                        <th>@lang('quickadmin.courses.fields.teachers')</th>
                            @endif
                        <th>@lang('quickadmin.courses.fields.title')</th>
                        <th>@lang('quickadmin.courses.fields.slug')</th>
                        <th>@lang('quickadmin.courses.fields.description')</th>
                        <th>@lang('quickadmin.courses.fields.price')</th>
                        <th>@lang('quickadmin.courses.fields.course-image')</th>
                        <th>@lang('quickadmin.courses.fields.start-date')</th>
                        <th>@lang('quickadmin.courses.fields.published')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($courses) > 0)
                        @foreach ($courses as $course)
                            <tr data-entry-id="{{ $course->id }}">
                                @can('course_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan
                                    @if (Auth::user()->isAdmin())
                                <td field-key='teachers'>
                                    @foreach ($course->teachers as $singleTeachers)
                                        <span class="label label-info label-many">{{ $singleTeachers->name }}</span>
                                    @endforeach
                                </td>
                                    @endif
                                <td field-key='title'>{{ $course->title }}</td>
                                <td field-key='slug'>{{ $course->slug }}</td>
                                <td field-key='description'>{!! $course->description !!}</td>
                                <td field-key='price'>{{ $course->price }}</td>
                                <td field-key='course_image'>@if($course->course_image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $course->course_image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $course->course_image) }}"/></a>@endif</td>
                                <td field-key='start_date'>{{ $course->start_date }}</td>
                                <td field-key='published'>{{ Form::checkbox("published", 1, $course->published == 1 ? true : false, ["disabled"]) }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('course_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.courses.restore', $course->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('course_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.courses.perma_del', $course->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('course_view')

                                    <a href="{{ route('admin.lessons.index',['course_id'=>$course->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.lessons.title')</a>

                                      @endcan
                                    @can('course_edit')
                                    <a href="{{ route('admin.courses.edit',[$course->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('course_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.courses.destroy', $course->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('course_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.courses.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection