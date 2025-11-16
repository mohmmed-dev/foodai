<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @forelse ($contents as $content)
        <flux:navlist.item  :href="route('content.show',$content->slug)" :current="request()->routeIs('content.show',$content->slug)" wire:navigate class="mb-1">{{ Str::limit($content->title ,15)}}</flux:navlist.item>
        @empty
    @endforelse
    @if ($contents->hasMorePages())
        <div x-intersect="$wire.loadMore()" class="flex justify-center py-2 transition-opacity">
            <flux:icon.loading wire:loading wire:target="loadMore" />
        </div>
    @else
    @endif
</div>
