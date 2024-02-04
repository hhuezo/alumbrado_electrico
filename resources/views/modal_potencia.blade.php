<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    aria-hidden="true" role="dialog" tabindex="-1" id="modal-potencia">

    <div class="modal-dialog modal-xl relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding
                          rounded-md outline-none text-current">
            @if ($data_potencia_instalada_rango)
                @for ($i = 1; $i <= count($data_potencia_instalada_rango); $i++)
                    <div id="container_potencia_instalada_rango{{ $i }}"></div>
                @endfor
            @endif
        </div>
    </div>

</div>
