<x-guest-layout>
    @section('title', str($page->meta_title)->headline()->title())
    @section('description', $page->meta_description)
    @if(isset($whatsApp->phone_number))
        @section('whatsApp', $whatsApp->phone_number)
    @endif
    @push('metas')

        @meta("title", $page->meta_title)
        @meta("description", $page->meta_description)
    @endpush

    <div class="" style="">


        <div class="mx-auto md:w-4/5 max-w-7xl	 py-8  md:py-12 px-8">
            <h1 class="py-12 md:py-4 font-extrabold text-2xl lg:text-4xl text-center uppercase px-8 md:px-0">{{ $page->name }}</h1>

        </div>
    </div>

    @if(! $page->use_page_builder)
        <div class="pb-8 mx-auto md:w-4/5 max-w-7xl	">


            <div class="">
                <div class="grid grid-cols-1 md:grid-cols-7 gap-4 py-8 px-2 md:px-8">


                    <div class="md:col-span-4">

                        <article class=" ">
                            @if(! is_null($page->video_path))
                                @include('templates.embeded._video_iframe' , [ 'videoUri' =>   $page->video_path, 'autoplay' => true ])
                            @else
                                <img class="h-auto w-auto rounded-lg object-cover object-center"
                                     src="{{  \Illuminate\Support\Facades\Storage::url($page->featured_image)}}"
                                     alt="{{ $page->meta_title }}"
                                >
                            @endif
                        </article>


                        <div class="mx-auto py-12 max-w-7xl prose md:text-justify">

                            <div class="">

                                {{ str($page->body)->toHtmlString() }}

                            </div>
                        </div>

                        <div>

                            <div class="mt-2">
                                @if( ! is_null($page->map)  )
                                    {{  new \Illuminate\Support\HtmlString($page->map) }}
                                @endif
                            </div>

                            <div class="mt-2">
                                @if( ! is_null($page->mutation)  )
                                    <a
                                        target="_blank"
                                        class="button text-white px-8 py-1 rounded"
                                        href="{{ asset(\Illuminate\Support\Facades\Storage::url($page->mutation)) }}">

                                        Download Project Map
                                    </a>

                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="md:col-span-3 overflow-y-scroll stick  z-30 left-0 right-0">

                        <livewire:contact.book-site-visit :page="$page"/>

                        <div class="md:max-w-6xl">
                            <h3 class="font-semibold text-xl md:text-3xl md:font-extrabold text-center px-2 py-4 md:mt-8 lg:py-8">
                                Amenities and Features
                            </h3>

                            @if(is_array($page->amenities))
                                <ul class="list-decimal mx-4">
                                    @foreach($page->amenities as $amenity => $value)

                                        <li class="px-8 font-semibold">
                                            {{ str($value)->toHtmlString() }}
                                        </li>

                                    @endforeach
                                </ul>
                            @else
                                <div class="px-8 py-4 prose">
                                    {{ str($page->amenities)->toHtmlString() }}
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                <div class="max-w-7xl">

                    @if(is_array($page->gallery))

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            @foreach($page->gallery as $gallery)
                                <div>

                                    <img class="h-auto w-full auto rounded-lg object-cover object-center"
                                         src="{{  \Illuminate\Support\Facades\Storage::url($gallery)}}"
                                         alt="{{ $page->meta_title }}"
                                    >
                                </div>
                            @endforeach

                        </div>
                    @endif
                    <div class="">

                        <h3 class="py-4 mt-3 text-center font-bold text-md md:text-4xl">Similar Projects</h3>

                        <livewire:project.website.similar-project :project="$page"/>
                    </div>
                </div>

            </div>
        </div>
    @else

        @foreach($page->extra as $extra)

            <div class="bg-gray-50  @if($extra['extra']['bg_white'] )  bg-white @endif">
                <div class="mx-auto md:w-4/5 max-w-7xl	 py-12 md:mt-20 md:py-16 px-8">
                    <div
                        class="  grid grid-cols-1 md:grid-cols-{{ $extra['extra']['columns'] }}  gap-x-3 space-y-4 mt-4 py-4">
                        @foreach($extra['extra']['columns_sections'] as $index => $columns)
                            <div class="md:text-justify max-w-7xl">
                                @foreach($columns as $column)
                                        <?php
                                        $html = match ($column['type']) {
                                            "header" => view('templates.hero._header', ['heading' => $column['data']['heading'], "subheading" => $column['data']['subheading']])->render(),
                                            "video" => view('templates.embeded._video_iframe', ["autoplay" => $column['data']['autoplay'] ?? false, 'videoUri' => $column['data']['video_path']])->render(),
                                            "image" => view('templates.hero._image', ['image' => $column['data']['image'], 'title' => $page->name])->render(),
                                            "booking_form" => view('templates.hero._site')->render(),
                                            "text_area" => view('templates.hero._text_area', ['html' => $column['data']['body']])->render(),
                                            "slider" => view('templates.hero._slider', ['sliders' => $column['data']['body'], 'page' => $page])->render(),
                                            "default" => null,
                                        };
                                        ?>
                                    {{ str($html)->toHtmlString() }}
                                @endforeach
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>

        @endforeach

    @endif


</x-guest-layout>
