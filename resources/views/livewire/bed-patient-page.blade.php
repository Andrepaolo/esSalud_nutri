
<div class="py-2 bg-gray-100 min-h-screen"> {{-- Reduje el py-0 a py-2 para un poco de espacio arriba --}}
    <div class="max-w-8xl mx-auto sm:px-3 lg:px-4 pt-4"> {{-- Reduje px-6 a px-3 y lg:px-8 a lg:px-4 y pt-8 a pt-4 para menos padding --}}

        

        <div class="bg-white rounded-lg shadow-xl overflow-hidden sm:rounded-lg ">
            <div class="grid grid-cols-12"> {{-- Usamos grid de 12 columnas --}}

                <div class="p-4 border-r border-gray-200 col-span-12 md:col-span-4"> {{-- Columna Izquierda para Camas, ocupa 4 de 12 columnas (aprox 30%) y reduje p-6 a p-4 --}}
                    

                    @livewire('crud-bed')
                </div>

                <div class="p-4 col-span-12 md:col-span-8"> {{-- Columna Derecha para Pacientes, ocupa 8 de 12 columnas (aprox 70%) y reduje p-6 a p-4 --}}
                    

                    @livewire('crud-patient')
                </div>

            </div>
        </div>
    </div>
</div>