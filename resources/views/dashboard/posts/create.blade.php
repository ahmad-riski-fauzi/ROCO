@extends('layout')

@section('content')
<div class="min-h-screen bg-base-200 py-10 px-4">
    <div class="max-w-xl mx-auto bg-base-100 shadow-xl rounded-xl p-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Upload Post</h1>

        @if (session('status'))
            <div class="alert alert-danger mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @error('message')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <form action="{{ route('upload-post') }}" enctype="multipart/form-data" method="POST" class="space-y-4">
            @csrf
            @method('POST')

            <div>
                <label class="block mb-1 font-semibold">Image</label>
                <input type="file" name="image" accept="image/*"
                    class="file-input file-input-bordered w-full" onchange="previewImage(event)">
                @error('image')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <div class="mt-3">
                    <img id="imagePreview" class="rounded-xl max-h-64 hidden object-contain w-full" />
                </div>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Title</label>
                <input value="{{ old('title') }}" name="title" type="text" placeholder="Title"
                    class="input input-bordered w-full" />
                @error('title')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold">Description</label>
                <textarea name="description" class="textarea textarea-bordered w-full" placeholder="Description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-semibold">Category</label>
                <select name="category_id" class="select select-bordered w-full">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button class="btn btn-neutral w-full">Upload</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('imagePreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }
</script>
@endsection
