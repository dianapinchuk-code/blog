<h1>Blog</h1>

@foreach($posts as $post)
    <div style="margin-bottom: 20px;">
        <h2>
            <a href="/post/{{ $post->slug }}">
                {{ $post->title }}
            </a>
        </h2>

        <p>{{ $post->excerpt }}</p>
    </div>
@endforeach

{{ $posts->links() }}
