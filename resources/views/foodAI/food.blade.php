<x-layouts.app :title="__('Dashboard')">
    <div class=" h-full w-full flex-1 flex-col gap-2 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden ">
            <x-form :model="$model" />
        </div>
    </div>
</x-layouts.app>

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
