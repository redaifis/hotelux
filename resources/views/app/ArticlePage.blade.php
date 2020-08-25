@extends('layouts.app')

@section('content')
    <blog-article></blog-article>
@endsection

<script>
    window.articleId = {!! $articleId !!}
</script>
