<div>
    {{-- The best athlete wants his opponent at his best. --}}
         @forelse ($contents as $content)
        <flux:navlist.item  :href="route('scan')" :current="request()->routeIs('scan')" wire:navigate>{{ Str::limit($content->title ,15)}}</flux:navlist.item>
        @empty
        @endforelse
    @if ($contents->hasMorePages())
        <div x-intersect="$wire.loadMore()" class="flex justify-center py-4 transition-opacity">
            <flux:icon.loading wire:loading wire:target="loadMore" />
        </div>
    @else
    @endif
</div>
