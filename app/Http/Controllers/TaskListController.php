<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskList\CreateTaskListRequest;
use App\Http\Requests\TaskList\UpdateTaskListRequest;
use App\Http\Resources\TaskListResource;
use App\Page;
use Exception;
use App\TaskList;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{

    public function __construct()
    {
        if(Auth::guard("user_pages")->user()== ''){
            $this->user=Auth::guard("api")->user();
        }else{
            $this->user=Auth::guard("user_pages")->user();
        }
    }


    public function index()
    {
        if ($this->user->hasRole('Admin')) {
            return TaskListResource::collection(TaskList::all());
        } else if ($this->user->hasRole('page-owner')) {
            $taskLists = $this->user->page->taskLists;
            return TaskListResource::collection($taskLists);
        }
    }


    public function store(CreateTaskListRequest $request)
    {
        try {
            if ($this->user->hasRole('page-owner')) {
                $page = Page::findOrFail($this->user->page->id);
                $taskList = new TaskList();
                $taskList->name = $request->name;
                $page->taskLists()->save($taskList);
                return new TaskListResource($taskList);
            } else {
                throw new Exception('Error! You have to be a page owner to create task list!');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


//    public function show($id)
//    {
//        $taskList = TaskList::findOrFail($id);
//        return new TaskListResource($taskList);
//    }


    public function update(UpdateTaskListRequest $request, $id)
    {
        $taskList = TaskList::findOrFail($id);
//        dd($page);

        try {
            if ($this->user->page->id === $taskList->page_id) {
                $page = Page::findOrFail($this->user->page->id);
                $taskList->name = $request->name;
                $page->taskLists()->save($taskList);
                return new TaskListResource($taskList);
            } else {
                throw new Exception('Error! You cannot edit this task list!');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        $taskList = TaskList::findOrFail($id);
        try {
            if ($this->user->page->id === $taskList->page_id) {
                $taskList->delete();
                return response()->json(null, 200);
            } else {
                throw new Exception('Error! You cannot delete this task list!');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
