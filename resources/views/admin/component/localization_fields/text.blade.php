<div class="form-group">
    <label for="{{$input_name}}"> {{ $label }} @if($required) <span class="tx-danger">*</span> @endif </label>
    <input type="text"
    class="form-control @error($error_name) is-invalid @enderror"
    id="{{$input_name}}"
    name="{{$input_name}}"
    placeholder="{{ $label }}"
    value="{{ $value }}">
    @error($error_name)
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror
    <span class="error_{{$input_name}}"></span>
</div>