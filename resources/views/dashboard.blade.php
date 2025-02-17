<x-app-layout>
    <x-slot name="header">
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-1 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('area-component')
            </div>
        </div>
    </div>
</x-app-layout>
