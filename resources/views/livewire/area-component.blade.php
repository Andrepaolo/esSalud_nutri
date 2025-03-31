<div class="py-1 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="bg-gray-800 text-white text-center py-4 mb-5 rounded-lg shadow-lg">
            <h1 class="text-2xl font-semibold">📌 Áreas</h1>
        </div>

        <!-- Buscar y Crear Nueva Área -->
        <div class="mb-5 flex flex-col sm:flex-row justify-between items-center gap-3">
            <input type="text" wire:model.live="search" placeholder="🔍 Buscar área..." 
                class="px-3 py-2 border rounded-lg w-full sm:w-2/3 shadow focus:ring-2 focus:ring-blue-400 outline-none">
            
            <button type="button" wire:click="create()" 
                class="bg-green-500 hover:bg-slate-700 text-white px-4 py-1.5 rounded-md shadow-md transition transform hover:scale-105 text-sm">➕ Nueva Área
            </button>
            <button wire:click="exportToExcel()"
                class="bg-green-500 hover:bg-slate-700 text-white px-4 py-1.5 rounded-md shadow-md transition transform hover:scale-105 text-sm">
                📊𝄜Exportar a Excel📈✅
            </button>
        </div>

        <!-- Modal para Agregar Área -->
        @if($isOpen)
            <x-dialog-modal wire:model.defer="isOpen" :close-on-click-away="false">  <x-slot name="title">
                    <h3>{{ $area['id'] ? 'Editar Área' : 'Añadir Nueva Área' }}</h3>
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store" id="area-form">
                        <div class="mb-4">
                            <x-label value="Nombre del Área" class="font-bold" />
                            <x-input type="text" wire:model.defer="area.nombre" class="w-full" />
                            <x-input-error for="area.nombre" />
                        </div>
                        <div class="mb-4">
                            <x-label value="pequeña descripción" class="font-bold" />
                            <x-input type="text" wire:model.defer="area.description" class="w-full" />
                            <x-input-error for="area.description" />
                        </div>
                    </form>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$set('isOpen', false)" class="mx-2">
                        Cancelar
                    </x-secondary-button>
                    <x-button type="submit" class="ml-2" form="area-form" wire:loading.attr="disabled" wire:target="store">
                        Guardar
                    </x-button>
                </x-slot>
            </x-dialog-modal>
        @endif

        <!-- Tarjetas de Áreas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($areas as $area)
                <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200 hover:shadow-lg transition">
                    <h2 class="text-lg font-semibold text-blue-600">{{ $area->nombre }}</h2>
                    <p class="text-gray-600 mt-1 text-sm">{{ $area->description }}</p>
                    
                    <div class="flex justify-between mt-3 space-x-2">
                        <button wire:click="edit({{ $area->id }})" 
                            class="bg-yellow-500 text-white px-3 py-1 rounded-md shadow-md transition hover:bg-yellow-600 text-xs">
                            ✏️ Editar
                        </button>

                        <button wire:click="delete({{ $area->id }})" 
                            class="bg-red-500 text-white px-3 py-1 rounded-md shadow-md transition hover:bg-red-600 text-xs">
                            🗑 Eliminar
                        </button>

                        <a href="{{ route('drecords') }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded-md shadow-md transition hover:bg-blue-600 text-xs inline-block text-center">
                                🛏 Ver Camas
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        @if($areas->hasPages())
            <div class="py-4 flex justify-center">
                {{ $areas->links() }}
            </div>
        @endif
    </div>

    <!-- SweetAlert para alertas -->
    @push('js')
    <script>
        Livewire.on('alert', event => {
            Swal.fire({
                title: '¡Éxito!',
                text: event.title,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
    @endpush

    <!-- Componente de Camas -->
    
</div>
