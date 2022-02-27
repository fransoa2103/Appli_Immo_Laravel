@extends('layouts.main')
@section('content')

<div class="row">

    <div class="col-lg-3">
        {{-- @include('includes.sidebar') --}}
    </div>

    <!-- affiche un message de success lorsqu'un nouvel utilisateur s'est inscrit -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @else
    
    <div class="col-lg-9">
        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Inscription 
            </div>
        </div>
        <!-- /.card -->
        <div class="card-body">
            <!-- Formulaire d'inscription -->
            <form action = " {{ route('post.register')}} " method="POST">
                {{-- @csrf --}}
                @csrf
                {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> --}}
                <div class="mb-3">
                    <label for="first_name" class="form-label">Nom</label>
                    <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}">
                    @error('first_name')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Nom</label>
                    <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}">
                    @error('last_name')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{old('email')}}">
                    @error('email')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Inscription</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.col-lg-9 -->
    @endif

</div>
@stop  