@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Edit Movie</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('movie.update', ['movie' => $movie->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('put') }}
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" class="form-control" id="name" value="{{ $movie->name }}" placeholder="Name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="categories" class="col-sm-2 col-form-label">Categories</label>
                                <div class="col-sm-10">
                                    <select name="categories[]" id="categories" multiple class="form-control">
                                        @forelse($movie->categories as $category)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @empty
                                            <option></option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cover" class="col-sm-2 col-form-label">cover</label>
                                <div class="col-sm-10">
                                    <small class="text-muted">Current cover</small><br>
                                    @if($movie->cover)
                                        <img src="{{asset('storage/' . $movie->cover)}}" width="100px"/>
                                    @endif
                                    <input name="cover" type="file" class="form-control" id="cover"/>
                                    <small class="text-muted">*Kosongkan jika tidak ingin mengubah cover</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-dark mb-2" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(function(){
            $('#categories').select2({
                placeholder: 'Choose category',
                ajax: {
                    url: '{{ route('category.select2')}}',
                    processResults: function(data){
                        return {
                            results: data.map(function(item){
                                return {id: item.id, text: item.name}
                            })
                        }
                    }
                }
            });
        })
    </script>
@endsection
