<div class="">
    <div class="bg-white relative">
        <div class=""  data-carousel="slide">

            <div class="relative h-36 overflow-hidden lg:96">
                @foreach($sliders as $image)


                        <div class=" duration-700  ease-in-out" data-carousel-item>
                            <img  src="{{ \Illuminate\Support\Facades\Storage::url($image) }}"
                                  class="absolute block object-cover bg-center bg-contain bg-no-repeat  w-full object-center -translate-x-1/2 -translate-y-1/2  top-1/2 left-1/2"
                                  alt="{{ $page->meta_title }}">
                        </div>

                @endforeach

            </div>
        </div>
    </div>
</div>
