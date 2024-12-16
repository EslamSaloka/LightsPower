
@push('css')
    <!-- Internal Fileuploads css-->
    <link href="{{ asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('scripts')
    <!-- Internal Fileuploads js-->
    <script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script>
        $(`.dropify-{{ $name }}`).dropify({
            messages: {
                'default': "{{ __('Drag and drop a file here or click') }}",
                'replace': "{{ __('Drag and drop or click to replace') }}",
                'remove': "{{ __('Remove') }}",
                'error': "{{ __('Ooops, something wrong appended.') }}"
            },
            error: {
                'fileSize': "{{ __('The file size is too big (2M max).') }}",
            },
            tpl: {
                clearButton: '<button type="button" onclick="deleteImg({{ $name }})" class="dropify-clear">{{ __('Remove') }}</button>',
            }
        });

        function deleteImg(inputName)
        {
            let id = $(inputName).attr('name');
            $(`#${id}_deleted`).val(1);
        }
        $('#{{$name}}').on('focusout', function(){
            let img = $('.dropify-render img:first').attr('src')
            $('#img_base64').val(img);
        });
    </script>
    @if($value)
        <script>
            $('.dropify-render').html(`
                <img style="max-height: 200px" src="{{ $value }}">
            `);
        </script>
    @endif
@endpush
<div class="form-group">
    <label for="{{$name}}">@lang($label) @if(isset($required)) <span class="tx-danger">*</span>@endif</label>
    <input name="{{$name}}" id="{{$name}}" type="file" class="dropify-{{$name}}"
    @if($value) data-default-file="{{ $value }}" @endif 
    data-height="200" />
    <input type="hidden" id="{{$name}}_deleted" name="{{$name}}_deleted" value="0">
    @error($name)
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
    <span id="error_{{$name}}" class="text-danger"></span>
    <input type="hidden" name="img_base64" id="img_base64" 
    @if( $value && str_contains($value,'base64'))
        value="{{$value}}" 
    @endif>
</div>