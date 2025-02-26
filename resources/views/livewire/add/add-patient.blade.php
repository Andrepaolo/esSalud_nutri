<x-dialog-modal wire:model="isOpen">
    <x-slot name="title">
        <h3>{{ isset($patient['id']) ? 'Editar Paciente' : 'Añadir Nuevo Paciente' }}</h3>
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="mb-4">
                <x-label for="nombre" value="Nombre" />
                <x-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer="patient.nombre" autofocus />
                <x-input-error for="patient.nombre" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="apellido" value="Apellido" />
                <x-input id="apellido" type="text" class="mt-1 block w-full" wire:model.defer="patient.apellido" />
                <x-input-error for="patient.apellido" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="fecha_nacimiento" value="Fecha de Nacimiento" />
                <x-input id="fecha_nacimiento" type="date" class="mt-1 block w-full" wire:model.defer="patient.fecha_nacimiento" />
                <x-input-error for="patient.fecha_nacimiento" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="dni" value="DNI" />
                <x-input id="dni" type="text" class="mt-1 block w-full" wire:model.defer="patient.dni" />
                <x-input-error for="patient.dni" class="mt-2" />
            </div>


            <div class="mb-4">
                <x-label for="peso" value="Peso (kg)" />
                <x-input id="peso" type="number" step="0.01" class="mt-1 block w-full" wire:model.defer="patient.peso" />
                <x-input-error for="patient.peso" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="talla" value="Talla (cm)" />
                <x-input id="talla" type="number" step="0.01" class="mt-1 block w-full" wire:model.defer="patient.talla" />
                <x-input-error for="patient.talla" class="mt-2" />
            </div>

            
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('isOpen', false)">
            Cancelar
        </x-secondary-button>

        <x-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
            Guardar
        </x-button>
    </x-slot>
</x-dialog-modal>