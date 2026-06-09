<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;
use App\Models\BlogPost;
// 1. Додаємо імпорт Jobs (Завдань)
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
// 2. Додаємо трейт для роботи з чергами
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;

class PostController extends BaseController
{
    // 3. Використовуємо трейт всередині класу
    use DispatchesJobs;

    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
        parent::__construct();
    }

    public function index()
    {
        return $this->blogPostRepository->getAllWithPaginate();
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item) {
            // 4. ВІДПРАВЛЯЄМО ЗАДАЧУ В ЧЕРГУ ПРИ СТВОРЕННІ
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);

            return ['success' => true, 'message' => 'Успішно збережено'];
        }
        return ['message' => 'Помилка збереження'];
    }

    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return ['success' => true, 'message' => 'Успішно збережено'];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function destroy($id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            // 5. ВІДПРАВЛЯЄМО ЗАДАЧУ В ЧЕРГУ ПРИ ВИДАЛЕННІ (З ЗАТРИМКОЮ 20 СЕК)
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);

            return ['success' => true, 'message' => "Запис id[$id] видалено"];
        }
        return ['message' => 'Помилка видалення'];
    }
}
