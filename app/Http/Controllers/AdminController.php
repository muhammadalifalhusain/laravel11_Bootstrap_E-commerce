<?php

namespace App\Http\Controllers; // Namespace harus di atas

use App\Models\Brand; // Import model setelah namespace
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
// Tambahkan ini

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id', 'DESC')->paginate(10); // Perbaikan 'DESC-'
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048' // Perbaikan max2048 menjadi max:2048
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        $image = $request->file('image');
        $file_extention = $image->extension(); // Perbaikan cara mendapatkan ekstensi file
        $file_name = Carbon::now()->timestamp . '.' . $file_extention; // Perbaikan timestamp()

        // Simpan gambar ke dalam folder
        $image->move(public_path('uploads/brands'), $file_name);

        // Panggil fungsi untuk generate thumbnail
        $this->GenerateBrandThumbnailsImage($image, $file_name);

        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand Berhasil di Tambahkan');
    }

    public function GenerateBrandThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');

        // Perbaikan pemrosesan gambar menggunakan Intervention Image
        $img = Image::read($image->path())->resize(124, 124, function($constraint){
            $constraint->aspectRatio();
        });

        $img->save($destinationPath . '/' . $imageName);
    }

    public function categories()
    {
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view('admin.categories',compact('categories'));
    }

    public function category_add(){
        return view('admin.category-add');
    }

    public function category_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048' // Perbaikan max2048 menjadi max:2048
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        $image = $request->file('image');
        $file_extention = $image->extension(); // Perbaikan cara mendapatkan ekstensi file
        $file_name = Carbon::now()->timestamp . '.' . $file_extention; // Perbaikan timestamp()

        // Simpan gambar ke dalam folder
        $image->move(public_path('uploads/categories'), $file_name);

        // Panggil fungsi untuk generate thumbnail
        $this->GenerateCategoryThumbnailsImage($image, $file_name);

        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category Berhasil di Tambahkan');
    
    }

    public function GenerateCategoryThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');

        // Perbaikan pemrosesan gambar menggunakan Intervention Image
        $img = Image::read($image->path())->resize(124, 124, function($constraint){
            $constraint->aspectRatio();
        });

        $img->save($destinationPath . '/' . $imageName);
    }
}
