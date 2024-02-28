<div class=" ">
    <div class="">
        <div class="md:mx-auto max-w-2xl text-center">
            <div class="flex items-center justify-center gap-x-6">
                <a
                    href="{{ route('permalink.show', $link['url']) }}"
                    class="button bg-secondary-600 hover:bg-primary-600 text-white no-underline	hover:ease-in-out duration-300 transition ">
                    {{ $link['label'] }}
                    <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </div>
</div>
