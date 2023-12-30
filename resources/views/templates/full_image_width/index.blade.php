<section class="mt-2 py-4">
    <img
        loading="lazy"
        class="w-full object-cover"

        src="{{  \Illuminate\Support\Facades\Storage::url($section->extra['image']) }}"
        alt="{{ settings('site_name') }}"
    >
</section>
