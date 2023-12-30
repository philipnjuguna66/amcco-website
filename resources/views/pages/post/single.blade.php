<x-guest-layout>
    @section('title', str($post?->meta_title)->headline()->title())
    @section('description', $post?->meta_description)
    @section('cononical', $post?->cononical)
    @push('metas')
        @meta("url",  route('permalink.show', $post->link->slug))
        @meta("type", "Article")
        @meta("title", $post?->meta_title)
        @meta("description", $post?->meta_description)
        @meta("image", asset(Illuminate\Support\Facades\Storage::url($post?->featured_image)))
    @endpush


    <section class="mt-28 py-4 md:mx-auto max-w-7xl md:w-4/5 px-8 prose-md ">


        <div class="md:mx-auto md:w-4/5 md:max-w-5xl ">
            <div class="mt-4">
                <div class="bg-transparent px-6 pt-4 sm:pt-12 lg:px-8 flex justify-center max-w-2xl">
                    <h1 class="font-bold text-2xl text-center">{{ $post->title }}</h1>
                </div>
            </div>

            <div class="col-span-2 ">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($post?->featured_image) }}"
                     class="w-[800px] h-[500px] rounded-md object-contain aspect-ratio"
                     alt="{{ $post?->meta_title }}"
                     loading="lazy"
                >
                <article class="prose md:prose-md mt-12 max-w-7xl justify-center align-middle">

                    {{ str($post?->body)->toHtmlString() }}

                </article>
            </div>
            <div class="col-span-1">



            </div>
        </div>

    </section>


</x-guest-layout>
