<section class="    ">

    @section('title', "$location->name project")
    <div class="lg:py-24 mt-8 lg:mt-12 py-12    md:mx-auto md:w-4/5">
        <div class="md:mx-auto max-w-7xl px-6 lg:px-8">


            <div class="lg:mx-auto mt-16 grid max-w-4xl grid-cols-1 gap-x-8 gap-y-20 lg:max-w-none lg:grid-cols-3">

                @foreach($projects as $project)
                    <article
                        class="flex flex-col items-start justify-between shadow-2xl shadow-gray-900/50 rounded-xl ">
                        <div class="relative w-full">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url($project->featured_image) }}"
                                alt="{{ $project->name }}"
                                class=" aspect-[16/9] w-full object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            <div class="absolute inset-0  ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="max-w-xl py-8 ">
                            <div class="group relative py-4 px-4">
                                <h3 class="mt-3 text-lg md:text-2xl font-bold leading-6">
                                    <a href="{{ route('permalink.show', $project->link->slug) }}">
                                        <span class="absolute inset-0 text-center"></span>
                                        {{ $project->name }}
                                    </a>
                                </h3>
                                <div class="flex flex-row justify-between gap-4 w-auto">

                                    <p class="mt-5 line-clamp-3 text-sm leading-1  font-semibold">
                                        {{  money($project->price , 'kes', true) }}
                                    </p>
                                    <a class="mt-5 line-clamp-3  leading-6 text-gray-50 @if($project->status == \App\Utils\Enums\ProjectStatusEnum::SOLD_OUT) bg-rose-600 @else  bg-primary-600 @endif font-semibold rounded-tr-2xl rounded-bl-2xl px-4 py-0.5">
                                        View project
                                    </a>

                                </div>
                            </div>
                        </div>
                    </article>

                @endforeach
            </div>

            <div class="mx-auto">

                {{ $projects->links() }}

            </div>

        </div>

    </div>

</section>



