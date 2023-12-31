@extends('layouts.admin')

@section('title')
    <title>Danh sách sản phẩm</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('/admins/product/index/list.css') }}">
@endsection

@section('js')
  <script src="{{ asset('/vendors/sweetAlert2/cdn.jsdelivr.net_npm_sweetalert2@10.js') }}"></script>
  <script src="{{ asset('/admins/product/index/list.js') }}"></script>
@endsection
@section('content')
  <div class="content-wrapper">
      @include('partials.content-header',['name' => 'Product', 'key' => 'List'])
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                  <a href="{{ route('products.create') }}" class="btn btn-success float-right m-2">Add</a>
              </div>
              <div class="col-md-12">
                Trang chủ
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Tên sản phẩm</th>
                      <th scope="col">Giá</th>
                      <th scope="col">Hình ảnh</th>
                      <th scope="col">Danh mục</th>
                      <th scope="col">Acction</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product)
                      <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name}}</td>
                        <td>{{ number_format($product->price)}}</td>
                        <td>
                          <img class="product_image_150_100" src="{{ $product->feature_image_path}}" alt="">
                        </td>
                        <td>{{ $product->category->name}}</td>

                        <td>
                          <a href="{{ route('products.edit',['id' => $product->id]) }}" class="btn btn-default">Edit</a>
                          <a href="" 
                             data-url="{{ route('products.delete',['id' => $product->id]) }}"
                             class="btn btn-danger action_delete">Delete
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="col-md-12">
                {{ $products->links() }}
              </div>
          </div>
        </div>
      </div>
    </div>
    
@endsection



