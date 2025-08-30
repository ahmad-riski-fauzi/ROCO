<form action="{{ $action }}" method="GET" class="flex gap-2 w-full m-4 lg:w-200">
    <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        placeholder="Cari postingan..."
        class="border border-gray-600 px-3 py-2 w-full rounded"
        required
    >
    <button type="submit" class="btn btn-neutral">
        Cari
    </button>
</form>
