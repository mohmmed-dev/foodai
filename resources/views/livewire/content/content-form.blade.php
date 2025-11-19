<div class="  w-full h-full">
        <div>
            <flux:heading size="lg">{{__("FOOD AI")}}</flux:heading>
            <flux:text class="mt-2 flex">{{__('Make changes to your personal details.')}}
            @auth
                @empty(auth()->user()->personality)
                    <div>
                        <flux:modal.trigger name="profile_info">
                            <flux:icon.information-circle />
                        </flux:modal.trigger>
                    </div>
                @else
                @endempty
            @else
            @endauth
            </flux:text>
        </div>
        <form wire:submit='save' class="w-full p-2 justify-end flex flex-col-reverse h-full  gap-1">
            {{-- <div  class="w-full">
                <div class="p-1 md:flex  text-on-surface dark:text-on-surface-dark">
                    <div class="w-1/2">
                        <div class="flex rounded-2xl w-full flex-col items-center justify-center gap-2 text-on-surface dark:border-outline-dark dark:text-on-surface-dark">
                            <div class="group">
                                <label for="fileInputDragDrop" class="font-medium text-primary group-focus-within:underline dark:text-primary-dark justify-center items-center flex">
                                    <input id="fileInputDragDrop" type="file" wire:model="photo" aria-describedby="validFileFormats" class=" hidden" />
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-36 h-36">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    <flux:error name="photo" />
                    @if($photo)
                        <img src="{{$photo->temporaryUrl()}}" class=" w-24 h-24">
                    @endif
                    </div>
                    <div  class="w-1/2">
                        <flux:textarea resize="none" wire:model="text"  class="mt-0" placeholder="No lettuce, tomato, or onion..." />
                        <flux:error name="text" />
                    </div>
                </div>
            </div> --}}
            <div class="flex w-full rounded-2xl flex-col overflow-hidden bg-surface-alt text-on-surface has-[p:focus]:outline-2 has-[p:focus]:outline-offset-2 has-[p:focus]:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:has-[p:focus]:outline-primary-dark rounded-radius border">
                <div class="p-2">
                    <p id="promptLabel" class="pb-1 pl-2 text-sm font-bold text-on-surface opacity-60 dark:text-on-surface-dark">Prompt</p>
                    <p class="scroll-on max-h-44 w-full overflow-y-auto px-2 py-1 focus:outline-hidden" role="textbox" aria-labelledby="promptLabel" x-on:paste.prevent="document.execCommand('insertText', false, $event.clipboardData.getData('text/plain'))" x-ref="promptTextInput" contenteditable></p>
                    <textarea name="promptText" x-ref="promptText" hidden></textarea>
                </div>
                <div class="flex w-full items-center justify-end gap-4 px-2.5 py-2">
                    <div class="justify-end flex mt-4">
                        <flux:button type="submit" variant="primary">{{__("Send")}}</flux:button>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="flex rounded-2xl w-full items-center justify-center gap-2 text-on-surface dark:border-outline-dark dark:text-on-surface-dark">
                    <div class="group">
                        <label for="fileInputDragDrop" class="font-medium text-primary group-focus-within:underline dark:text-primary-dark justify-center items-center flex">
                            <input id="fileInputDragDrop" type="file" wire:model="photo" aria-describedby="validFileFormats" class=" hidden" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-36 h-36">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </label>
                    </div>
                </div>
            <flux:error name="photo" />
            @if($photo)
                <img src="{{$photo->temporaryUrl()}}" class=" w-24 h-24">
            @endif
            </div>
            <div class="mx-auto w-full">
                <div class="sm:flex gap-2 overflow-y-auto rounded-lg scrollbar-thin scrollbar-thumb-outline scrollbar-track-transparent">
                    <label
                        wire:model="model"
                        class="group relative mb-1 sm:mb-0 flex w-full min-w-52 items-center justify-start gap-3 rounded-lg border border-outline bg-surface-alt px-4 py-3 font-medium text-on-surface cursor-pointer transition-all duration-300 ease-in-out
                            hover:border-primary/60 hover:bg-surface
                            dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark
                            hover:dark:border-primary-dark/70"
                    >
                        <input wire:model="model" value="ProductAnalyzer" type="radio" name="radioPlatform" class="hidden peer" checked>

                        <!-- animated indicator -->
                        <span class="flex items-center justify-center w-6 h-6 rounded-full border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-surface-dark transition-transform duration-300 transform peer-checked:scale-110 peer-checked:bg-[var(--color-accent)] peer-checked:border-transparent">
                            <svg class="w-4 h-4 text-transparent peer-checked:text-white transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>

                        <span class="text-sm ml-2 peer-checked:text-primary dark:peer-checked:text-primary-dark transition-colors duration-200">
                            {{ __("Product Analyzer") }}
                        </span>

                        <div class="absolute inset-0 rounded-lg pointer-events-none
                                    peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:ring-2 peer-checked:ring-primary
                                    dark:peer-checked:border-primary-dark dark:peer-checked:bg-primary-dark/10 dark:peer-checked:ring-primary-dark transition-all duration-300">
                        </div>
                    </label>
                    <label
                        wire:model="model"
                        class="group relative flex w-full min-w-52 items-center justify-start gap-3 rounded-lg border border-outline bg-surface-alt px-4 py-3 font-medium text-on-surface cursor-pointer transition-all duration-300 ease-in-out
                            hover:border-primary/60 hover:bg-surface
                            dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark
                            hover:dark:border-primary-dark/70"
                        >
                        <input wire:model="model" value="MealCreator" type="radio" name="radioPlatform" class="hidden peer">

                        <span class="flex items-center justify-center w-6 h-6 rounded-full border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-surface-dark transition-transform duration-300 transform peer-checked:scale-110 peer-checked:bg-[var(--color-accent)] peer-checked:border-transparent">
                            <svg class="w-4 h-4 text-transparent peer-checked:text-white transition-colors duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>

                        <span class="text-sm ml-2 peer-checked:text-primary dark:peer-checked:text-primary-dark transition-colors duration-200">
                            {{ __("Meal Creator") }}
                        </span>

                        <div class="absolute inset-0 rounded-lg pointer-events-none
                                    peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:ring-2 peer-checked:ring-primary
                                    dark:peer-checked:border-primary-dark dark:peer-checked:bg-primary-dark/10 dark:peer-checked:ring-primary-dark transition-all duration-300">
                        </div>
                    </label>
                </div>
            </div>
        </form>
</div>
