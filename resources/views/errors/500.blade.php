<x-guest-layout>
@section('title',"Something went wrong")
@section('description', "500")
   <div class="mx-auto py-3 mt-12 max-w-4xl">
       @if(str(url()->current())->contains(config('filament.path')))
           <div class="text-2xl font-extrabold">
               {{ str($exception->getMessage() ?? " ")->toHtmlString() }}
           </div>

       @else
           <h2 class="text-2xl font-extrabold">Something not right~ ! </h2>
       @endif
   </div>

</x-guest-layout>
