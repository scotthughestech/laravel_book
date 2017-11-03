@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div class="panel-heading">Quick Look</div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                Today: ${{ number_format($today, 2) }}
                            </li>
                            <li class="list-group-item">
                                Yesterday: ${{ number_format($yesterday, 2) }}
                            </li>
                            <li class="list-group-item">
                                Last 7 Days: ${{ number_format($last7days, 2) }}
                            </li>
                            <li class="list-group-item">
                                Last 30 Days: ${{ number_format($last30days, 2) }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
