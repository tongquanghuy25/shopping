@extends('layouts.admin')

@section('title')
    <title>Thêm Slider</title>
@endsection

@section('css')
  <link href="{{ asset('vendors/select2/cdn.jsdelivr.net_npm_select2@4.1.0-rc.0_dist_css_select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('admins/product/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')
  <div class="content-wrapper">
      @include('partials.content-header', ['name' => 'Slider', 'key' => 'Add'])
      <form class="needs-validation" action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">
                  @csrf
                    <div class="form-group">
                      <label>Tên slider</label>
                      <input type="text" 
                      class="form-control @error('name') is-invalid @enderror" 
                      name="name"
                      placeholder="Nhập tên slider ..."
                      value="{{ old('name') }}">
                      @error('name')
                          <div class="text-sm" style="color: red">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label>Mô tả slider</label>
                      <textarea 
                        class="form-control @error('description') is-invalid @enderror" 
                        name="description" rows="4">{{ old('description') }}</textarea>
                      @error('description')
                          <div class="text-sm" style="color: red">{{ $message }}</div>
                      @enderror
                    </div>

                    

                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="file" 
                        class="form-control-file @error('image_path') is-invalid @enderror" 
                        name="image_path">
                        @error('image_path')
                          <div class="text-sm" style="color: red">{{ $message }}</div>
                        @enderror
                      </div>

                    <div class="col-md-12">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
              </div>

              {{-- <div class="col-md-12">
                <div class="form-group">
                  <label for="">Nhập mô tả slider</label>
                  <textarea name="description" class="form-control tinymce_editor_init" srows="10">
                    {{ old('description') }}
                  </textarea>
                  @error('description')
                    <div class="text-sm" style="color: red">{{ $message }}</div>
                  @enderror
                </div>
              </div> --}}


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

