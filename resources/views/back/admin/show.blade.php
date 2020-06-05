@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6">
        <h1>{{$product->title}}</h1>
        <p><strong>Description : </strong>{{$product->description }}</p>
        <p><strong>Date de création : </strong>{{$product->created_at}}</p>
        <p><strong>Date de mise à jour : </strong>{{$product->updated_at}}</p>
        <p><strong>Status : </strong>{{ $product->status }}</p>
        <p><strong>Code : </strong>{{ $product->code }}</p>
        <p><strong>Reference : </strong>{{ $product->reference }}</p>
        <p><strong>Genre : </strong>{{ $product->genre }}</p>
    </div>
    <div class="col-md-4 mt-4">
        @if(!empty($product->url_image))
        <a href="#" class="thumbnail">
            @if($product->genre == 'Femme')
            <img width="100%" src="{{asset('images/femmes/'.$product->url_image)}}" />
            @else
            <img width="100%" src="{{asset('images/hommes/'.$product->url_image)}}" />
            @endif
        </a>
        @endif
    </div>
</div>
@endsection