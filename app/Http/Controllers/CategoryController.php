<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Components\Recusive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\CommonMark\Normalizer\SlugNormalizer;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends Controller
{
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
        
    }

    public function index(){
        $categories = $this->category->simplePaginate(5);
        return view('admin.category.index',compact('categories'));
    }

    public function getCategory($parent_id){
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parent_id); 
        return $htmlOption;
        
    }
    
    public function create() {
        $htmlOption = $this->getCategory($parent_id='');
        return view('admin.category.add', compact('htmlOption'));
    }
    
    public function store(Request $request){
        $this->category->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('categories.index');
    }

    public function edit($id){
        $category = $this->category->find($id);
        $htmlOption = $this->getCategory($category->parent_id);
        return view('admin.category.edit',compact('category','htmlOption'));
    }
    
    public function update($id, Request $request){
        $this->category->find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('categories.index');
    }

    public function delete($id){
        $this->category->find($id)->delete();
        return redirect()->route('categories.index');
    }
}
