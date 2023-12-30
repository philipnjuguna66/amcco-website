<div>
    <div class="mx-auto px-2 mt-16 grid max-w-4xl grid-cols-1 gap-x-8 gap-y-4 lg:max-w-none lg:grid-cols-{{ $grid }}">
        @foreach($blogs as $blog)
            <article class="flex flex-col items-start justify-between shadow-2xl shadow-gray-900/50 rounded-xl">
                <div class="relative w-full">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}"
                         class=" w-full object-cover ">
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
                            {{ str( $blog->meta_description)->stripTags('p,span')->toHtmlString()  }}
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
