<div>
    <div class="md:mx-auto  py-12 mt-16 grid grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

        @foreach($blogs as $blog)
            <article class="flex flex-col items-start justify-between shadow-2xl shadow-gray-900/50 rounded-xl">
                <div class="relative w-full">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}"
                         class="aspect-[16/9] w-full  bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                    <div class="absolute inset-0  ring-1 ring-inset ring-gray-900/10"></div>
                </div>
                <div class="max-w-xl px-4">
                    <div class="group relative py-4">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                            <a href="{{ route('permalink.show', $blog->link->slug) }}">
                                <span class="absolute inset-0"></span>
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                            {{ $blog->meta_description }}
                        </p>
                    </div>
                </div>
            </article>
        @endforeach
    </div>


    @if( $take < 1 )
      <div class="flex justify-center mt-4 py-8 gap-4">
          {{ $blogs->onEachSide(4)->links() }}
      </div>
@endif

</div>
