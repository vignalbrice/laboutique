@extends('layouts.master')

@section('title')
Page d'administration
@endsection

@section('content')
@include('back.admin.partials.flash')
<div class="row mt-5 mb-3">
    <nav class="ml-auto mr-auto justify-content-center">
        <ul class="pagination ">
            <li class="page-item">
                {{ $products->links()}}
            </li>
        </ul>
    </nav>
</div>
<div class="row">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Prix</th>
                <th scope="col" class="text-center">Statut</th>
                <th scope="col" class="text-center">Mettre à jour</th>
                <th scope="col" class="text-center">Supprimer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td><a href="{{ route('admin.show',$product->id)}}">{{ $product->title }}</a></td>
                <td>
                    {{ $product->category->title }}
                </td>
                <td>
                    {{ $product->price }}
                </td>
                <td>
                    @if($product->status === "unpublished")
                    <p class="bg-danger text-white text-center p-2">
                        {{$product->status = 'brouillon'}}
                    </p>
                    @elseif($product->status === "published")
                    <p class="bg-success text-white text-center p-2">
                        {{$product->status = 'publié'}}
                    </p>
                    @endif
                </td>
                <td class="text-center">
                    <a type="button" href="{{ route('admin.edit',$product->id) }}">
                        <i class="fas fa-edit"></i> </a>
                </td>
                <td class="text-center">
                    <form class="delete" method="POST" action="{{route('admin.destroy', $product->id)}}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-link text-danger"><i class="fas fa-times"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row mt-5 mb-3">
    <nav class="ml-auto mr-auto justify-content-center">
        <ul class="pagination ">
            <li class="page-item">
                {{ $products->links()}}
            </li>
        </ul>
    </nav>
</div>
@endsection