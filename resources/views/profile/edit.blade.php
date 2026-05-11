@extends('layouts.app')
@section('title', 'Profile Settings')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="page-title">Profile Settings</h1>
        <p class="page-subtitle">Update your public identity and preferences.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-600 dark:text-red-400 font-medium flex items-center gap-2">
                    <span class="material-symbols-rounded text-[16px]">error</span>{{ $error }}
                </p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('profile.edit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Identity Card --}}
        <div class="card-p">
            <h2 class="text-[15px] font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="material-symbols-rounded text-[18px] text-slate-400">person</span>
                Identity
            </h2>

            <div class="flex items-center gap-5 mb-6">
                <div class="relative">
                    <img id="avatar-preview"
                         src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=BBD5DA&color=1A3A3E&size=128' }}"
                         class="w-20 h-20 rounded-xl object-cover border border-slate-200 dark:border-slate-700">
                    <label for="profile_picture"
                           class="absolute -bottom-1.5 -right-1.5 w-7 h-7 bg-slate-900 dark:bg-sn-400 text-white dark:text-sn-900
                                  rounded-full flex items-center justify-center cursor-pointer hover:bg-slate-700 transition-colors shadow-sm">
                        <span class="material-symbols-rounded text-[14px]">photo_camera</span>
                        <input id="profile_picture" type="file" name="profile_picture" class="hidden" accept="image/*"
                               onchange="previewImage(this, 'avatar-preview')">
                    </label>
                </div>
                <div class="text-sm text-slate-500">
                    <p class="font-medium text-slate-700 dark:text-slate-300">Profile photo</p>
                    <p>JPG, PNG or GIF · Max 2 MB</p>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Display Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input-field" placeholder="Your full name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Username</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">@</span>
                        <input type="text" value="{{ $user->username }}" disabled class="input-field pl-7 opacity-60 cursor-not-allowed bg-slate-50 dark:bg-slate-800">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Username cannot be changed.</p>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Bio</label>
                <textarea name="bio" rows="3"
                          class="input-field resize-none"
                          placeholder="Tell the community about yourself, what you study, and what you're passionate about…"
                          maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Up to 500 characters.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                    <span class="material-symbols-rounded text-[14px] align-middle mr-1">school</span>
                    University / School
                </label>
                <input type="text" name="university" value="{{ old('university', $user->university) }}"
                       class="input-field" placeholder="e.g. MIT, Stanford University, IIT Delhi">
            </div>
        </div>

        {{-- Banner Card --}}
        <div class="card-p">
            <h2 class="text-[15px] font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-rounded text-[18px] text-slate-400">panorama</span>
                Banner Image
            </h2>

            <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 mb-4 h-32 relative
                        bg-gradient-to-r from-[#DFF1F1] to-[#C5E4E8]">
                @if($user->banner_image)
                    <img id="banner-preview" src="{{ Storage::url($user->banner_image) }}" class="w-full h-full object-cover">
                @else
                    <img id="banner-preview" src="" class="w-full h-full object-cover hidden">
                @endif
                <label for="banner_image"
                       class="absolute inset-0 flex items-center justify-center cursor-pointer
                              bg-black/0 hover:bg-black/20 transition-colors group">
                    <div class="bg-white/90 text-slate-700 rounded-lg px-4 py-2 text-sm font-semibold
                                opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-2">
                        <span class="material-symbols-rounded text-[18px]">upload</span>
                        Change banner
                    </div>
                    <input id="banner_image" type="file" name="banner_image" class="hidden" accept="image/*"
                           onchange="previewImage(this, 'banner-preview')">
                </label>
            </div>
            <p class="text-[12px] text-slate-400">Recommended: 1500×500 px · JPG or PNG · Max 4 MB</p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('profile.show', $user->username) }}" class="btn-ghost text-sm">
                Cancel
            </a>
            <button type="submit" class="btn-primary text-sm py-2.5 px-6">
                <span class="material-symbols-rounded text-[16px]">save</span>
                Save Changes
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById(previewId);
            el.src = e.target.result;
            el.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
