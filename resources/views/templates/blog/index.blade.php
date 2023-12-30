<section class="@if($section->extra['bg_white']  ) bg-white @endif">
    <div class="py-12 md:py-24 md:mx-auto md:w-4/5 max-w-7xl ">
        <div {{ $animationEffect }}   class="md:mx-auto px-6 lg:px-8">
            <div class="md:mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl"> {{ str($section->extra['heading'])->toHtmlString() }}</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600"> {{ str($section->extra['subheading'])->toHtmlString() }}</p>
            </div>

            <livewire:blog.blog-list :take="$section->extra['count']"/>




            @if(isset($section->extra['project_link']) && ! is_null($section->extra['project_link']))

                <div class=" ">
                    <div class="px-6 py-2 sm:px-6 sm:py-1 lg:px-8">
                        <div class="md:mx-auto max-w-2xl text-center">
                            <div class="mt-10 flex items-center justify-center gap-x-6">
                                <a
                                    wire:navigate
                                    href="{{ route('permalink.show', $section->extra['project_link']) }}"
                                    class="button bg-secondary-600 hover:bg-primary-600"
                                >
                                    View more blogs <span aria-hidden="true">→</span></a>
                            </div>
                        </div>
                    </div>
                </div>

            @endif


        </div>
    </div>
</section>
