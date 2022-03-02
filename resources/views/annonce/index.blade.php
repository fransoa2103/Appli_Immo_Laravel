@extends('layouts.main')
@section('content')

    <div class="row">

        <!-- views/includes/sidebar.blade.php -->
        <div class="col-lg-3">
            @include('includes.sidebar')
        </div>

        <!-- /.col-lg-3 -->
        <div class="col-lg-9">
            
            <!-- affiche un message de success lorsqu'une annonce est créee,modifée ou supprimée avec succes  -->
            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
            <!-- affiche un message de success lorsqu'une annonce est créee,modifée ou supprimée avec succes  -->
            @if(session('error'))
                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif

            {{-- début du post --}}
            @foreach($Annonces as $annonce)
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('annonces.show', ['annonce'=>$annonce->reference_annonce]) }}">Annonce # {{ $annonce->reference_annonce }}</a></h5>
                        <p class="card-text">description : {{ $annonce->description_annonce }}</p>
                        <p class="card-text">nb pièce(s) : {{ $annonce->nombre_de_piece }}</p>
                        <p class="card-text">Surface habitable : {{ $annonce->surface_habitable }} m²</p>
                        <p class="card-text bold">Prix : <?= number_format($annonce->prix_annonce, 2, ',', ' ') ?>€</p>
                        
                        <span class="time">Posté 
                            {{ $annonce->created_at->diffForHumans()}} le 
                            {{ $annonce->created_at->isoFormat('LL')}}
                        </span>
                        
                        @if(Auth::check() && Auth::user()->id == $annonce->user_id)
                        <br>
                            <span class="author"> 
                                <a href="{{ route('user.profile', ['user'=>$annonce->user->id]) }}">Mon profil</a>
                            </span>
                        <br>
                            <div class="author mt-3">
                                <a href="{{ route('annonces.edit', ['annonce'=>$annonce->reference_annonce]) }}" class="btn btn-info">Modifier</a>
                                <form style="display: inline;" action="{{ route('annonces.destroy', ['annonce'=>$annonce->reference_annonce]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
            {{-- fin du post --}}

            {{-- début de pagination --}}
            <div class="pagination mt-5">
                {{ $Annonces->links()}}
            </div>
            {{-- fin de pagination --}}

        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

@stop