<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

Artisan::command('portal:admin', function () {
    $name = $this->ask('Administrator name');
    $email = strtolower(trim((string) $this->ask('Administrator email')));
    $password = $this->secret('Password (at least 12 characters)');
    $validator = Validator::make(compact('name', 'email', 'password'), [
        'name' => 'required|string|max:120', 'email' => 'required|email|max:254|unique:users,email',
        'password' => 'required|string|min:12',
    ]);
    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return 1;
    }
    $user = new User;
    $user->name = $name;
    $user->email = $email;
    $user->password = Hash::make($password);
    $user->is_admin = true;
    $user->save();
    $this->info('Administrator created. Sign in at /login.');

    return 0;
})->purpose('Create an administrator interactively without storing a plain-text password');
