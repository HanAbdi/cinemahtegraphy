<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountManager extends Component
{
    public $users;
    public $activityLogs;
    
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'admin';
    
    // Checkboxes
    public $perm_portofolio = false;
    public $perm_penawaran = false;
    public $perm_mitra_kerja = false;
    public $perm_ulasan_rating = false;
    public $perm_informasi_kantor = false;
    public $perm_live_chat = false;

    public $editId = null;
    public $isConfirmDeleteOpen = false;
    public $delete_id;

    // Confirm Save properties
    public $isConfirmSaveOpen = false;
    public $confirmType = null; // 'demote', 'password', or 'both'
    public $confirmPassword = '';
    public $confirmEmail = '';
    public $tempSaveData = [];

    public function mount()
    {
        // Double check superadmin explicitly just in case
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Hanya Super Admin yang dapat mengakses halaman ini.');
        }
        $this->loadData();
    }

    public function loadData()
    {
        $this->users = User::all();
        $this->activityLogs = ActivityLog::with('user')->latest()->take(50)->get();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = ''; // Don't show existing password
        
        $perms = $user->permissions ?? [];
        $this->perm_portofolio = in_array('portofolio', $perms);
        $this->perm_penawaran = in_array('penawaran', $perms);
        $this->perm_mitra_kerja = in_array('mitra_kerja', $perms);
        $this->perm_ulasan_rating = in_array('ulasan_rating', $perms);
        $this->perm_informasi_kantor = in_array('informasi_kantor', $perms);
        $this->perm_live_chat = in_array('live_chat', $perms);
    }

    public function cancelEdit()
    {
        $this->reset(['editId', 'name', 'email', 'password', 'role', 'perm_portofolio', 'perm_penawaran', 'perm_mitra_kerja', 'perm_ulasan_rating', 'perm_informasi_kantor', 'perm_live_chat', 'isConfirmSaveOpen', 'confirmType', 'confirmPassword', 'confirmEmail', 'tempSaveData']);
        $this->resetValidation();
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->editId)],
            'role' => 'required|in:superadmin,admin',
        ];

        if (!$this->editId) {
            $rules['password'] = 'required|min:8';
        }

        $this->validate($rules);

        // Security Confirmation Check
        if ($this->editId) {
            $user = User::findOrFail($this->editId);
            $is_demoting = $user->role === 'superadmin' && $this->role === 'admin';
            $is_changing_password = !empty($this->password);

            if ($is_demoting && $is_changing_password) {
                $this->confirmType = 'both';
                $this->isConfirmSaveOpen = true;
                return;
            } elseif ($is_demoting) {
                $this->confirmType = 'demote';
                $this->isConfirmSaveOpen = true;
                return;
            } elseif ($is_changing_password) {
                $this->confirmType = 'password';
                $this->isConfirmSaveOpen = true;
                return;
            }
        }

        // If no confirmation needed, proceed to execute save
        $this->executeSave();
    }

    public function executeSave()
    {
        // Re-validate security confirmations if modal was open
        if ($this->isConfirmSaveOpen) {
            if ($this->confirmType === 'demote' || $this->confirmType === 'both') {
                if (!Hash::check($this->confirmPassword, auth()->user()->password)) {
                    $this->addError('confirmPassword', 'Password Super Admin salah.');
                    return;
                }
            }

            if ($this->confirmType === 'password' || $this->confirmType === 'both') {
                $user = User::findOrFail($this->editId);
                if ($this->confirmEmail !== $user->email) {
                    $this->addError('confirmEmail', 'Email konfirmasi tidak cocok dengan email akun saat ini.');
                    return;
                }
            }
        }

        $permissions = [];
        if ($this->perm_portofolio) $permissions[] = 'portofolio';
        if ($this->perm_penawaran) $permissions[] = 'penawaran';
        if ($this->perm_mitra_kerja) $permissions[] = 'mitra_kerja';
        if ($this->perm_ulasan_rating) $permissions[] = 'ulasan_rating';
        if ($this->perm_informasi_kantor) $permissions[] = 'informasi_kantor';
        if ($this->perm_live_chat) $permissions[] = 'live_chat';

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'permissions' => $permissions,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editId) {
            $user = User::findOrFail($this->editId);
            $user->update($data);
            
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => 'User',
                'model_id' => $user->id,
                'description' => "Memperbarui akun {$user->name}",
            ]);

            session()->flash('message', 'Akun berhasil diperbarui.');
        } else {
            $user = User::create($data);
            
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'model_type' => 'User',
                'model_id' => $user->id,
                'description' => "Membuat akun baru: {$user->name}",
            ]);

            session()->flash('message', 'Akun baru berhasil ditambahkan.');
        }

        $this->cancelEdit();
        
        // If user demoted themselves, redirect to dashboard as they no longer have access
        if ($this->editId === auth()->id() && $data['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        $this->loadData();
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
        $this->isConfirmDeleteOpen = true;
    }

    public function delete()
    {
        $user = User::findOrFail($this->delete_id);
        
        // Prevent deleting oneself
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            $this->isConfirmDeleteOpen = false;
            return;
        }

        // Prevent superadmin from deleting another superadmin
        if ($user->role === 'superadmin') {
            session()->flash('error', 'Super Admin tidak dapat dihapus oleh Super Admin lainnya. Silakan ubah rolenya menjadi Admin terlebih dahulu.');
            $this->isConfirmDeleteOpen = false;
            return;
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'User',
            'model_id' => null,
            'description' => "Menghapus akun: {$name}",
        ]);

        session()->flash('message', 'Akun berhasil dihapus.');
        $this->isConfirmDeleteOpen = false;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.account-manager')->layout('components.admin-layout');
    }
}
