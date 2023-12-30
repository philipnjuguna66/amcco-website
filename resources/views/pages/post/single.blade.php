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





</x-guest-layout>
