<button {{$attributes}} onclick="showLoadingModal()" type="submit" class="btn btn-primary">
    {{ isset($title) ? $title : __('Submit') }}
</button>
@push('scripts')
<script>
    function showLoadingModal()
    {
        $('#loadingModal').modal('show')
    }
</script>
@endpush
