<?php

namespace App\Http\Controllers\Api\Blog\Admin;

// use App\Http\Controllers\Controller; // Це треба закоментувати або видалити
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;

class CategoryController extends BaseController
{
    public function index()
    {
        $paginator = BlogCategory::paginate(5);
        return $paginator;
    }

    public function store(BlogCategoryCreateRequest $request) // Використовуємо BlogCategoryCreateRequest
    {
        $data = $request->input();

        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        // Створюємо об'єкт через модель
        $item = (new \App\Models\BlogCategory())->create($data);

        if ($item) {
            return ['success' => true, 'message' => 'Успішно збережено'];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function update(BlogCategoryUpdateRequest $request, $id) // Замінили клас реквесту
    {
        $item = BlogCategory::find($id);

        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        $result = $item->update($data);

        if ($result) {
            return ['success' => true, 'message' => 'Успішно збережено'];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }
}
