<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteTemporaryFiles;
use App\Jobs\ExportCategories;
use App\Jobs\ImportCategories;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function admin () 
    {
        return view('admin.admin');
    }

    public function users () // Список пользователей
    {
        $users = User::get();
        
        $data = [
            'title' => "Список пользователей",
            'users' => $users,
        ];
        return view('admin.users', $data);
    }
    
    public function products () // Список продуктов
    {
        $products = Product::get();
        $categories = Category::get();
        $data = [
            'title' => "Список продуктов",
            'products' => $products,
            'categories' => $categories
        ];
        return view('admin.products', $data);
    }
    
    public function categories () // Список категорий
    {
        $categories = Category::get();
        $data = [
            'title' => "Список категорий",
            'categories' => $categories,
        ];
        return view('admin.categories', $data);
    }
    
    public function enterAsUser ($id) // Вход на сайт под любым пользователем из списка
    {
        Auth::loginUsingId($id);
        return redirect()->route('admin');
    }

    public function createCategory (Request $request) // Создание новой категории
    {
        $input = $request->all();
        $name = $input['name'];
        $description = $input['description'];
        $picture = $input['picture'] ?? null;
        $category = new Category([
            'name' => $name,
            'description' => $description,
            'picture' => $picture
        ]);
        request()->validate([
            'name' => 'required',
            'description' => "required",
            'picture' => 'nullable|mimetypes:image/*',
        ]);
        if ($picture) {
            $mimeType = $request->file('picture')->getMimeType();
            $type = explode('/', $mimeType);

            if ($type[0] == 'image') {
                $ext = $picture->getClientOriginalExtension();
                $fileName = time() . rand(10000, 99999). "." . $ext;
                $picture->storeAs('public/categories', $fileName);
                $category->picture = "categories/$fileName";
            } 
        } else {
            $category->picture = 'categories/no_picture.png';
        }
        $category->save();
        return back();
    }

    public function deleteCategory ($id)
    {
        Category::where('id', $id)->delete();
        return back();
    }

    public function exportCategories () // Экспорт списка категорий в файл
    {
        ExportCategories::dispatch();
        session()->flash('startExportCategories');
        return back();
        
    }

    public function importCategories (Request $request) // Импорт списка категорий из файла
    {
        $input = request()->all();
        $importFile = $input['importFile'] ?? null;

        if ($importFile) {
            // request()->validate([
            //     'importFile' => 'mimetypes:text/*',
            // ]);
            $mimeType = $request->file('importFile')->getMimeType();
            $type = explode('/', $mimeType);
            
            if ($type[0] == 'text') {
                $ext = $importFile->getClientOriginalExtension();
                $fileName = "importCategories." . $ext;
                $importFile->storeAs('public/categories', $fileName);

                ImportCategories::dispatch();
                session()->flash('startImportCategories');
                
            } else {
                session()->flash('importFileError');
            }

        } else {
            session()->flash('importFileIsMissing');
        }
        
        DeleteTemporaryFiles::dispatch();
        return back();
    }   

    public function createProduct (Request $request) // Создание нового продукта
    {
        $input = $request->all();
        $name = $input['name'];
        $description = $input['description'];
        $price = $input['price'];
        $picture = $input['picture'] ?? null;
        $category_id = $input['category_id'] ?? null;
        
        // if (!$category_id) {
        //     session()->flash('categoryError');
        //     return back();
        // }

        $product = new Product([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'picture' => $picture,
            'category_id' => $category_id
        ]);
        request()->validate([
            'name' => 'required',
            'description' => "required",
            'price' => "required",
            'picture' => 'nullable|mimetypes:image/*',
            'category_id' => 'required'
        ]);
        if ($picture) {
            $mimeType = $request->file('picture')->getMimeType();
            $type = explode('/', $mimeType);

            if ($type[0] == 'image') {
                $ext = $picture->getClientOriginalExtension();
                $fileName = time() . rand(10000, 99999). "." . $ext;
                $picture->storeAs('public/products', $fileName);
                $product->picture = "products/$fileName";
            } 
        } else {
            $product->picture = 'products/no_picture.png';
        }
        $product->save();

        return back();
    }
    
    public function deleteProduct ($id)
    {
        Product::where('id', $id)->delete();
        return back();
    }
}
