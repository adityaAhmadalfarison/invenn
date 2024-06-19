@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Mahasiswa</h1>

        <form action="{{ route('mahasiswas.update', $mahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $mahasiswa->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $mahasiswa->email }}" required>
            </div>
            <!-- Add other fields if necessary -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
