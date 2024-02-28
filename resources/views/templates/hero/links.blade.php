<div class=" ">
    <div class="px-6 py-2 sm:px-6 sm:py-1 lg:px-8">
        <div class="md:mx-auto max-w-2xl text-center">
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a
                    href="{{ route('permalink.show', $link['url']) }}"
                    class="button bg-secondary-600 hover:bg-primary-600"
                >
                    {{ $link['label'] }}<span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </div>
</div>
