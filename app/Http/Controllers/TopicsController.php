<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;

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
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
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

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}
