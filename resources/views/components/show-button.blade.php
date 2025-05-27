@permission('show_' . $name)
    <a href="{{ route($route, $param) }}" class="btn btn-info btn-sm" title="Show {{ ucfirst($name) }}">
        <i class="fas fa-eye"></i> <span>Show</span>
    </a>
@endpermission
