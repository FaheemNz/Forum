@extends('layouts.app')

@section('content')
<a data-toggle="tooltip" data-placement="top" title="Create new Thread" href="{{ route('create_thread') }}" class="btn btn-floating is-fixed">+</a>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-threads title="All Threads" :threads="$threads" />
        </div>
    </div>
</div>
@endsection