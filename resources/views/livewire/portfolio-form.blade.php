<div>
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-heading font-bold text-white">
            {{ $portfolio_id ? "Edit Portofolio" : "Tambah Portofolio Baru" }}
        </h2>
        <a href="{{ route('admin.portfolios.index') }}" class="text-sm text-gray-400 hover:text-amber-500 transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-[#1f2937] border border-gray-800 rounded-xl shadow-xl p-6 md:p-8">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Judul Project</label>
                    <input type="text" wire:model="title" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error("title") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Klien</label>
                    <input type="text" wire:model="client" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error("client") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Kategori</label>
                    <input type="text" wire:model="category" placeholder="Cth: Commercial" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error("category") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Jenis Layanan</label>
                    <input type="text" wire:model="service_type" placeholder="Cth: TVC Production" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error("service_type") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Tahun</label>
                    <input type="number" wire:model="year" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error("year") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">URL Video (YouTube)</label>
                <input type="text" wire:model="video_url" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                @error("video_url") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div x-data="{
                init() {
                    if (typeof tinymce !== 'undefined') {
                        tinymce.remove('#description-editor');
                        tinymce.init({
                            selector: '#description-editor',
                            plugins: 'lists link code',
                            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline | alignleft aligncenter alignright | bullist numlist | code',
                            skin: 'oxide-dark',
                            content_css: 'dark',
                            height: 350,
                            setup: function (editor) {
                                editor.on('change', function (e) {
                                    $wire.set('description', editor.getContent());
                                });
                            }
                        });
                    }
                }
            }" wire:ignore>
                <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi Lengkap</label>
                <textarea id="description-editor" wire:model.defer="description" rows="8" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors"></textarea>
                @error("description") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Upload Gambar (Thumbnail)</label>
                    @if($old_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $old_image) }}" class="h-20 rounded border border-gray-700" alt="Current Thumbnail">
                        </div>
                    @endif
                    <input type="file" wire:model="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-white hover:file:bg-gray-700 cursor-pointer border border-gray-700 rounded-lg bg-[#111827]">
                    <div wire:loading wire:target="image" class="text-amber-500 text-xs mt-2">Mengunggah...</div>
                    @error("image") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Tags (Pisahkan dengan koma)</label>
                    <input type="text" wire:model="tags" placeholder="Cth: drone, 4k, cinemtic" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    @error("tags") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="bg-[#111827] border border-gray-700 p-5 rounded-lg space-y-4">
                <label class="block text-sm font-medium text-gray-400 mb-2 border-b border-gray-800 pb-2">Pengaturan Tanda/Badge pada Thumbnail</label>
                
                <div class="space-y-3">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe Tanda (Pilih Skema Warna)</label>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <input type="radio" wire:model="tag_scheme" value="A" id="scheme_a" class="w-4 h-4 text-amber-500 bg-gray-900 border-gray-700 focus:ring-amber-500 focus:ring-2">
                            <label for="scheme_a" class="text-sm font-medium text-gray-300 cursor-pointer flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span> Opsi A (Emas)
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" wire:model="tag_scheme" value="B" id="scheme_b" class="w-4 h-4 text-blue-500 bg-gray-900 border-gray-700 focus:ring-blue-500 focus:ring-2">
                            <label for="scheme_b" class="text-sm font-medium text-gray-300 cursor-pointer flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span> Opsi B (Biru)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Teks Tanda (Kosongkan jika tidak ingin ada tanda)</label>
                    <input type="text" wire:model="project_scope" maxlength="20" placeholder="Misal: Nasional, Internasional, atau Regional..." class="w-full md:w-1/2 bg-gray-800 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                    <p class="text-xs text-gray-500 mt-1">Maksimal 20 karakter.</p>
                    @error("project_scope") <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-800">
                <a href="{{ route('admin.portfolios.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-amber-500 hover:bg-amber-600 text-black rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Portofolio
                </button>
            </div>
        </form>
    </div>
</div>

