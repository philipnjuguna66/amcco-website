{{ \Filament\Facades\Filament::renderHook('footer.before') }}

<div class="filament-footer flex items-center justify-center">
    {{ \Filament\Facades\Filament::renderHook('footer.start') }}

   <h3 class="font-extralight text-gray-300"> All Rights Reserved: &copy; {{ now()->format('Y') }}</h3>


    {{ \Filament\Facades\Filament::renderHook('footer.end') }}
</div>

{{ \Filament\Facades\Filament::renderHook('footer.after') }}

<script src="{{ asset('vendor/ckeditor4/ckeditor.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/plugins/colorbutton/plugin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/plugins/colordialog/plugin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/plugins/panelbutton/plugin.min.js"></script>
