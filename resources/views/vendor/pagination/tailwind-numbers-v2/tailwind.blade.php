<div class="flex items-center justify-between border-t border-gray-200 bg-white px-0 py-2 sm:px-0"> {{--  ¡padding horizontal px-0 y py-2! --}}
    <div class="flex flex-1 justify-between sm:hidden">
        @if ($paginator->onFirstPage())
            <span  class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-1 text-sm font-medium text-gray-500 cursor-default"> {{-- px-2 py-1 --}}
                Anterior
            </span>
        @else
            <button wire:click="previousPage('{{ $paginator->getPageName() }}')" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50"> {{-- px-2 py-1 --}}
                Anterior
            </button>
        @endif
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage('{{ $paginator->getPageName() }}')" class="relative ml-1 inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50">Siguiente</button> {{-- px-2 py-1 y ml-1 --}}
        @else
            <span class="relative ml-1 inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-1 text-sm font-medium text-gray-500 cursor-default">  {{-- px-2 py-1 y ml-1 --}}
                Siguiente
            </span>
        @endif
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700">
                Mostrando
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                a
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                de
                <span class="font-medium">{{ $paginator->total() }}</span>
                resultados
            </p>
        </div>
        <div>
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                @if (!$paginator->onFirstPage())
                    <button wire:click="previousPage('{{ $paginator->getPageName() }}')" class="relative inline-flex items-center rounded-l-md px-2 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"> {{-- px-2 py-1 --}}
                        <span class="sr-only">Previous</span>
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"> {{-- size-4 --}}
                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true" class="relative inline-flex items-center px-2 py-1 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0"> {{-- px-2 py-1 --}}
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="relative z-10 inline-flex items-center bg-indigo-600 px-2 py-1 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"> {{-- px-2 py-1 --}}
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }},'{{ $paginator->getPageName() }}')" class="relative inline-flex items-center px-2 py-1 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"> {{-- px-2 py-1 --}}
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage('{{ $paginator->getPageName() }}')"  class="relative inline-flex items-center rounded-r-md px-2 py-1 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"> {{-- px-2 py-1 --}}
                        <span class="sr-only">Next</span>
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"> {{-- size-4 --}}
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
            </nav>
        </div>
    </div>
</div>