<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminRecipeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $query = Recipe::query();

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $recipes = $query->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.recipes.index', compact('recipes', 'search'));
    }

    public function create(): View
    {
        return view('admin.recipes.create', ['recipe' => new Recipe()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Recipe::create($this->validateData($request));

        return redirect()->route('admin.recipes.index')->with('success', __('Recipe created.'));
    }

    public function edit(Recipe $recipe): View
    {
        return view('admin.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $recipe->update($this->validateData($request, $recipe));

        return redirect()->route('admin.recipes.index')->with('success', __('Recipe updated.'));
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        $recipe->delete();

        return redirect()->route('admin.recipes.index')->with('success', __('Recipe deleted.'));
    }

    protected function validateData(Request $request, ?Recipe $recipe = null): array
    {
        $slugRule = Rule::unique('recipes', 'slug');

        if ($recipe) {
            $slugRule->ignore($recipe->id);
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', $slugRule],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'product_link' => ['nullable', 'url'],
            'product_link_text' => ['required', 'string', 'max:80'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
