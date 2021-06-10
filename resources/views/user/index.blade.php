@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Manage User</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-3 col-lg-2">
                                <a href="{{ route('user.create') }}" class="btn btn-dark btn-block mb-2">Add User</a>
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
                                    <th scope="col">Email</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('user.edit', ['user' => $user->id]) }}" type="button" class="btn btn-primary">Edit</a>&nbsp;
                                            <form id="delete-form" action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST" class="d-inline-block mt-2 mt-lg-0">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <input type="submit" class="btn btn-danger" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">User not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
