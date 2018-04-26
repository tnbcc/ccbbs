<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth',['except' => ['show']]);
    }

    //用户个人页面
    public function show(User $user)
    {
       return view('users.show',compact('user'));
    }

    //用户编辑展示页面 隐性路由 users/{user}/edit
    public function edit(User $user)
    {
      if(Auth::user()->can('update',$user)){
        return view('users.edit',compact('user'));
      }else{
         return redirect()->route('users.show',Auth::user()->id)->with('danger','您无权编辑别人的个人信息~');
      }

    }

    //用户编辑提交页
    public function update(UserRequest $request,User $user,ImageUploadHandler $uploader)
    {
        $this->authorize('update',$user);
        $data = $request->all();
       if($request->avatar){
           $result = $uploader->save($request->avatar,'avatars',$user->id,362);
           if($result){
                $data['avatar'] = $result['path'];
           }
       }
       $user->update($data);
       return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
