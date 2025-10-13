

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Judul</label>
    <input type="text" name="title" value="{{ old('title', $photo->title ?? '') }}"
        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Caption</label>
    <textarea name="caption" rows="3"
        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('caption', $photo->caption ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Gambar</label>
    <input type="file" name="image"
        class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

    @if (isset($photo) && $photo->image)
        <p class="mt-2 text-sm text-gray-600">Gambar saat ini:</p>
        <img src="{{ asset('storage/' . $photo->image) }}" class="w-32 mt-2 rounded shadow">
    @endif
</div>
