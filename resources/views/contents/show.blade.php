<x-layouts.app :title="__('Dashboard')">
    <div class=" h-full w-full flex-1 flex-col gap-2 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden ">
            {{-- {{$content->body}} --}}
            {{$content->title}}
            {{$content->error ? 'No Error' : 'Has Error'}}
            {{$content->type}}
            {{$content->status}}
            {{$content->slug}}
            {{$content->image}}
            @livewire('content.content-show', ['content' => $content], key($content->id))
        </div>
    </div>
</x-layouts.app>
