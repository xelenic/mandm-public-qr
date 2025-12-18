@if ($paginator->hasPages())
    <nav style="display: flex; justify-content: center; align-items: center; gap: 10px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 10px 20px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; display: inline-block; font-size: 14px; font-weight: 500;">
                ← Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 10px 20px; background: #2563eb; color: white; border-radius: 8px; display: inline-block; font-size: 14px; text-decoration: none; font-weight: 500; transition: all 0.2s;">
                ← Previous
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 10px 20px; background: #2563eb; color: white; border-radius: 8px; display: inline-block; font-size: 14px; text-decoration: none; font-weight: 500; transition: all 0.2s;">
                Next →
            </a>
        @else
            <span style="padding: 10px 20px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; display: inline-block; font-size: 14px; font-weight: 500;">
                Next →
            </span>
        @endif
    </nav>

    <style>
        nav a[style*="background: #2563eb"]:hover {
            background: #1d4ed8 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
    </style>
@endif








