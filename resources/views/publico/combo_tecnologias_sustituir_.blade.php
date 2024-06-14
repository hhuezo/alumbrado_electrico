<option value="" selected disabled>Seleccione...</option>
@foreach ($potencias_finales as $obj)
    <option value="{{ $obj->id }}" data-consumo="{{ $obj->consumo_promedio }}">
        {{ $obj->tipo_luminaria->nombre }} {{ $obj->potencia }} Vatios
    </option>
@endforeach
