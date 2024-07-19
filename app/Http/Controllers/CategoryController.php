<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('categories.form', [
            'category' => new Category(),
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        Category::create($request->input());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category has been created!');
    }

    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('categories.form', [
            'category' => $category
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->input())->save();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category has been updated!');
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()
                ->route('categories.index')
                ->with('success', 'Category has been deleted!');
        } catch (\Exception) {
            return redirect()
                ->route('categories.index')
                ->with('success', 'Failed try to delete the category');
        }

    }
}
