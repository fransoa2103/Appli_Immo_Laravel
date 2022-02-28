@extends('layouts.main')
@section('content')

<div class="row">
    <!-- views/includes/sidebar.blade.php -->
    <div class="col-lg-3">
        {{-- @include('includes.sidebar') --}}
    </div>
    <!-- /.col-lg-3 -->
    <div class="col-lg-9">
        
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title"><a href="{{ route('annonces.show', ['annonce'=>$annonce->id]) }}">Annonce # {{ $annonce->reference_annonce }}</a></h5>
                <p class="card-text">description / {{ $annonce->description_annonce }}</p>
                <p class="card-text">nb pièce(s) / {{ $annonce->nombre_de_piece }}</p>
                <p class="card-text">Surface habitable m² /{{ $annonce->surface_habitable }}</p>
                <p class="card-text bold">Prix / {{ $annonce->prix_annonce }} €</p>
                
                <span class="author">Par 
                {{-- <a href="">{{ $annonce->user->last_name }}</a></span> <br> --}}
                <a href="{{ route('user.profile', ['user'=>$annonce->user->id]) }}">{{ $annonce->user->first_name }} {{ $annonce->user->last_name }}</a></span> <br>

                <span class="time">
                    {{ $annonce->created_at->diffForHumans()}} le 
                    {{ $annonce->created_at->isoFormat('LL')}}
                </span>
            </div>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col-lg-9 -->

    </div>
@stop