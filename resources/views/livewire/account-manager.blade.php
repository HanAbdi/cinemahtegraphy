<div>
    <h2 class="text-2xl font-heading font-bold text-gray-100 mb-6">Manajemen Akun & Hak Akses</h2>
    
    @if (session()->has('message'))
        <div class="mb-4 bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Panel -->
        <div class="lg:col-span-1 bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden flex flex-col h-fit">
            <div class="p-4 border-b border-gray-800 bg-[#111827]">
                <h3 class="font-semibold text-gray-300">{{ $editId ? 'Edit Akun' : 'Tambah Akun Baru' }}</h3>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 px-4 py-2 focus:ring-amber-500 focus:border-amber-500 outline-none" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                    <input type="email" wire:model="email" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 px-4 py-2 focus:ring-amber-500 focus:border-amber-500 outline-none" required>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Password {{ $editId ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label>
                    <input type="password" wire:model="password" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 px-4 py-2 focus:ring-amber-500 focus:border-amber-500 outline-none" {{ $editId ? '' : 'required' }}>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Peran (Role)</label>
                    <select wire:model.live="role" class="w-full custom-select bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 px-4 py-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                        <option value="admin">Admin</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                    @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                @if($role === 'admin')
                <div class="pt-2 border-t border-gray-800">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Izin Akses Fitur</label>
                    <div class="space-y-2">
                        <label class="flex items-center text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" wire:model="perm_portofolio" class="rounded bg-[#0b0f19] border-gray-700 text-amber-500 focus:ring-amber-500 mr-2">
                            Portofolio
                        </label>
                        <label class="flex items-center text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" wire:model="perm_penawaran" class="rounded bg-[#0b0f19] border-gray-700 text-amber-500 focus:ring-amber-500 mr-2">
                            Penawaran Harga
                        </label>
                        <label class="flex items-center text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" wire:model="perm_mitra_kerja" class="rounded bg-[#0b0f19] border-gray-700 text-amber-500 focus:ring-amber-500 mr-2">
                            Mitra Kerja
                        </label>
                        <label class="flex items-center text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" wire:model="perm_live_chat" class="rounded bg-[#0b0f19] border-gray-700 text-amber-500 focus:ring-amber-500 mr-2">
                            Live Chat
                        </label>
                    </div>
                </div>
                @else
                <div class="pt-2 border-t border-gray-800">
                    <p class="text-xs text-amber-500"><i class="fas fa-info-circle mr-1"></i> Super Admin memiliki akses penuh ke semua fitur.</p>
                </div>
                @endif

                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-black font-bold py-2 px-4 rounded-lg transition-colors">
                        {{ $editId ? 'Simpan Perubahan' : 'Buat Akun' }}
                    </button>
                    @if($editId)
                        <button type="button" wire:click="cancelEdit" class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors">
                            Batal
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Lists Panel -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Users List -->
            <div class="bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-800 bg-[#111827]">
                    <h3 class="font-semibold text-gray-300">Daftar Akun Pengguna</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-300">
                        <thead class="bg-[#111827]/50 text-gray-400 uppercase text-xs border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3">Terakhir Login</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($users as $user)
                                <tr class="hover:bg-[#374151]/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        <div class="text-[10px] text-gray-600 mt-1">Dibuat: {{ $user->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->role === 'superadmin')
                                            <span class="text-amber-500 text-xs uppercase font-semibold border border-amber-500/30 bg-amber-500/10 px-2 py-1 rounded">Super Admin</span>
                                        @else
                                            <span class="text-gray-400 text-xs uppercase font-semibold border border-gray-600 bg-gray-800 px-2 py-1 rounded">Admin</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->last_login_at)
                                            <div class="text-gray-300">{{ $user->last_login_at->diffForHumans() }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->last_login_at->format('d/m/Y H:i') }}</div>
                                        @else
                                            <span class="text-gray-600 italic">Belum pernah login</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button wire:click="edit({{ $user->id }})" class="text-blue-400 hover:text-blue-300" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <button wire:click="confirmDelete({{ $user->id }})" class="text-red-500 hover:text-red-400" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-800 bg-[#111827]">
                    <h3 class="font-semibold text-gray-300">Log Aktivitas Terbaru</h3>
                </div>
                <div class="overflow-y-auto max-h-[400px]">
                    <table class="w-full text-left text-sm text-gray-300">
                        <tbody class="divide-y divide-gray-800">
                            @forelse($activityLogs as $log)
                                <tr class="hover:bg-[#374151]/50 transition-colors">
                                    <td class="px-6 py-3 w-1/4">
                                        <div class="font-medium text-white">{{ $log->user->name ?? 'Unknown' }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $log->created_at->format('d/m/y H:i:s') }}</div>
                                    </td>
                                    <td class="px-6 py-3 w-1/6">
                                        @if($log->action == 'login')
                                            <span class="text-green-500"><i class="fas fa-sign-in-alt"></i> Login</span>
                                        @elseif($log->action == 'created')
                                            <span class="text-blue-500"><i class="fas fa-plus"></i> Create</span>
                                        @elseif($log->action == 'updated')
                                            <span class="text-yellow-500"><i class="fas fa-edit"></i> Update</span>
                                        @elseif($log->action == 'deleted')
                                            <span class="text-red-500"><i class="fas fa-trash"></i> Delete</span>
                                        @elseif($log->action == 'replied')
                                            <span class="text-purple-500"><i class="fas fa-reply"></i> Reply</span>
                                        @else
                                            <span class="text-gray-400"><i class="fas fa-bolt"></i> {{ ucfirst($log->action) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="text-gray-300">{{ $log->description }}</div>
                                        @if($log->model_type)
                                            <div class="text-xs text-gray-500">Target: {{ $log->model_type }} #{{ $log->model_id }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada aktivitas yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($isConfirmDeleteOpen)
    <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 px-4">
        <div class="bg-[#1f2937] rounded-lg border border-gray-700 shadow-2xl max-w-md w-full p-6">
            <h3 class="text-xl font-bold text-white mb-2">Konfirmasi Hapus</h3>
            <p class="text-gray-300 mb-6">Apakah Anda yakin ingin menghapus akun ini secara permanen? Akun yang dihapus tidak dapat dipulihkan kembali.</p>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('isConfirmDeleteOpen', false)" class="px-4 py-2 text-gray-300 hover:text-white transition-colors">
                    Batal
                </button>
                <button wire:click="delete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Confirm Save Modal -->
    @if($isConfirmSaveOpen)
    <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 px-4">
        <div class="bg-[#1f2937] rounded-lg border border-gray-700 shadow-2xl max-w-md w-full p-6">
            <h3 class="text-xl font-bold text-amber-500 mb-2"><i class="fas fa-shield-alt mr-2"></i>Konfirmasi Keamanan</h3>
            <p class="text-gray-300 mb-6 text-sm">Perubahan yang Anda lakukan memerlukan verifikasi identitas tambahan demi keamanan akun.</p>
            
            <form wire:submit.prevent="executeSave" class="space-y-4">
                @if($confirmType === 'demote' || $confirmType === 'both')
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">
                        Konfirmasi Password Super Admin (Anda)
                    </label>
                    <p class="text-xs text-gray-500 mb-2">Diperlukan karena Anda akan menurunkan jabatan Super Admin menjadi Admin.</p>
                    <input type="password" wire:model="confirmPassword" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 px-4 py-2 focus:ring-amber-500 focus:border-amber-500 outline-none" required>
                    @error('confirmPassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif

                @if($confirmType === 'password' || $confirmType === 'both')
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">
                        Konfirmasi Email Akun Terkait
                    </label>
                    <p class="text-xs text-gray-500 mb-2">Ketikkan email akun ini untuk mengonfirmasi penggantian password baru.</p>
                    <input type="email" wire:model="confirmEmail" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 px-4 py-2 focus:ring-amber-500 focus:border-amber-500 outline-none" required>
                    @error('confirmEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-6">
                    <button type="button" wire:click="$set('isConfirmSaveOpen', false)" class="px-4 py-2 text-gray-300 hover:text-white transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-black font-bold rounded-lg transition-colors">
                        Verifikasi & Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
