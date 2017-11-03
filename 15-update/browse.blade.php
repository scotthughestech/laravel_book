@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Browse</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="pager-top">{{ $purchases->links() }}</div>
                    <table id="browse" class="table table-striped table-bordered"> 
                        <thead> 
                            <tr> 
                                <th>ID</th> 
                                <th>Date</th> 
                                <th>Price</th> 
                                <th>Description</th>
                                <th>Edit</th>
                            </tr> 
                        </thead>
                        <tbody> 
                            @foreach ($purchases as $purchase) 
                            <tr> 
                                <td>{{ $purchase->id }}</td> 
                                <td>{{ $purchase->date }}</td> 
                                <td>{{ $purchase->price }}</td> 
                                <td>{{ $purchase->description }}</td>
                                <td><a href="/update/{{ $purchase->id }}">Edit</a></td> 
                            </tr>                            
                            @endforeach 
                        </tbody>
                    </table>
                    <div class="pager-btm">{{ $purchases->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection