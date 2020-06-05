@extends('layouts.master')

@section('content')

<div class="row mt-5 mb-3">
    <nav class="ml-auto mr-auto justify-content-center">
        <ul class="pagination ">
            <li class="page-item">
                {{ $products->links()}}
            </li>
        </ul>
    </nav>
    <p class="text-dark">{{ $categories->category->title }} : {{ $count }} résultat(s)</p>
</div>
<div class="row">
    @forelse($products as $product)
    @if($product->status === "published")
    <div class="col-md-4">
        <div class="card" style="width: 20rem;">
            @if( is_null($product->url_image) == false)
            <a href="{{ route('show_product', $product->id) }}">
                @if($product->genre == 'Femme')
                <img width="100%" class="img" src="{{asset('images/femmes/'.$product->url_image)}}" />
                @else
                <img width="100%" class="img" src="{{asset('images/hommes/'.$product->url_image)}}" />
                @endif </a>
            @endif
        </div>
        <a href="{{ route('show_product', $product->id) }}" class="h6 title">{{ $product->title }}</a>
        @if($product->code === "solde")
        <div class="text-danger font-weight-bold"><i class="fas fa-percentage"></i> <del>{{ $product->code }}</del></div>
        @else
        <div class="text-success font-weight-bold"><i class="fas fa-fire-alt"></i> {{ $product->code }}</div>
        @endif
        <p><i class="fas fa-euro-sign"></i> {{ $product->price }} euros</p>

    </div>
    @endif
    @empty
    @endforelse
</div>
@endsection