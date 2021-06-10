@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Manage Movie</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-3 col-lg-2">
                                <a href="{{ route('movie.create') }}" class="btn btn-dark btn-block mb-2">Add Movie</a>
                            </div>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped table-responsive-lg">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movies as $key => $movie)
                                    <tr>
                                        <td>{{ $movies->firstItem() + $key }}</td>
                                        <td>{{ $movie->name }}</td>
                                        <td>
                                            @if($movie->cover)
                                                <img src="{{ asset('storage/'.$movie->cover) }}" width="100px" alt="movie Cover">
                                            @else
                                                <p>Cover not set</p>
                                            @endif
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach($movie->categories as $category)
                                                    <li>{{ $category->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $movie->createdBy->name }}</td>
                                        <td>{{ $movie->updatedBy->name ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('movie.edit', ['movie' => $movie->id]) }}" type="button" class="btn btn-primary">Edit</a>&nbsp;
                                            <form id="delete-form" action="{{ route('movie.destroy', ['movie' => $movie->id]) }}" method="POST" class="d-inline-block mt-2">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" class="btn btn-danger" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">movie not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $movies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
