@extends('layouts.manager')

@section('page-header')
    {{ Lang::get('manager.dashboard.control_panel') }}
@stop

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-info fa-fw"></i> {{ Lang::get('manager.dashboard.server_info._title') }}</h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    @foreach ($serverInfo as $row)
                    <div class="list-group-item">
                        <span class="badge alert-info">{{ $row['value'] }}</span>
                        <i class="fa fa-fw fa-{{ $row['icon'] }}"></i> {{ $row['label'] }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-folder-open fa-fw"></i> {{ Lang::get('manager.dashboard.directories_access._title') }}</h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <label>{{ Config::get('app.uploads_root') }}&hellip;</label>
                    @foreach ($dirs as $row)
                    <div class="list-group-item{{ $row['status']['class'] == 'danger' ? ' text-danger' : null }}">
                        <span class="badge alert-{{ $row['status']['class'] }}">{{ $row['status']['message'] }}</span>
                        <i class="fa fa-fw fa-folder-open-o"></i> {{ $row['label'] }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@stop