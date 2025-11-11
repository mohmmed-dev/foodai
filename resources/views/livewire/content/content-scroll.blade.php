<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <flux:navlist.group :heading="__('Countnet')" class="grid mt-10">
        @forelse ($contents as $content)
        <flux:navlist.item  :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ $content->title }}</flux:navlist.item>
        @empty

        @endforelse
    </flux:navlist.group>
    @if ($contents->hasMorePages())
        <div x-intersect="$wire.loadMore()" class="flex justify-center py-4 transition-opacity">
            <span class="loading loading-ring loading-lg" wire:loading wire:target="loadMore"></span>
        </div>
    @else
        <div class="text-center py-4 text-gray-400">
        </div>
    @endif
</div>
