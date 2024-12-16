<div class="form-group">
    <label for="{{$input_name}}">{{ $label }}@if($required) <span class="tx-danger">*</span> @endif</label>
    <textarea
    class="form-control @if($is_editor) summernote @endif @error($error_name) is-invalid @enderror"
    id="{{$input_name}}"
    name="{{$input_name}}"
    style="height:200px;"
    placeholder="{{ $label }}">{{ $value }}</textarea>
    @error($error_name)
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror
</div>
@if($is_editor)
@push('scripts')
    <!-- INTERNAL Summernote Editor js -->
    <script src="{{ asset('assets/plugins/summernote-editor/summernote1.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.js') }}"></script>
    <script>
        
        $('.summernote').summernote({
            
            tabsize: 3,
            height: 300,
        });
        </script>
@endpush
@push('css')
    <!-- Internal Summernote css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote-editor/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote-editor/summernote1.css') }}">
@endpush
@endif