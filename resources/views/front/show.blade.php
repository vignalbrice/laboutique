@extends('layouts.master')

@section('content')
<nav aria-label="mt-6 mb-6">
    <ol class="breadcrumb bg-white">
        <li class="breadcrumb-item"><a href="{{route('home')}}">boutique</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ lcfirst($product->genre) }}s</li>
    </ol>
</nav>
<article>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 col-xs-6">
                @foreach ($images as $ref)
                @if($product->genre == $ref->genre)
                <a href="{{ route('show_product', $ref->id) }}">
                    <img width="100" src="{{asset('images/'.lcfirst($product->genre).'s/'.$ref->url_image)}}" class="mb-1" />
                </a>
                @endif
                @endforeach
            </div>
            @if( is_null($product->url_image) == false)
            <div class="col-xs-6 col-md-4">
                @if($product->genre == 'Femme')
                <img width="100%" src="{{asset('images/femmes/'.$product->url_image)}}" />
                @else
                <img width="100%" src="{{asset('images/hommes/'.$product->url_image)}}" />
                @endif </div>
            @endif
            <div class="col-md-4 col-xs-6">
                <p class="h5">{{ $product->title }}</p>
                <div><i class="fas fa-barcode"></i> {{ $product->reference }}</div>
                <div><i class="fas fa-euro-sign"></i> {{ $product->price }} euros </div>
                <p class="mt-3">Taille (en US) </p>
                <select class="form-control" style="width: 25%;">
                    <option>taille</option>
                    <option selected>{{ $product->size}}</option>
                    @foreach($sizes as $size)
                    @if($size !== $product->size)
                    <option value="{{$size}}">{{ $size }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

        </div>
        <h4>Description: </h4>
        <p>{{ $product->description}}</p>
    </div>

</article>
@endsection