@extends('layout')

@section('content')
<div class="min-h-screen bg-base-200 py-10">
    <div class="max-w-3xl mx-auto px-4">
        <div class="card bg-base-100 shadow-2xl">
            @if (session('status'))
                <div class="alert alert-error rounded-none rounded-t-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-current shrink-0" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="card-body space-y-4">
                @error('message')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror

                <form action="/posts/update/{{ $post->slug }}" enctype="multipart/form-data" method="POST" class="space-y-6">
                    @method('PUT')
                    @csrf

                    {{-- Image --}}
                    <div>
                        <label class="label font-semibold text-base-content/80">Image</label>

                        {{-- Preview --}}
                        <div class="w-full aspect-video rounded-xl overflow-hidden border border-base-300 bg-base-200 mb-2">
                            <img id="imagePreview" src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover" />
                        </div>

                        {{-- File Input --}}
                        <input id="image" name="image" type="file" accept="image/*" class="file-input file-input-bordered w-full" onchange="previewImage(event)">
                        
                        @error('image')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div>
                        <label class="label font-semibold text-base-content/80">Title</label>
                        <input value="{{ $post->title }}" name="title" type="text"
                            class="input input-bordered w-full" placeholder="Title" />
                        @error('title')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="label font-semibold text-base-content/80">Description</label>
                        <textarea name="description" class="textarea textarea-bordered w-full h-32 resize-none"
                            placeholder="Description">{{ trim($post->description) }}</textarea>
                        @error('description')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="label font-semibold text-base-content/80">Category</label>
                        <select name="category_id" class="select select-bordered w-full">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary w-full">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('imagePreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
