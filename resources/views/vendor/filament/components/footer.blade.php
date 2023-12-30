{{ \Filament\Facades\Filament::renderHook('footer.before') }}

<div class="filament-footer flex items-center justify-center">
    {{ \Filament\Facades\Filament::renderHook('footer.start') }}

   <h3 class="font-extralight text-gray-300">InsightPro v3.0.0 | All Rights Reserved: &copy; {{ now()->format('Y') }}</h3>


    {{ \Filament\Facades\Filament::renderHook('footer.end') }}
</div>

{{ \Filament\Facades\Filament::renderHook('footer.after') }}
