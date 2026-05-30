<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Repositories\BlogCategoryRepository; // Додали use
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    // Конструктор, який автоматично підключає репозиторій
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        parent::__construct();
    }

    public function index()
    {
        // Тепер запит іде через репозиторій
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);
        return $paginator;
    }

    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        // Тепер пошук іде через репозиторій
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $result = $item->update($data);

        return $result
            ? ['success' => true, 'message' => 'Успішно збережено']
            : ['message' => 'Помилка збереження'];
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Тут можна залишити пряме створення або теж винести в репозиторій (але за лабою так)
        $item = (new \App\Models\BlogCategory())->create($data);

        return $item
            ? ['success' => true, 'message' => 'Успішно збережено']
            : ['message' => 'Помилка збереження'];
    }
}
