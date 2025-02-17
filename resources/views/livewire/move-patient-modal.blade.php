<div x-data="
        {
        movePatientOpen: @entangle('isMovePatientModalOpen'),
        selectedBedCode: $wire.entangle('selectedBedCode'), // <-- Inicializar con Livewire
        selectedAreaName: $wire.entangle('selectedAreaName'),
        open: false,
        search: '',
        page: 1,
        perPage:10 , // Ajusta perPage al número de camas que quieras mostrar por página en el modal
        get filteredBeds() {
            let filtered = {{ json_encode($destinationBeds) }}.filter(bed =>
                this.search === '' ||
                bed.codigo.toLowerCase().includes(this.search.toLowerCase()) ||
                bed.area.nombre.toLowerCase().includes(this.search.toLowerCase())
            );

            let start = (this.page - 1) * this.perPage;
            let end = start + this.perPage;
            return filtered.slice(start, end);
        },
        totalPages() {
            return Math.ceil({{ json_encode($destinationBeds) }}.length / this.perPage);
        }
    }">
<div x-show="movePatientOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-lg font-semibold mb-3">Mover Paciente a otra Cama</h2>

        <div class="mb-4">
            <label for="destinationBed" class="block text-sm font-medium text-gray-700 mb-1">Cama de Destino:</label>
            <div class="relative">
                <button @click="open = !open" type="button" class="w-full px-2 py-1 border rounded text-left bg-white text-sm">
                    Selecciona Cama <span x-text="selectedBedCode ? '(Cama ' + selectedBedCode + ' - Área ' + selectedAreaName + ')' : ''"></span>
                </button>

                <div x-show="open" @click.away="open = false" class="absolute z-10 w-full bg-white border rounded shadow-lg mt-1 max-h-64 overflow-y-auto"style="display: none;">
                    <input type="text" x-model="search" placeholder="Buscar Cama o Área..." class="w-full px-2 py-1 border-b text-xs">

                    <ul class="max-h-40 overflow-y-auto">
                        <template x-for="bed in filteredBeds" :key="bed.id">
                            <li @click="$wire.set('selectedDestinationBedId', bed.id); selectedBedCode = bed.codigo; selectedAreaName = bed.area.nombre; search = ''; open = false; page = 1;"
                                class="px-2 py-1 cursor-pointer hover:bg-blue-100 text-xs flex justify-between">
                                <span x-text="'Cama ' + bed.codigo"></span>
                                <span class="text-gray-500" x-text="'Área: ' + bed.area.nombre"></span>
                            </li>
                        </template>
                    </ul>

                    <div class="flex justify-between items-center px-2 py-0.5 border-t">
                        <button @click="if (page > 1) page--" :disabled="page === 1"
                                class="px-2 py-0.5 text-[0.6rem] bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">⬅ Anterior</button>
                        <span class="text-[0.6rem]">Página <span x-text="page"></span> de <span x-text="totalPages()"></span></span>
                        <button @click="if (page < totalPages()) page++" :disabled="page === totalPages()"
                                class="px-2 py-0.5 text-[0.6rem] bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">Siguiente ➡</button>
                    </div>
                </div>
            </div>
            @error('selectedDestinationBedId') <span class="error text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <button @click="movePatientOpen = false" class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                ❌ Cancelar
            </button>
            <button wire:click="movePatient" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                🚀 Mover Paciente
            </button>
        </div>
    </div>
</div>
</div>