<x-layouts.app :title="__('Dashboard')">
    <div class=" h-full w-full flex-1 flex-col gap-2 rounded-xl md:grid grid-cols-6 p-2 md:p-3">
        <div class="relative h-full flex-1 overflow-hidden  gap-4 col-start-2 col-span-4  rounded-xl border border-neutral-200 dark:border-neutral-700">
            @livewire('countent-form')
        </div>
    </div>
</x-layouts.app>
