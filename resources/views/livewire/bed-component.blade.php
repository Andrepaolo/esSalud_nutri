<div>
    <h2 class="text-lg font-bold">Camas en esta Área</h2>
    
    <table class="table-auto w-full border-collapse border border-gray-300 mt-2">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Código</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($beds as $bed)
                <tr>
                    <td class="border px-4 py-2">{{ $bed->id }}</td>
                    <td class="border px-4 py-2">{{ $bed->codigo }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="border px-4 py-2 text-center">No hay camas disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
