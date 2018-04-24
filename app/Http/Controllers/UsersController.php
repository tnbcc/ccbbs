<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    //用户个人页面
    public function show(User $user)
    {
       return view('users.show',compact('user'));
    }

    //用户编辑展示页面 隐性路由 users/{user}/edit
    public function edit(User $user)
    {
      return view('users.edit',compact('user'));
    }

    //用户编辑提交页
    public function update(UserRequest $request,User $user)
    {
       $user->update($request->all());
       return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
