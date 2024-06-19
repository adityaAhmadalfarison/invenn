<!-- resources/views/commodity-locations/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Commodity Location</h1>
    <form action="{{ route('commodity-locations.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="d-block invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rooms">Daftar Ruangan</label>
                    <select multiple class="tom-select @error('rooms') is-invalid @enderror" name="rooms[]" id="rooms" placeholder="Pilih ruangan..">
                        @foreach ($commodityLocation as $room)
                            <option value="{{ $room->id }}" {{ (collect(old('rooms'))->contains($room->id)) ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('rooms')
                        <div class="d-block invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
