@extends('dashboard.layouts.app')
  
@section('contents')

    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Static Pages</h4>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                </div>
                <div class="table-responsive">
                    @if ($staticpages->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                        <th class="text-center">ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Meta keywords</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    @foreach ($staticpages as $pages)
                        <tr>
                            <td>{{ $pages->id }}</td>
                            <td>{{ $pages->name }}</td>
                            <td>{{ Str::length($pages->description) > 40 ? Str::substr($pages->description, 0, 40) . '...' : $pages->description }}</td>
                            <td>{{ $pages->meta_keyword }}</td>
                            <td>
                                <a href="{{ route('staticpages.edit', $pages->id) }}" class="btn btn-dark">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No Static Pages found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $staticpages->links('pagination::bootstrap-5') }}
                </div>
                </div>

           
                </div>
            </div>
            </div>
        </div>
    </div>
  
@endsection


@section('customJs')
    
@endsection