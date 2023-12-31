
@php
    $videoUri = str($videoUri)
    ->replace("watch?v=", "")
    ->replace("https://www.youtube.com/", "https://www.youtube.com/embed/")
    ->replace("https://youtu.be/", "https://www.youtube.com/embed/")
    ->replace("https://www.youtube.com/embed/embed/", "https://www.youtube.com/embed/")
    ->value();

@endphp

<iframe
    src="{{ $videoUri }}?rel=0&&mute=0&controls=0&autoplay={{  $autoplay == true ? 1: 0 }}"
    class="w-full aspect-video py-4"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
    allowfullscreen>

</iframe>
