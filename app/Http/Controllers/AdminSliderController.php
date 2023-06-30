<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderAddRequest;
use App\Models\Slider;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminSliderController extends Controller
{
    use StorageImageTrait;
    private $slider;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }
    public function index(){
        $sliders = $this->slider->latest()->simplePaginate(5);
        return view('admin.sliders.index',compact('sliders'));
    }

    public function create(){
        return view('admin.sliders.add');
    }

    public function store(SliderAddRequest $request){
        $dataInsert = [
            'name' => $request->name,
            'description' => $request->description
        ];

        $dataImageSilder = $this->storageTraitUpload($request,'image_path','slider');
        if(!empty($dataImageSilder)){
            $dataInsert['image_path'] = $dataImageSilder['file_path'];
            $dataInsert['image_name'] = $dataImageSilder['file_name'];
        }

        $this->slider->create($dataInsert);

        return redirect()->route('sliders.index');
    }
    public function edit($id){
        $slider = $this->slider->find($id);
        return view('admin/sliders/edit',compact('slider'));
    }

    public function update($id, Request $request){
        $dataInsert = [
            'name' => $request->name,
            'description' => $request->description
        ];

        $dataImageSilder = $this->storageTraitUpload($request,'image_path','slider');
        if(!empty($dataImageSilder)){
            $dataInsert['image_path'] = $dataImageSilder['file_path'];
            $dataInsert['image_name'] = $dataImageSilder['file_name'];
        }

        $this->slider->find($id)->update($dataInsert);

        return redirect()->route('sliders.index');
    }

    public function delete($id){
        try {
            $this->slider->find($id)->delete();
            return response([
                'code' => 200,
                'message' => 'success'
            ], 200);

        }catch (\Exception $exception){
            Log::error('Message'.$exception->getMessage().'Line : '.$exception->getLine());
            return response([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
