<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteTemporaryFiles;
use App\Jobs\ExportCategories;
use App\Jobs\ExportProducts;
use App\Jobs\ImportCategories;
use App\Jobs\ImportProducts;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
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
        $roles = Role::get();
        
        $data = [
            'title' => "Список пользователей",
            'users' => $users,
            'roles' => $roles
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

    public function updateCategory (Request $request)
    {
        $input = request()->all();
        $name = $input['name'];
        $description = $input['description'];
        $picture = $input['picture'] ?? null;
        $categoryId = $input['category_id'] ?? null;

        if (!$categoryId) {
            session()->flash('needCategoryError');
            return back(); 
        }

        $category = Category::find($categoryId);
       
        request()->validate([
            'picture' => 'nullable|mimetypes:image/*',
        ]);
        if ($picture) {
            $mimeType = request()->file('picture')->getMimeType();
            $type = explode('/', $mimeType);

            if ($type[0] == 'image') {
                $ext = $picture->getClientOriginalExtension();
                $fileName = time() . rand(10000, 99999). "." . $ext;
                $picture->storeAs('public/categories', $fileName);
                $category->picture = "categories/$fileName";
            } 
        } 
        
        if ($name) $category->name = $name;
        if ($description) $category->description = $description;
        $category->save(); //Вызываем метод save, чтобы сохранить изменения в базе.
        session()->flash('updateCategorySuccess');
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

    public function deleteExportFile ()
    {
        DeleteTemporaryFiles::dispatch();
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
                session()->flash('startImport');
                
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

    public function updateProduct ()
    {
        $input = request()->all();
        $name = $input['name'];
        $description = $input['description'];
        $price = $input['price'];
        $picture = $input['picture'] ?? null;
        $productId = $input['product_id'] ?? null;

        if (!$productId) {
            session()->flash('needProductError');
            return back(); 
        }

        $product = Product::find($productId);
       
        request()->validate([
            'picture' => 'nullable|mimetypes:image/*',
        ]);
        if ($picture) {
            $mimeType = request()->file('picture')->getMimeType();
            $type = explode('/', $mimeType);

            if ($type[0] == 'image') {
                $ext = $picture->getClientOriginalExtension();
                $fileName = time() . rand(10000, 99999). "." . $ext;
                $picture->storeAs('public/products', $fileName);
                $product->picture = "products/$fileName";
            } 
        } 
        
        if ($name) $product->name = $name;
        if ($description) $product->description = $description;
        if ($price) $product->price = $price;
        $product->save(); //Вызываем метод save, чтобы сохранить изменения в базе.
        session()->flash('updateProductSuccess');
        return back();
    }

    public function exportProducts () // Экспорт списка продуктов в файл
    {
        ExportProducts::dispatch();
        session()->flash('startExport');
        return back();
    }

    public function importProducts (Request $request)
    {
        $input = request()->all();
        $importFile = $input['importFile'] ?? null;

        if ($importFile) {
           
            $mimeType = $request->file('importFile')->getMimeType();
            $type = explode('/', $mimeType);
            
            if ($type[0] == 'text') {
                $ext = $importFile->getClientOriginalExtension();
                $fileName = "importProducts." . $ext;
                $importFile->storeAs('public/products', $fileName);

                ImportProducts::dispatch();
                session()->flash('startImport');
                
            } else {
                session()->flash('importFileError');
            }

        } else {
            session()->flash('importFileIsMissing');
        }
        
        DeleteTemporaryFiles::dispatch();
        return back();
    }

    public function addRole ()
    {
        request()->validate([
            'new_role' => 'required|min:3',
        ]);
        Role::create([
            'name' => request('new_role')
        ]);
        return back();
    }

    public function applyRole ($id)
    {
        $user = User::find($id);
        if (!$user->roles->contains(request('role_id'))) {
            $user->roles()->attach(Role::find(request('role_id')));
        }
        return back();
    }
}
