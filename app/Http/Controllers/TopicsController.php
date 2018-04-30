<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;
use App\Services\OSS;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


 //防止N+1的问题 使用with做了预加载 做了缓存
  public function index(Request $request,Topic $topic)
	{
		$topics = $topic->withOrder($request->order)->paginate(15);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

   //话题新建页面显示
  public function create(Topic $topic)
	{
    $categories = Category::select('id','name')->get();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
    $topic->fill($request->all());
    $topic->user_id = Auth::id();
    $topic->save();
		return redirect()->route('topics.show', $topic->id)->with('success', '成功创建话题~');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('success', '更新话题成功~');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除话题成功~');
	}

  //阿里云oss图片上传

 public function uploadImage(Request $request)
 {
   // 初始化返回数据，默认是失败的
      $data = [
          'success'   => false,
          'msg'       => '上传失败!',
          'file_path' => ''
      ];
      // 判断是否有上传文件，并赋值给 $file
      if ($file = $request->upload_file) {
          // 保存图片到阿里云oss
    $pic = $file->getRealPath();
          $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
    $key = \Auth::id() . '_' . time() . '_' . str_random(10) . '.' . $extension;
          $result = OSS::upload($key,$pic);
    $path = 'https://'.config('alioss.BucketName').'.oss-cn-beijing.aliyuncs.com/'.$key;
    // 图片保存成功的话
          if ($result) {
              $data['file_path'] = $path;
              $data['msg']       = "上传成功!";
              $data['success']   = true;
          }
      }
      return $data;
 }

}
