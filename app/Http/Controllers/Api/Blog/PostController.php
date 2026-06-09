<?php

namespace App\Http\Controllers\Api\Blog;

use App\Models\BlogPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
class PostController extends BaseController
{
    use DispatchesJobs;
    public function index()
    {
        $items = BlogPost::all();
        return $items;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item) {
            // ВІДПРАВЛЯЄМО ЗАДАЧУ В ЧЕРГУ
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);

            return ['success' => true, 'message' => 'Успішно збережено'];
        }
        return ['message' => 'Помилка збереження'];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);

            return ['success' => true, 'message' => "Запис id[$id] видалено"];
        }
        return ['message' => 'Помилка видалення'];
    }
}
