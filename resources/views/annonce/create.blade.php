
@extends('layouts.main')
@section('content')

<div class="row">
    <!-- views/includes/sidebar.blade.php -->
    <div class="col-lg-3">
        @include('includes.sidebar')
    </div>
    <!-- /.col-lg-3 -->

    <div class="col-lg-9">

        <!-- affiche un message de success lorsqu'un nouvel utilisateur s'est inscrit -->
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        
        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Ajouter un nouvel article
            </div>
        </div>
        <!-- /.card -->

        <div class="card-body">
            <!-- Formulaire cretion article -->
            <form action=" {{ route('annonces.store')}} " method="POST">
                @csrf
                {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> --}}
                <div class="mb-3 form-group">
                    <label for="reference_annonce" class="form-label">Référence</label>
                    <input type="text" name="reference_annonce" class="form-control" value="{{ old('reference_annonce') }}">
                    @error('reference_annonce')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-group">
                    <label for="prix_annonce" class="form-label">Prix</label>
                    <input type="text" name="prix_annonce" class="form-control" value="{{ old('prix_annonce') }}">
                    @error('prix_annonce')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-group">
                    <label for="nombre_de_piece">Nombre de piece :</label>
                    <input id="nombre_de_piece" type="number" name="nombre_de_piece" value="{{ old('nombre_de_piece') }}">
                    @error('nombre_de_piece')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-group">
                    <label for="surface_habitable" class="form-label">Surface habitable en m²</label>
                    <input id="surface_habitable" name="surface_habitable" type="text" value="{{ old('surface_habitable') }}">
                    @error('surface_habitable')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-group">
                    <label for="description_annonce" class="form-label">description</label>
                    <textarea name="description_annonce" cols="30" rows="10" class="form-control">{{ old('description_annonce') }}</textarea>
                    @error('description_annonce')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.col-lg-9 -->

</div>

@stop