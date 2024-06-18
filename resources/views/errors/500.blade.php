<x-guest-layout>
@section('title',"Something went wrong")
@section('description', "500")
    @if(str(url()->current())->contains(config('filament.path')))
        {{ str($exception->getMessage() ?? " ")->toHtmlString() }}
    @endif
    <h2 class="text-2xl font-extrabold">Something not right~ ! </h2>
</x-guest-layout>
