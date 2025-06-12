<x-app-layout>
<x-slot name="header"><h2 class="text-xl">{{ $problem->title }}</h2></x-slot>

<div class="p-6" id="viewer"></div>

@push('scripts')
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor-viewer.min.css" />
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-viewer.min.js"></script>
<script>
new toastui.Editor.factory({
  el:document.getElementById('viewer'),
  viewer:true,
  initialValue:@json($problem->statement)
});
</script>
@endpush
</x-app-layout>
