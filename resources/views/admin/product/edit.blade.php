@extends('layouts.admin')

@section('title')
    <title>Thêm product</title>
@endsection

@section('css')
  <link href="{{ asset('vendors/select2/cdn.jsdelivr.net_npm_select2@4.1.0-rc.0_dist_css_select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('admins/product/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
  <div class="content-wrapper">
      @include('partials.content-header', ['name' => 'Product', 'key' => 'Add'])
      <form action="{{ route('products.update',['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">
                  @csrf
                    <div class="form-group">
                      <label>Tên sản phẩm</label>
                      <input type="text" 
                      class="form-control" 
                      name="name"
                      placeholder="Nhập tên sản phẩm"
                      value="{{ $product->name }}"
                      >
                    </div>

                    <div class="form-group">
                      <label>Giá sản phẩm</label>
                      <input type="text" 
                      class="form-control" 
                      name="price"
                      placeholder="Nhập giá sản phẩm"
                      value="{{ $product->price }}"
                      >
                    </div>

                    <div class="form-group">
                      <label>Ảnh đại diện</label>
                      <input type="file" 
                      class="form-control-file" 
                      name="feature_image_path">
                      <div class="col-md-12">
                        <div class="row">
                            <img class="image_product" src="{{ $product->feature_image_path }}" alt="">
                          </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Ảnh chi tiết</label>
                      <input type="file" 
                      multiple
                      class="form-control-file" 
                      name="image_path[]">
                      <div class="col-md-12 container_image_detail">
                        <div class="row">
                            @foreach ($product->productImages as $productImage)
                                <div class="col-md-3">
                                    <img class="image_detail_product" src="{{ $productImage->image_path }}" alt="">
                                </div>
                            @endforeach
                        </div>
                      </div>
                    </div>

                    <div class="form-group ">
                        <label>Chọn danh mục</label>
                        <select class="form-control select-init" name="category_id">
                          <option value="">Chọn danh mục</option>
                          {!! $htmlOption !!}
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Nhập tags sản phẩm</label>
                        <select name="tags[]" class="form-control tags_select_chose" multiple="multiple">
                          @foreach ($product->tags as $tag)
                            <option value="{{ $tag->name }}" selected>{{ $tag->name }}</option>    
                          @endforeach
                        </select>  
                      </div>

              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Nhập nội dung</label>
                  <textarea name="content" class="form-control tinymce_editor_init" srows="10">{{ $product->content }}</textarea>
                </div>
              </div>

              <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>

            </div>
          </div>
        </div>
      </form>
    </div>
    
@endsection

@section('js')
  <script src="{{ asset('vendors/select2/cdn.jsdelivr.net_npm_select2@4.1.0-rc.0_dist_js_select2.min.js') }}"></script>
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="{{ asset('admins/product/add/add.js') }}"></script>
@endsection

