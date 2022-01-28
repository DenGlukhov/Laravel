<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ImportCategories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = [
            'title' => "Список продуктов",
        ];
        return view('admin.products', $data);
    }
    
    public function categories () 
    {
        $data = [
            'title' => "Список категорий",
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
    }

    public function importCategories () 
    {
        ImportCategories::dispatch();
    }
}
