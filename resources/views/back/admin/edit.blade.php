@extends('layouts.master')

@section('title')
Page d'edition d'un article
@endsection

@section('content')
<div class="container">
    <p class="display-4"> Editer un article</p>
    <form action="{{route('admin.update', $product->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col">
                <div class="form">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        @if($product)
                        <input type="text" name="title" id="title" class="form-control" value="{{$product->title}}" />
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="10">{{$product->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label for="title">Prix</label>
                            </div>
                            <div class="col">
                                <input type="text" name="price" id="prix" class="form-control" value="{{$product->price}}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label for="Category">Catégorie</label>
                            </div>
                            <div class="col">
                                <select class="form-control" name="category_id" id="score">
                                    @foreach($categories as $id => $name)
                                    <option {{ $product->category_id == $id ? 'selected' : null }} value="{{$id}}">{{$name}}</option>
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
                                    <option {{ $product->size == $id ? 'selected' : null }} value="{{$size}}">{{$size}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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
                <br />
            </div>
            <div class="col-4">
                @if($product->url_image)
                <div class="form">
                    <div class="form-group">
                        @if($product->genre == 'Femme')
                        <img width="200" src="{{asset('images/femmes/'.$product->url_image)}}" />
                        @else
                        <img width="200" src="{{asset('images/hommes/'.$product->url_image)}}" />
                        @endif
                        <p class="delete_picture">
                            Cocher pour supprimer l'image :<input type="checkbox" name="delete_picture" value="delete_picture" />
                        </p>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label for="Status" class="mb-3">Status</label><br />
                    <p>Publié <input {{ $product->status === 'published' ? 'checked' : null }} type="radio" name="status" value="published" style="margin-left:19px" /></p>
                    Brouillon <input {{ $product->status === 'unpublished' ? 'checked' : null }} type="radio" name="status" value="unpublished" />
                </div>
                <div class="form-group mt-3">
                    <label for="Category">Code produit</label>
                    <select class="form-control" name="code" id="code">
                        @foreach($codes as $code)
                        <option {{ $product->code == $id ? 'selected' : null }} value="{{$code}}"> {{$code}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="Category">Reference produit</label>
                    <input type="text" name="reference" id="reference" class="form-control" value="{{$product->reference}}" />
                </div>
            </div>
        </div>
        <div class="col-6 ml-auto mr-auto">
            <div class="form-group">
                <input type="submit" value="MODIFIER" class="btn btn-secondary btn-block">
            </div>
        </div>
    </form>
</div>
</div>
@endsection