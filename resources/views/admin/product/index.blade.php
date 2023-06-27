@extends('layouts.admin')

@section('title')
    <title>Danh sách sản phẩm</title>
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
                    {{-- @foreach ($products as $product)
                      <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name}}</td>
                        <td>{{ $product->price}}</td>
                        <td>{{ $product->feature_image_path}}</td>
                        <td>{{ $product->name}}</td>

                        <td>
                          <a href="{{ route('menus.edit',['id' => $menu->id]) }}" class="btn btn-default">Edit</a>
                          <a href="{{ route('menus.delete',['id' => $menu->id]) }}" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                    @endforeach --}}
                  </tbody>
                </table>
              </div>
              <div class="col-md-12">
                {{-- {{ $menus->links() }} --}}
              </div>
          </div>
        </div>
      </div>
    </div>
    
@endsection



