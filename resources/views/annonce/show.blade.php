@extends('layouts.main')
@section('content')

<div class="row">
    <!-- views/includes/sidebar.blade.php -->
    <div class="col-lg-3">
        {{-- @include('includes.sidebar') --}}
    </div>
    <!-- /.col-lg-3 -->
    <div class="col-lg-9">
        
        <!-- affiche un message de success si une annonce a été modifiée avec succes -->
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        <!-- /.success -->

        <div class="card my-4">
            <div class="card-body ">
                <h3 class="card-title text-primary font-weight-bold">
                    Annonce # {{ $annonce->reference_annonce }}</h3>
                <p class="card-text">
                    description : {{ $annonce->description_annonce }}</p>
                <p class="card-text">
                    nb pièce(s) : {{ $annonce->nombre_de_piece }}</p>
                <p class="card-text">
                    Surface habitable m² : {{ $annonce->surface_habitable }}</p>
                <p class="card-text">
                    Prix : {{ number_format($annonce->prix_annonce, 2, ',', ' ') }} €</p>
                
                <span class="time">Posté 
                    {{ $annonce->created_at->diffForHumans()}} le 
                    {{ $annonce->created_at->isoFormat('LL')}}
                </span>

                <span class="author">par 
                {{-- <a href="">{{ $annonce->user->last_name }}</a></span> <br> --}}
                <a href="{{ route('user.profile', ['user'=>$annonce->user->id]) }}">{{ $annonce->user->first_name }} {{ $annonce->user->last_name }}</a></span> <br>

            </div>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col-lg-9 -->

    </div>
@stop