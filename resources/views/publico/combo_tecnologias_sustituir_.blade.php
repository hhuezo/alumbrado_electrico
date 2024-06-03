<option value="" selected disabled>Seleccione...</option>
@foreach ($tecnologiasRemplazar as $obj)
    <option value="{{ $obj->consumo_promedio }}">
        {{ $obj->tipo_luminaria->nombre }} {{ $obj->potencia }} Vatios
    </option>
@endforeach
