<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Http\Requests\ProductAddRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminProductController extends Controller
{
    use StorageImageTrait;
    private $category;
    private $product;
    private $productImage;
    private $tag;
    private $productTag;
    public function __construct(Category $category, Product $product, ProductImage $productImage, ProductTag $productTag, Tag $tag)
    {
        $this->category = $category;
        $this->product = $product;
        $this->productImage = $productImage;
        $this->productTag = $productTag;
        $this->tag = $tag;
    }

    public function index(){
         $products = $this->product->latest()->simplePaginate(5);
        return view('admin.product.index',compact('products'));
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

    public function store(ProductAddRequest $request){
        try {
            DB::beginTransaction();
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
                    $this->productImage::create([
                        'product_id' => $product['id'],
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name']
                    ]);
                }
            }
    
            
            if(!empty($request->tags)){
                foreach($request->tags as $tag){
                    $tagInstance = $this->tag::firstOrCreate(['name' => $tag]);
                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->attach($tagIds);

            DB::commit();
            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message'.$exception->getMessage().'Line L '.$exception->getLine());
        }
        
    }

    public function edit($id){
        $product = $this->product->find($id);
        $htmlOption = $this->getCategory($parent_id = $product->category_id);
        return view('admin.product.edit', compact('htmlOption','product'));
    }

    public function update($id, Request $request){
        try {
            DB::beginTransaction();
            $dataProductUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->content,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id
            ];

            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path','product');
            if(!empty($dataUploadFeatureImage)){
                $dataProductUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataProductUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }
            $this->product->find($id)->update($dataProductUpdate);
            $product = $this->product->find($id);
            if($request->hasFile('image_path')){
                $this->productImage->where('product_id',$id)->delete();
                foreach($request->image_path as $fileItem){
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem,'product');
                    $this->productImage::create([
                        'product_id' => $product['id'],
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name']
                    ]);
                }
            }
    
            
            if(!empty($request->tags)){
                foreach($request->tags as $tag){
                    $tagInstance = $this->tag::firstOrCreate(['name' => $tag]);
                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->sync($tagIds);

            DB::commit();
            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message'.$exception->getMessage().'Line : '.$exception->getLine());
        }
        
    }

    public function delete($id){
        try {
            $this->product->find($id)->delete();
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