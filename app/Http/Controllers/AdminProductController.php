<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AdminProductController extends Controller
{
    use StorageImageTrait;
    private $category;
    private $product;
    public function __construct(Category $category, Product $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function index(){
        // $products = $this->product->simplePaginate(5);
        return view('admin.product.index');
    }

    public function getCategory($parent_id){
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parent_id); 
        return $htmlOption;
        
    }

    public function create(){
        $htmlOption = $this->getCategory($parent_id = '');
        return view('admin.product.add', compact('htmlOption'));
    }

    public function store(Request $request){
        $dataProductCreate = [
            'name' => $request->name,
            'price' => $request->price,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id
        ];
        $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path','product');
        if(!empty($dataUploadFeatureImage)){
            $dataProductCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
            $dataProductCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
        }
        $product = $this->product::create($dataProductCreate);

        if($request->hasFile('image_path')){
            foreach($request->image_path as $fileItem){
                $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem,'product');
                ProductImage::create([
                    'product_id' => $product['id'],
                    'image_path' => $dataProductImageDetail['file_path'],
                    'image_name' => $dataProductImageDetail['file_name']
                ]);
            }
        }

    }
    
}
