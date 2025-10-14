<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Edit Thumbnail</h2>

        <form id="thumbnail-form" action="{{ route('thumbnails.update', $thumbnail->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded p-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label class="block font-medium mb-2">Judul</label>
                <input type="text" name="title" value="{{ $thumbnail->title }}" class="w-full border-gray-300 rounded" required>
            </div>

            <!-- Caption -->
            <div class="mb-4">
                <label class="block font-medium mb-2">Caption</label>
                <textarea name="caption" class="w-full border-gray-300 rounded" required>{{ $thumbnail->caption }}</textarea>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block font-medium mb-2">Description</label>
                <textarea name="description" class="w-full border-gray-300 rounded" required>{{ $thumbnail->description }}</textarea>
            </div>

            <!-- Background Image Saat Ini -->
            <div class="mb-6">
                <label class="block font-medium mb-2">Background Image Saat Ini</label>
                @if($thumbnail->background_image)
                    <div class="mb-2 border rounded overflow-hidden">
                        <img src="{{ asset('storage/' . $thumbnail->background_image) }}" class="w-full h-48 object-cover">
                    </div>
                @else
                    <p class="text-gray-500 mb-2">Belum ada background image.</p>
                @endif

                <label class="block font-medium mb-2">Ganti Background Image (opsional, 16:9)</label>
                <input type="file" id="bgInput" accept="image/*" class="w-full border-gray-300 rounded">
                <div class="mt-2">
                    <img id="bgPreview" style="display:none; width:100%; max-height:300px; object-fit:cover;">
                </div>
            </div>

            <!-- Gambar Tambahan Saat Ini -->
            <div class="mb-6">
                <label class="block font-medium mb-2">Gambar Saat Ini</label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($thumbnail->images as $img)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-32 object-cover rounded">
                            <label class="absolute top-1 right-1 bg-white bg-opacity-70 rounded p-1 text-sm">
                                <input type="checkbox" name="remove_images[]" value="{{ $img->id }}"> Hapus
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tambah Gambar Baru -->
            <div class="mb-4">
                <label class="block font-medium mb-2">Tambah Gambar Baru (opsional, 4:3)</label>
                <input type="file" id="imagesInput" multiple accept="image/*" class="w-full border-gray-300 rounded">
                <div class="grid grid-cols-3 gap-3 mt-2" id="imagesPreview"></div>
            </div>

            <!-- Hidden Inputs untuk hasil crop -->
            <input type="hidden" name="background_image_cropped" id="backgroundImageCropped">
            <input type="hidden" name="images_cropped" id="imagesCropped">

            <!-- Tombol aksi -->
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui</button>
                <a href="{{ route('thumbnails.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>

    <!-- Cropper.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        let bgCropper;
        const bgInput = document.getElementById('bgInput');
        const bgPreview = document.getElementById('bgPreview');
        const bgHidden = document.getElementById('backgroundImageCropped');

        bgInput.addEventListener('change', function(e){
            const file = e.target.files[0];
            if(!file) return;

            const reader = new FileReader();
            reader.onload = function(event){
                bgPreview.src = event.target.result;
                bgPreview.style.display = 'block';

                if(bgCropper) bgCropper.destroy();
                bgCropper = new Cropper(bgPreview, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    autoCropArea: 1
                });
            };
            reader.readAsDataURL(file);
        });

        // Crop untuk images tambahan
        const imagesInput = document.getElementById('imagesInput');
        const imagesPreview = document.getElementById('imagesPreview');
        const imagesHidden = document.getElementById('imagesCropped');
        let imageCropperList = [];

        imagesInput.addEventListener('change', function(e){
            imagesPreview.innerHTML = '';
            imageCropperList = [];
            const files = Array.from(e.target.files);

            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(event){
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.width = '100%';
                    img.style.objectFit = 'cover';
                    imagesPreview.appendChild(img);

                    const cropper = new Cropper(img, {
                        aspectRatio: 4 / 3,
                        viewMode: 1,
                        autoCropArea: 1
                    });
                    imageCropperList.push(cropper);
                };
                reader.readAsDataURL(file);
            });
        });

        // Submit form
        const form = document.getElementById('thumbnail-form');
        form.addEventListener('submit', function(e){
            e.preventDefault();

            // Crop bg
            if(bgCropper){
                bgCropper.getCroppedCanvas().toBlob(function(blob){
                    const reader = new FileReader();
                    reader.onloadend = function(){
                        bgHidden.value = reader.result;

                        // Crop images tambahan
                        if(imageCropperList.length > 0){
                            let promises = imageCropperList.map(cropper => new Promise(resolve => {
                                cropper.getCroppedCanvas().toBlob(blob => {
                                    const reader2 = new FileReader();
                                    reader2.onloadend = function(){
                                        resolve(reader2.result);
                                    };
                                    reader2.readAsDataURL(blob);
                                });
                            }));

                            Promise.all(promises).then(results => {
                                imagesHidden.value = JSON.stringify(results);
                                form.submit();
                            });
                        } else {
                            form.submit();
                        }
                    };
                });
            } else {
                // Jika bg tidak diganti
                if(imageCropperList.length > 0){
                    let promises = imageCropperList.map(cropper => new Promise(resolve => {
                        cropper.getCroppedCanvas().toBlob(blob => {
                            const reader2 = new FileReader();
                            reader2.onloadend = function(){
                                resolve(reader2.result);
                            };
                            reader2.readAsDataURL(blob);
                        });
                    }));

                    Promise.all(promises).then(results => {
                        imagesHidden.value = JSON.stringify(results);
                        form.submit();
                    });
                } else {
                    form.submit();
                }
            }
        });
    </script>
</x-app-layout>
