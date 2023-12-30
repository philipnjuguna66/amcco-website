<div class="bg-gray-50 md:py-12 @if($section->extra['bg_white'] )  bg-white @endif">
    <div class="md:mx-auto md:w-4/5 max-w-7xl px-2 lg:px-8">

        <div class="mx-auto max-w-5xl text-center">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">{{ $section->extra['heading'] ?? null }}</h1>

        </div>
        <div class="md:mx-auto md:max-w-5xl md:text-center text-start">
            <p class="mt-6 text-lg leading-8 prose text">
                {!!  $section->extra['sub_heading'] ?? null!!}
            </p>

        </div>

        <div class="mt-4 py-4">
            <div class="grid grid-cols-1 md:grid-cols-{{ $section->extra['columns'] }}  gap-x-2 gap-y-2">
                @foreach($section->extra['columns_sections'] as $index => $columns)
                    <div class="md:text-justify md:max-w-7xl">
                        @foreach($columns as $column)
                                <?php
                                $html = match ($column['type']) {
                                    "header" => view('templates.hero._header', ['heading' => $column['data']['heading'], "subheading" => $column['data']['subheading']])->render(),
                                    "video" => view('templates.embeded._video_iframe', ["autoplay" => 0, 'videoUri' => $column['data']['video_path']])->render(),
                                    "image" => view('templates.hero._image', ['image' => $column['data']['image'], "title" => $column['data']['title'], 'section' => $section])->render(),
                                    "booking_form" => view('templates.hero._site')->render(),
                                    "text_area" => view('templates.hero._text_area', ['html' => $column['data']['body']])->render(),
                                    "slider" => view('templates.hero._slider', ['sliders' => $column['data']['body'], 'page' => $page])->render(),
                                    "masonary_block" => view('templates.hero.masionary', ['masonrySections' => $column['data']['masonary_block'], 'page' => $page])->render(),
                                    "default" => null,
                                };
                                ?>
                            <div class="mx-auto md:px-2">

                                {{ str($html)->toHtmlString() }}
                            </div>

                        @endforeach
                    </div>

                @endforeach

            </div>
        </div>
    </div>
</div>
