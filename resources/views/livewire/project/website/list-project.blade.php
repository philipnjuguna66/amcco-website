<div>
    <div class="mx-auto px-4 mt-16 grid max-w-4xl grid-cols-1 gap-x-8 gap-y-4 lg:max-w-none lg:grid-cols-{{ $grid }}">

        @foreach($projects as $project)
            <article class="bg-white flex flex-col items-start justify-between shadow-2xl shadow-gray-900/50 rounded-xl ">
                <div class="relative w-full">
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::url($project->featured_image) }}"
                        alt="{{ $project->name }}"
                        class="w-full object-cover">

                </div>
                <div class="max-w-xl py-2 ">
                    <div class="group relative py-4 px-4">
                        <h3 wire:navigate class="mt-1 text-primary-500 text-lg font-bold leading-6">
                            <a href="{{ route('permalink.property.show', $project->link?->slug) }}">
                                <span class="absolute inset-0 text-center"></span>
                                {{ $project->name }}
                            </a>
                        </h3>
                        <div>


                            <p class="flex justify-center text-red-600 font-semibold">
                                Cash Price of Kes. {{ $project->price}}
                            </p>
                        </div>
                        <div class="flex flex-row justify-center gap-4 w-auto">
                            <a
                                wire:navigate
                                href="{{ route('permalink.property.show', $project->link?->slug) }}"
                                class="inline-flex items-center gap-x-1.5 rounded-md bg-secondary-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-secondary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600"

                            >
                                View Details
                            </a>

                        </div>
                    </div>
                </div>
            </article>

        @endforeach



    </div>


    @if($take<3 )
        <div class="py-4 mt-3">
            {{ $projects->links() }}
        </div>
    @endif



</div>
