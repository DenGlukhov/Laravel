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

    public function users () 
    {
        $users = User::get();
        
        $data = [
            'title' => "Список пользователей",
            'users' => $users,
        ];
        return view('admin.users', $data);
    }
    
    public function products () 
    {
        $products = Product::get();
        $data = [
            'title' => "Список продуктов",
            'products' => $products,
        ];
        return view('admin.products', $data);
    }
    
    public function categories () 
    {
        $categories = Category::get();
        $data = [
            'title' => "Список категорий",
            'categories' => $categories,
        ];
        return view('admin.categories', $data);
    }
    
    public function enterAsUser ($id) 
    {
        Auth::loginUsingId($id);
        return redirect()->route('admin');
    }

    public function exportCategories () 
    {
        ExportCategories::dispatch();
        session()->flash('startExportCategories');
        
    }

    public function importCategories (Request $request)
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
}
