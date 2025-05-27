@permission('edit_' . $name)
    <a href="{{ route($route, $param) }}" class="btn btn-warning btn-sm" title="Edit {{ ucfirst($name) }}">
        <i class="fas fa-edit"></i> <span>Edit</span>
    </a>
@endpermission
