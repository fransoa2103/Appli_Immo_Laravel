@extends('layouts.main')
@section('content')

<div class="row">
    

    <div class="col-lg-12">

        <!-- affiche un message de success lorsqu'un nouvel utilisateur s'est inscrit -->
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        <!-- affiche un message d'erreur lorsque une saisie de connexion est erronnée -->
        @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        <div class="card my-4">
            <div class="card-header bold">Votre profil</div>
        </div>
        <div class="col row">
            <!-- /.card -->
            <div style="width: 18rem;">
                <img class="card-img-top" src="/images/3G_PICTO_BIG.png" alt="logo 3G-immo">
            </div>
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="\images\photo-by-face-generator_621e15b64ca88a000cac0008.jpg" alt="random image from www.placeimg.com">
                <div class="card-body">
                    <p class="card-text"></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Secteur <h3>ANNECY</h3></li>
                    </ul>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </div>
    <!-- /.col-lg-9 -->

</div>

@stop