<div class="py-0">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg px-6 py-4 mb-4">
            <h1 class="text-center text-xl font-extrabold text-white">Gestión de Pacientes</h1>
        </div>
        <div class="bg-white shadow-xl sm:rounded-lg px-6 py-4">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center p-3 rounded-lg bg-gray-100 flex-1">
                    <label class="w-full relative text-gray-500 focus-within:text-gray-800 block">
                        <svg class="pointer-events-none w-6 h-6 absolute top-1/2 transform -translate-y-1/2 left-3" viewBox="0 0 25 25" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input wire:model.live.debounce.300ms="search" type="text" class="w-full block pl-14" placeholder="Buscar paciente por DNI" />
                    </label>
                </div>

                <div class="ml-4">
                    <button wire:click="create()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md font-bold tracking-wide cursor-pointer transition duration-300 ease-in-out">
                        + Nuevo Paciente
                    </button>
                    @if($isOpen)
                        @include('livewire.add.add-patient')
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
                    <thead class="bg-gray-800 text-white">
                        <tr class="text-left text-xs font-semibold uppercase">
                            <th class="px-4  text-xs py-2">ID</th>
                            <th class="px-4  text-xs py-2">Nombre</th>
                            <th class="px-4  text-xs py-2">Apellido</th>
                            <th class="px-4  text-xs py-2">Fecha Nacimiento</th>
                            <th class="px-4  text-xs py-2">DNI</th>
                            <th class="px-4  text-xs py-2">Edad</th>
                            <th class="px-4  text-xs py-2">Peso</th>
                            <th class="px-4  text-xs py-2">Talla</th>
                            <th class="px-4  text-xs py-2">IMC</th>
                            <th class="px-4 text-xs py-2 text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($patients as $patient)
                            <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                                <td class="px-4 py-2 text-xs">{{ $patient->id }}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->nombre }}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->apellido }}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->fecha_nacimiento }}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->dni}}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->edad}}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->peso}}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->talla }} </td>
                                <td class="px-4 py-2 text-xs">{{ $patient->imc }}</td>
                                <td class="px-4 py-2 text-xs flex justify-center space-x-2">
                                    <button wire:click="edit({{ $patient->id }})" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                                        Editar
                                    </button>
                                    <button wire:click="$dispatch('deletePatient', { patientId: {{ $patient->id }} })" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-gray-500">No se encontraron pacientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($patients->hasPages())
                <div class="py-3">
                    {{$patients->links()}}
                </div>
            @endif
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('deletePatient', ({ patientId }) => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarla'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deletePatient', { patientId: patientId });
                        Swal.fire(
                            '¡Eliminado!',
                            'El paciente ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });

            Livewire.on('alert', event => {
                if (event && event.title) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: event.title,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    console.error('El mensaje de la alerta no está definido.');
                }
            });
        </script>
    @endpush
</div>