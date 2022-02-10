<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('profile', compact('user'));
    }
    
    public function save(Request $request)
    {
        $input = request()->all();
        $name = $input['name'];
        $email = $input['email'];
        $userId = $input['userId'];
        $picture = $input['picture'] ?? null;
        $newAddress = $input['new_address'];
        $mainAddress = $input['main_address'] ?? '';
        $setMainAddress = $input['set_main_address'] ?? '';

        $user = User::find($userId); //Поиск пользователя с заданным id.
    
        request()->validate([
            'name' => 'required',
            'email' => "email|required|unique:users,email,{$user->id}",
            'picture' => 'mimetypes:image/*',
            'current_password' => 'current_password|nullable',
            'password' => 'confirmed|min:8|nullable'
        ]);

        $user->password = Hash::make($input['password']);
        $user->save();

        Address::where('user_id', $user->id)->update([
            'main' => 0,
        ]);
        Address::where('id', $mainAddress)->update([
            'main' => 1,
        ]);

        if ($newAddress && $setMainAddress) {
            Address::where('user_id', $user->id)->update([
                'main' => 0,
            ]);

            Address::create([
                    'user_id' => $user->id,
                    'address' => $newAddress,
                    'main' => 1,
            ]);
        } elseif ($newAddress) {
                Address::create([
                    'user_id' => $user->id,
                    'address' => $newAddress,
                    'main' => 0
            ]);
            
        }

        if ($picture) {
            $mimeType = $request->file('picture')->getMimeType();
            $type = explode('/', $mimeType);

            if ($type[0] == 'image') {
                $ext = $picture->getClientOriginalExtension();
                $fileName = time() . rand(10000, 99999). "." . $ext;
                $picture->storeAs('public/users', $fileName);
                $user->picture = "users/$fileName";
            } 
            
        }

        $user->name = $name; //Присваиваем новое имя пользователя.
        $user->email = $email; //Присваиваем новую почту.
        $user->save(); //Вызываем метод save, чтобы сохранить изменения в базе.
        return back();
    }

    public function checkUser (User $user) {
        $currentUser = Auth::user();
        if ($currentUser->is_admin || $currentUser->id === $user->id) return false;
        else return true;
    }
}   

