<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
        parent::__construct();
    }

    /**
     * Список всіх статей
     */
    public function index()
    {
        return $this->blogPostRepository->getAllWithPaginate();
    }

    /**
     * Створення нової статті
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        // Створюємо об'єкт. Observer сам заповнить user_id, slug, html та дату публікації
        $item = (new BlogPost())->create($data);

        if ($item) {
            return ['success' => true, 'message' => 'Успішно збережено'];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    /**
     * Оновлення статті
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();

        /*
           Зверни увагу: ми видалили звідси перевірку slug та published_at,
           бо тепер це робить BlogPostObserver!
        */
        $result = $item->update($data);

        if ($result) {
            return ['success' => true, 'message' => 'Успішно збережено'];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    /**
     * Видалення статті (Soft Delete)
     */
    public function destroy($id)
    {
        // Використовуємо м'яке видалення
        $result = BlogPost::destroy($id);

        if ($result) {
            return ['success' => true, 'message' => "Запис id[$id] видалено"];
        } else {
            return ['message' => 'Помилка видалення'];
        }
    }
}
