<div>
    <form enctype="multipart/form-data"  method="POST" action="{{route('scan')}}" class="w-full p-2 justify-end flex flex-col h-full  gap-1">
        @csrf
        <div class="flex w-full rounded-2xl flex-col overflow-hidden bg-surface-alt text-on-surface has-[p:focus]:outline-2 has-[p:focus]:outline-offset-2 has-[p:focus]:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:has-[p:focus]:outline-primary-dark rounded-radius border">
            <div class="p-2">
                <p id="promptLabel" class="pb-1 pl-2 text-sm font-bold text-on-surface opacity-60 dark:text-on-surface-dark">Prompt</p>
                <p class="scroll-on max-h-44 w-full overflow-y-auto px-2 py-1 focus:outline-hidden" role="textbox" aria-labelledby="promptLabel" x-on:paste.prevent="document.execCommand('insertText', false, $event.clipboardData.getData('text/plain'))" x-ref="promptTextInput" contenteditable></p>
                <textarea  x-ref="promptText" name='text' hidden></textarea>
            </div>
            <flux:error name="text" />
        </div>
        <div class="">
            <div class="flex rounded-2xl w-full items-center justify-center gap-2 text-on-surface dark:border-outline-dark dark:text-on-surface-dark">
                <div class="group">
                    <label for="dropzone-image" class="font-medium text-primary group-focus-within:underline dark:text-primary-dark justify-center items-center flex">
                        <input accept="image/*" id="dropzone-image" onchange="readCoverImage(this)" type="file" name="photo" aria-describedby="validFileFormats" class=" hidden" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-36 h-36">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </label>
                </div>
            </div>
            <flux:error name="photo" />
            <div class=" my-8 w-[150px]  h-[130px] border-2">
                <img class="h-full w-full" src="" alt="" id="cover-image-thumb">
            </div>
        </div>
        <div class="flex w-full items-center justify-end gap-4 px-2.5 py-2">
            <div class="justify-end flex mt-4">
                <flux:button type="submit" variant="primary">{{__("Send")}}</flux:button>
            </div>
        </div>
        <input name="model" value="ProductAnalyzer" type="hidden">
    </form>
</div>

<script>
    function readCoverImage(input) {
        var file = input.files[0];
        var reader  = new FileReader();
        reader.onload = function(e)  {
            var imgElement = document.getElementById('cover-image-thumb');
            imgElement.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
</script>
