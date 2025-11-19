<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <h1 class="text-3xl font-bold mb-4">{{ $content->title }}</h1>
    <div class="prose prose-lg">
        {{-- {!! $content->body !!} --}}
    </div>
    <div class="mt-6">
        <a href="{{ route('home') }}" class="text-blue-500 hover:underline">Back to Home</a>
    </div>
    {{
        !empty($content->errors) ? 'Errors found in content.' : 'not'   }}
    {{ !empty($content->self) ? 'Warnings found in content.' : 'not'   }}
    {{ $content->progress}}
</div>

@script

<script>
    $contentId = {{$content->id}};
    document.addEventListener('DOMContentLoaded', function() {
    console.log('ai.result.{{ $content->id }}');
    window.Echo.private('ai.result.{{ $content->id }}')
    .listen('.ai.result.done', (e) => {
        console.log('ckcck');
    });
    console.log('sjdjwww');
    });
</script>
@endscript
