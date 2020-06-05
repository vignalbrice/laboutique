@extends('layouts.master')

@section('title')
Page d'ajout d'un article
@endsection
@section('content')
<div class="container">
    <p class="display-4"> Ajouter un article</p>
    <form action="{{route('admin.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form mt-5">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label for="title">Titre</label>
                            </div>
                            <div class="col">
                                <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}" />
                                @if($errors->has('title'))<span class="error text-white bg-danger">{{ $errors->first('title') }}</span> @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{{old('description')}}</textarea>
                        @if($errors->has('description'))<span class="error text-white bg-danger">{{ $errors->first('description') }}</span> @endif
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label for="title">Prix</label>
                            </div>
                            <div class="col">
                                <input type="text" name="price" id="prix" class="form-control" value="{{old('price')}}" />
                                @if($errors->has('price'))<span class="error text-white bg-danger">{{ $errors->first('price') }}</span> @endif
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label for="Category">Catégorie</label>
                            </div>
                            <div class="col">
                                <select class="form-control" name="category_id" id="score">
                                    @foreach($categories as $id => $name)
                                    <option {{ old('category_id') == $id ? 'selected' : null }} value="{{$id}}"> {{$name}} </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="genre" />
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label for="Category">Taille</label>
                            </div>
                            <div class="col">
                                <select class="form-control" name="size" id="score">
                                    @foreach($sizes as $size)
                                    <option {{ old('size') == $size ? 'selected' : null }} value="{{$size}}"> {{$size}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label for="file">Image</label>
                            </div>
                            <div class="col">
                                <input type="file" name="url_image" class="form-control">
                                @if($errors->has('url_image')) <span class="error bg-warning">{{ $errors->first('url_image')}}</span> @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 ml-auto mr-auto">
                    <div class="form-group">
                        <input type="submit" value="AJOUTER" class="btn btn-secondary btn-block">
                    </div>
                </div>
            </div>
            <div class="col-4 mt-5">
                <div class="form-group">
                    <label for="Status" class="mb-3">Statut</label><br />
                    <p>Publié <input {{ old('status') === 'published' ? 'checked' : null }} type="radio" name="status" value="published" style="margin-left:19px" /></p>
                    Brouillon <input {{ old('status') === 'unpublished' ? 'checked' : null }} type="radio" name="status" value="unpublished" />
                </div>
                <div class="form-group mt-3">
                    <label for="Category">Code produit</label>
                    <select class="form-control" name="code" id="code">
                        @foreach($codes as $code)
                        <option {{ old('code') == $code ? 'selected' : null }} value="{{$code}}"> {{$code}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="Category">Reference produit</label>
                    <input type="text" name="reference" id="reference" class="form-control" value="{{old('reference')}}" />
                    @if($errors->has('reference'))<span class="error text-white bg-danger">{{ $errors->first('reference') }}</span> @endif
                </div>
            </div>
        </div>
</div>
</form>
</div>
</div>
@endsection