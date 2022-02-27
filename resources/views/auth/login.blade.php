
@extends('layouts.main')
@section('content')

<div class="row">
    <!-- views/includes/sidebar.blade.php -->
    <div class="col-lg-3">
        {{-- @include('includes.sidebar') --}}
    </div>
    <!-- /.col-lg-3 -->

    <div class="col-lg-9">

        <!-- affiche un message de success lorsqu'un nouvel utilisateur s'est inscrit -->
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        <!-- affiche un message d'erreur lorsque une saisie de connexion est erronnée -->
        @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif
        
        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Connexion
            </div>
        </div>
        <!-- /.card -->

        <div class="card-body">
            <!-- Formulaire de connexion -->
            <form action = " {{ route('post.login')}} " method="POST">
                @csrf
                {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> --}}
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
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn btn-primary">Connexion</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.col-lg-9 -->

</div>

@stop