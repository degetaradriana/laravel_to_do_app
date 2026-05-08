<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: bold; color: white;">
            {{ __('Lista mea de Todo-uri') }}
        </h2>
    </x-slot>

    <div style="padding: 40px 20px; max-width: 800px; margin: 0 auto;">

        @if(session('status'))
            <p style="color: #4ade80; margin-bottom: 16px;">{{ session('status') }}</p>
        @endif

        {{-- Formular adaugare --}}
        <div style="background: #1e293b; padding: 24px; border-radius: 8px; margin-bottom: 32px;">
            <h3 style="color: white; font-weight: bold; margin-bottom: 16px;">Adaugă un todo nou</h3>
            <form action="{{ route('todos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 12px;">
                    <label style="color: #cbd5e1; display: block; margin-bottom: 4px;">Nume todo *</label>
                    <input type="text" name="title" required
                           style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white;">
                    @error('title')
                        <p style="color: #f87171; font-size: 13px;">{{ $message }}</p>
                    @enderror
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="color: #cbd5e1; display: block; margin-bottom: 4px;">Imagine (opțional)</label>
                    <input type="file" name="image" accept="image/*" style="color: #cbd5e1;">
                    @error('image')
                        <p style="color: #f87171; font-size: 13px;">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        style="padding: 10px 20px; background: #4f46e5; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px;">
                     Adaugă Todo
                </button>
            </form>
        </div>

        {{-- Lista todos --}}
        @forelse($todos as $todo)
            <div style="background: #1e293b; padding: 16px; border-radius: 8px; margin-bottom: 12px; display: flex; align-items: center; gap: 16px;">

                @if($todo->image)
                    <img src="{{ asset('storage/' . $todo->image) }}"
                         alt="Imagine"
                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;">
                @endif

                <div style="flex: 1;">
                    <p style="color: white; font-weight: bold; font-size: 16px;">{{ $todo->title }}</p>
                    <p style="color: #94a3b8; font-size: 13px;">{{ $todo->created_at->format('d.m.Y') }}</p>
                </div>

                <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="padding: 6px 14px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;"
                            onclick="return confirm('Sigur vrei să ștergi?')">
                        Șterge
                    </button>
                </form>
            </div>
        @empty
            <p style="color: #94a3b8;">Nu ai niciun todo încă. Adaugă primul! </p>
        @endforelse

    </div>
</x-app-layout>