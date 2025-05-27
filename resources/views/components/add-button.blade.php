<div class="d-flex justify-content-start mb-3">
    @permission('create_' . $name)
    <a href="{{ route($model . '.create') }}" class="btn btn-primary">Add {{ ucfirst($displayName) }}</a>
    @endpermission
</div>
