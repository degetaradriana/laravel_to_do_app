<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <div>
            <label for="profile_photo">Poza de profil</label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
        </div>

        <button type="submit">Încarcă poza</button>
    </form>


    <div style="margin-bottom: 16px;">
        <img id="preview"
            src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('images/default-avatar.png') }}"
            alt="Poza profil"
            width="150"
            style="border-radius: 50%; object-fit: cover; height: 150px;">
    </div>

    <div>
        <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
    </div>

    @error('profile_photo')
        <p style="color:red;">{{ $message }}</p>
    @enderror

    <script>
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <x-app-layout>
    <div class="p-6">
        @elseif (session('success'))
            <div style="color: green; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @include('profile.partials.update-profile-information-form')
        @endif
    </div>
</x-app-layout>
