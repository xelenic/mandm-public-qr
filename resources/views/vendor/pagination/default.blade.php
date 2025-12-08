@if ($paginator->hasPages())
    <nav style="display: flex; justify-content: space-between; align-items: center;">
        <div style="color: #6b7280; font-size: 14px;">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        
        <ul style="display: flex; list-style: none; gap: 5px; margin: 0; padding: 0;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="padding: 8px 12px; background: #f3f4f6; color: #9ca3af; border-radius: 6px; display: inline-block; font-size: 14px;">
                        Previous
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="padding: 8px 12px; background: white; color: #374151; border: 1px solid #e5e7eb; border-radius: 6px; display: inline-block; font-size: 14px; text-decoration: none; transition: all 0.2s;">
                        Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span style="padding: 8px 12px; color: #9ca3af; display: inline-block; font-size: 14px;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="padding: 8px 12px; background: #2563eb; color: white; border-radius: 6px; display: inline-block; font-size: 14px; font-weight: 600;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="padding: 8px 12px; background: white; color: #374151; border: 1px solid #e5e7eb; border-radius: 6px; display: inline-block; font-size: 14px; text-decoration: none; transition: all 0.2s;">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="padding: 8px 12px; background: white; color: #374151; border: 1px solid #e5e7eb; border-radius: 6px; display: inline-block; font-size: 14px; text-decoration: none; transition: all 0.2s;">
                        Next
                    </a>
                </li>
            @else
                <li>
                    <span style="padding: 8px 12px; background: #f3f4f6; color: #9ca3af; border-radius: 6px; display: inline-block; font-size: 14px;">
                        Next
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        nav a[style*="background: white"]:hover {
            background: #f9fafb !important;
            border-color: #d1d5db !important;
        }
    </style>
@endif

