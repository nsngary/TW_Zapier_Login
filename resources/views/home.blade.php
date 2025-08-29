@extends('layouts.main')

@section('content')
    {{-- 輪播和熱門區已在版型中包含，這裡是應用程式列表 --}}
    @include('partials.product_list', ['products' => $products])
@endsection