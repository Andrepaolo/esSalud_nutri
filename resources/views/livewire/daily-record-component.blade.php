<div class="py-3 px-2 bg-gray-100 min-h-screen">
    <div class="max-w-full mx-5">

        <div class="bg-gray-800 text-white text-center py-2 mb-3 rounded-lg shadow-lg">
            <h1 class="text-lg font-semibold">📌 Registros Diarios</h1>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 mb-3">
            <input type="date" wire:model.defer="selectedDate"
                   class="px-2 py-1 border rounded-lg shadow focus:ring-2 focus:ring-blue-400 outline-none text-sm">

            <select wire:model.defer="selectedArea"
                    class="px-2 py-1 border rounded-lg shadow focus:ring-2 focus:ring-blue-400 outline-none text-sm">
                <option value="">🔽 Todas las Áreas</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                @endforeach
            </select>

            <button wire:click="filterRecords"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md shadow-md transition transform hover:scale-105 text-xs">
                🔍 Filtrar
            </button>
            

            <div>
                <label for="searchBox" class="block text-xs font-medium text-gray-700">🔍 Buscar:</label>
                <input type="text" id="searchBox" wire:model.live="search" placeholder="Buscar..."
                       class="px-3 py-1 border rounded-lg w-full shadow focus:ring-2 focus:ring-blue-400 outline-none text-sm">
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow-lg p-2">
            <table class="min-w-full border-collapse text-xs  mt-3 mb-7 ">
                <thead>
                        <tr class="bg-gray-200 text-gray-700">
                        <th class="py-1 px-2 w-20">Cama</th>
                        <th class="py-1 px-2 w-48">Paciente</th>
                        <th class="py-1 px-2 w-24">Fecha</th>
                        <th class="py-1 px-2 w-40">Desayuno
                            <a href="{{ route('imprimir.dietas', ['horario' => 'desayuno']) }}?{{ http_build_query(['areaId' => $selectedArea, 'search' => $search, 'selectedDate' => $selectedDate]) }}" target="_blank" class="bg-violet-500 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-violet-700 transition inline-flex items-center justify-center">
                                🖨️
                            </a>
                        </th>
                        <th class="py-1 px-2 w-40">10 AM
                            <a href="{{ route('imprimir.dietas', ['horario' => 'am10']) }}?{{ http_build_query(['areaId' => $selectedArea, 'search' => $search, 'selectedDate' => $selectedDate]) }}" target="_blank" class="bg-violet-500 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-violet-700 transition inline-flex items-center justify-center">
                                🖨️
                            </a>
                        </th>
                        <th class="py-1 px-2 w-40">Almuerzo
                            <a href="{{ route('imprimir.dietas', ['horario' => 'almuerzo']) }}?{{ http_build_query(['areaId' => $selectedArea, 'search' => $search, 'selectedDate' => $selectedDate]) }}" target="_blank" class="bg-violet-500 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-violet-700 transition inline-flex items-center justify-center">
                                🖨️
                            </a>
                        </th>
                        <th class="py-1 px-2 w-40">4 PM
                            <a href="{{ route('imprimir.dietas', ['horario' => 'pm4']) }}?{{ http_build_query(['areaId' => $selectedArea, 'search' => $search, 'selectedDate' => $selectedDate]) }}" target="_blank" class="bg-violet-500 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-violet-700 transition inline-flex items-center justify-center">
                                🖨️
                            </a>
                        </th>
                        <th class="py-1 px-2 w-40">Cena
                            <a href="{{ route('imprimir.dietas', ['horario' => 'cena']) }}?{{ http_build_query(['areaId' => $selectedArea, 'search' => $search, 'selectedDate' => $selectedDate]) }}" target="_blank" class="bg-violet-500 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-violet-700 transition inline-flex items-center justify-center">
                                🖨️
                            </a>
                        </th>
                        <th class="py-1 px-2 w-40">Indicaciones</th>
                        <th class="py-1 px-2 w-40">Diagnóstico</th>
                        <th class="py-1 px-2 w-20">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr class="border-b hover:bg-gray-100">
                            @if ($editingRow === $record->id)
                                <td class="py-1 px-2 font-medium">{{ $record->bed->codigo }}</td>
                                <td class="py-1 px-2 w-52" x-data="{
                                    open: false,
                                    search: '',
                                    page: 1,
                                    perPage: 4,
                                    get filteredPatients() {
                                        let filtered = {{ json_encode($patients) }}.filter(p =>
                                            this.search === '' ||
                                            p.nombre.toLowerCase().includes(this.search.toLowerCase()) ||
                                            p.apellido.toLowerCase().includes(this.search.toLowerCase())
                                        );

                                        let start = (this.page - 1) * this.perPage;
                                        let end = start + this.perPage;
                                        return filtered.slice(start, end);
                                    },
                                    totalPages() {
                                        return Math.ceil({{ json_encode($patients) }}.length / this.perPage);
                                    }
                                    }">
                                    <div class="relative">
                                        <button @click="open = !open" class="w-full px-0.5 py-0.5 border rounded text-left bg-white text-[0.8rem]">
                                            {{ $editedData['patient_id']
                                                ? optional(collect($patients)->firstWhere('id', $editedData['patient_id']))->nombre . ' ' . optional(collect($patients)->firstWhere('id', $editedData['patient_id']))->apellido
                                                : 'Paciente'
                                            }}
                                        </button>

                                        <div x-show="open" @click.away="open = false" class="absolute z-10 w-full bg-white border rounded shadow-lg mt-1 max-h-48 overflow-y-auto">
                                            <input type="text" x-model="search" placeholder="Buscar..." class="w-full px-2 py-1 border-b text-[0.8rem]">

                                            <ul class="max-h-32 overflow-y-auto">
                                                <template x-for="patient in filteredPatients" :key="patient.id">
                                                    <li @click="$wire.set('editedData.patient_id', patient.id); search = ''; open = false; page = 1;"
                                                        class="px-2 py-1 cursor-pointer hover:bg-blue-100 text-xs">
                                                        <span x-text="patient.nombre + ' ' + patient.apellido"></span>
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
                                </td>

                                <td class="py-0 px-0 w-16  text-[0.6rem]">{{ $record->fecha_registro }}</td>

                                <td class="py-1 px-2">
                                    <div class="flex items-center space-x-2">
                                        <textarea rows="3" cols="50" type="text" wire:model.defer="editedData.desayuno" readonly
                                            class="w-full px-1 py-0.5 border rounded bg-gray-100 text-xs resize-y min-h-min" placeholder="Desayuno"></textarea>
                                        <button wire:click="openDietModal('desayuno')"
                                                class="bg-purple-500 text-white rounded-full p-1  hover:bg-red-600 transition-colors duration-200 ease-in-out">
                                            🍏
                                        </button>
                                    </div>
                                </td>
                                <td class="py-1 px-2">
                                    <div class="flex items-center space-x-2">
                                        <textarea rows="3" cols="50" type="text" wire:model.defer="editedData.am10" readonly
                                            class="w-full px-1 py-0.5 border rounded bg-gray-100 text-xs resize-y min-h-min" placeholder="10 AM"></textarea>
                                        <button wire:click="openDietModal('am10')"
                                                class="bg-purple-500 text-white rounded-full p-1  hover:bg-red-600 transition-colors duration-200 ease-in-out">
                                            🍏
                                        </button>
                                    </div>
                                </td>
                                <td class="py-1 px-2">
                                    <div class="flex items-center space-x-2">
                                        <textarea rows="3" cols="50" type="text" wire:model.defer="editedData.almuerzo" readonly
                                               class="w-full px-1 py-0.5 border rounded bg-gray-100 text-xs resize-y min-h-min" placeholder="Almuerzo"></textarea>
                                        <button wire:click="openDietModal('almuerzo')"
                                                class="bg-purple-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200 ease-in-out">
                                            🍏
                                        </button>
                                    </div>
                                </td>
                                <td class="py-1 px-2">
                                    <div class="flex items-center space-x-2">
                                        <textarea rows="3" cols="50" type="text" wire:model.defer="editedData.pm4" readonly
                                               class="w-full px-1 py-0.5 border rounded bg-gray-100 text-xs resize-y min-h-min" placeholder="4 PM"></textarea>
                                        <button wire:click="openDietModal('pm4')"
                                                class="bg-purple-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200 ease-in-out">
                                            🍏
                                        </button>
                                    </div>
                                </td>
                                <td class="py-1 px-2">
                                    <div class="flex items-center space-x-2">
                                        <textarea rows="3" cols="50" type="text" wire:model.defer="editedData.cena" readonly
                                            class="w-full px-1 py-0.5 border rounded bg-gray-100 text-xs resize-y min-h-min" placeholder="Cena"></textarea>
                                        <button wire:click="openDietModal('cena')"
                                                class="bg-purple-500 text-white rounded-full p-1  hover:bg-red-600 transition-colors duration-200 ease-in-out">
                                            🍏
                                        </button>
                                    </div>
                                </td>


                                <td class="py-1 px-2 w-32">
                                    <textarea rows="4" cols="50" type="text" wire:model="editedData.indicaciones" class="w-full px-1 py-0.5  border rounded text-xs" placeholder="Indicaciones"></textarea>
                                </td>
                                <td class="py-1 px-2 w-32">
                                    <textarea rows="4" cols="50" type="text" wire:model="editedData.diagnostico" class="w-full px-1 py-0.5 border rounded text-xs" placeholder="Diagnóstico"></textarea>
                                </td>
                                <td class="py-1 px-2 w-24 flex gap-1">
                                    <button wire:click="saveRow" class="bg-green-500 text-white px-2 py-1 rounded text-[0.6rem]">
                                        💾 Guardar
                                    </button>
                                    <button wire:click="cancelEdit()" class="bg-gray-500 text-white px-1 py-0.5 rounded text-[0.6rem] hover:bg-gray-600 transition">
                                        ❌ Cancelar
                                    </button>
                                </td>
                            @else
                                <td class="py-1 px-2 font-medium">{{ $record->bed->codigo }}</td>
                                <td class="py-1 px-2">
                                    {{ $record->patient->nombre ?? 'N/A' }} {{ $record->patient->apellido ?? '' }}
                                </td>
                                <td class="py-1 px-2">{{ $record->fecha_registro->format('Y-m-d')}}</td>
                                <td class="py-1 px-2">{{ $record->desayuno ?: 'No registrado' }}</td>
                                <td class="py-1 px-2">{{ $record->am10 ?: 'No registrado' }}</td>
                                <td class="py-1 px-2">{{ $record->almuerzo ?: 'No registrado' }}</td>
                                <td class="py-1 px-2">{{ $record->pm4 ?: 'No registrado' }}</td>
                                <td class="py-1 px-2">{{ $record->cena ?: 'No registrado' }}</td>
                                <td class="py-1 px-2 word-break: break-all">{{ $record->indicaciones ?: 'N/A' }}</td>
                                <td class="py-1 px-2 word-break: break-all">{{ $record->diagnostico ?: 'No especificado' }}</td>
                                <td class="py-1 px-2 flex gap-1">
                                    <button wire:click="editRow({{ $record->id }})"
                                            class="bg-yellow-500 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-yellow-600 transition">
                                        ✏️ Editar
                                    </button>
                                    <button wire:click="clearRowFields({{ $record->id }})"
                                        class="bg-gray-400 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-gray-500 transition">
                                        🧹 Limpiar
                                    </button>
                                    <button wire:click="openMovePatientModal({{ $record->id }})"
                                        class="bg-blue-400 text-white px-2 py-0.5 rounded text-[0.6rem] hover:bg-blue-500 transition">
                                        🔄 Mover
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($showDietModal)
        @include('livewire.add.add-diets')
        @endif

        @if($isMovePatientModalOpen)
        @include('livewire.move-patient-modal')
        @endif

        <div class="mt-2">
            {{ $records->links() }}
        </div>
    </div>
    
</div>