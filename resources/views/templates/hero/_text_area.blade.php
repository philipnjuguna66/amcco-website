<div class="@if($hasBorderColor) shadow-md rounded-md px-4 mt-5 bg-teal-600 text-white py-8 border-b-4 border-primary-600 border-b-primary-600 @endif">

    <div class="prose py-4 leading-6 tracking-loose">
        {{ str($html)->trim(' ')->toHtmlString() }}
    </div>


</div>
