<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(
            Category::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->validated($request->all());

        $task = Category::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        return new CategoryResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->isNotAuthorized($category) ? $this->isNotAuthorized($category) : $category->delete();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return $this->isNotAuthorized($category) ? $this->isNotAuthorized($category) : $category->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        return $this->isNotAuthorized($category) ? $this->isNotAuthorized($category) : $category->delete();

    }

    private function isNotAuthorized($task){
        if(Auth::user()->id !== $task->user_id){
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
