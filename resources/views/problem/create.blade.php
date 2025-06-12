<x-app-layout>
    {{-- ========= PAGE TITLE ========= --}}
    <x-slot name="header">
        <div class="text-center">
            <h2 class="text-3xl font-bold">Post a Problem</h2>
            <a href="#" class="text-sm text-blue-600 hover:underline">How to post</a>
        </div>
    </x-slot>

    {{-- ========= Toast UI Editor CSS ========= --}}
    <link rel="stylesheet"
          href="https://uicdn.toast.com/editor/latest/toastui-editor.css" />

    <div class="max-w-5xl mx-auto p-8" x-data="{ tab:'problem' }">
        {{-- ========= DROP-ZONE ========= --}}
        <form x-ref="zipForm"
              action="{{ route('problems.store') }}" method="POST"
              enctype="multipart/form-data"
              class="bg-gray-50 border rounded-md p-6 flex flex-col
                     items-center justify-center text-gray-600"
              @drop.prevent="$refs.fileInput.files=$event.dataTransfer.files"
              @dragover.prevent>
            @csrf
            <p class="pointer-events-none">
                Drop a zip file here, or click to choose.
            </p>
            <input type="file" name="cases_zip" accept=".zip"
                   x-ref="fileInput" class="hidden"
                   @change="$refs.fileLabel.textContent =
                            $event.target.files[0]?.name || 'Choose file'">
            <button type="button"
                    class="mt-3 px-4 py-1 border rounded"
                    @click="$refs.fileInput.click()">Choose file</button>
            <span x-ref="fileLabel" class="ml-2 text-sm">No file chosen</span>

            <div class="flex items-center my-4 text-gray-400">
                <div class="flex-grow h-px bg-gray-300"></div>
                <span class="px-4">OR</span>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>
        </form>

        {{-- ========= TABS ========= --}}
        <nav class="border-b mb-6">
            <ul class="flex space-x-8 text-gray-600 font-medium">
                <li><button @click="tab='problem'"
                        :class="tab==='problem' && 'text-blue-600 border-b-2 border-blue-600'"
                        class="pb-3">Problem</button></li>
                <li><button @click="tab='cases'"
                        :class="tab==='cases' && 'text-blue-600 border-b-2 border-blue-600'"
                        class="pb-3">Testcases</button></li>
                <li><button @click="tab='editorial'"
                        :class="tab==='editorial' && 'text-blue-600 border-b-2 border-blue-600'"
                        class="pb-3">Editorial</button></li>
                <li><button @click="tab='judge'"
                        :class="tab==='judge' && 'text-blue-600 border-b-2 border-blue-600'"
                        class="pb-3">Judge Settings</button></li>
            </ul>
        </nav>

        {{-- ========= PROBLEM TAB ========= --}}
        <form x-show="tab==='problem'" x-cloak
              action="{{ route('problems.store') }}" method="POST"
              enctype="multipart/form-data"
              @submit="$refs.statement.value = editor.getMarkdown()">
            @csrf
            {{-- Slug & Title --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-1"
                           for="slug">Problem Slug</label>
                    <input id="slug" name="slug" type="text"
                           class="w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1"
                           for="title">Title *</label>
                    <input id="title" name="title" type="text" required
                           class="w-full border rounded px-3 py-2" />
                </div>
            </div>

            {{-- Visibility --}}
            <label class="inline-flex items-center mt-6">
                <input id="listed" name="listed" type="checkbox"
                       class="rounded border-gray-300">
                <span class="ml-2">Hide from problem list</span>
            </label>

            {{-- Markdown Editor --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold mb-1">
                    Problem Statement (Markdown) *
                </label>
                <input type="hidden" name="statement" x-ref="statement">
                <div id="editor" class="border rounded"></div>
            </div>

            {{-- Preview --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold mb-1">
                    Preview
                </label>
                <div id="preview"
                     class="prose max-w-none border rounded p-4 bg-gray-50"></div>
            </div>

            <button class="mt-8 px-6 py-2 bg-blue-600 text-white rounded">
                Publish
            </button>
        </form>

        {{-- ========= PLACEHOLDERS ========= --}}
        <div x-show="tab==='cases'" x-cloak>Testcase editor coming soon…</div>
        <div x-show="tab==='editorial'" x-cloak>Editorial input coming soon…</div>
        <div x-show="tab==='judge'" x-cloak>Judge settings coming soon…</div>
    </div>

    {{-- ========= Toast UI Editor JS & Preview Sync ========= --}}
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
    <script>
        const editor = new toastui.Editor({
            el: document.querySelector('#editor'),
            height: '420px',
            initialEditType: 'markdown',
            previewStyle: 'vertical',
            events: {
                change() {
                    document.getElementById('preview').innerHTML =
                        editor.getHTML();
                }
            }
        });
    </script>
</x-app-layout>
