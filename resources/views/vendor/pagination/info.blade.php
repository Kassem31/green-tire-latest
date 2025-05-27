@if ($paginator->total() > 0)
    <div class="pagination-info text-center text-md-start mb-3">
        <p class="text-muted">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        </p>
    </div>
@endif
