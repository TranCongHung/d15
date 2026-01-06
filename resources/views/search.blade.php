<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results for: {{ $query }}</h1>
    <p>Found {{ $articles->total() }} results</p>

    @if($articles->count() > 0)
        @foreach($articles as $article)
            <div>
                <h2><a href="/articles/{{ $article->slug }}">{{ $article->title }}</a></h2>
                <p>{{ $article->excerpt ?? 'No excerpt' }}</p>
            </div>
        @endforeach
    @else
        <p>No results found</p>
    @endif
</body>
</html>
