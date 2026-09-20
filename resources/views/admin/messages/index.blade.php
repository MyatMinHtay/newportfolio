@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Messages'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Contact Messages"
        subtitle="Inquiries and messages sent via the public website contact form."
    >
        <x-slot:actions>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    All Messages
                </a>
                <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="btn btn-sm {{ request('status') === 'unread' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Unread
                    @if($unreadCount > 0)
                        <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
                    @endif
                </a>
            </div>
        </x-slot:actions>
    </x-layout.page-header>

    <x-card class="shadow-sm overflow-hidden">
        @if ($messages->isEmpty())
            <x-empty-state
                icon="bi-envelope-paper"
                title="No messages found"
                description="When visitors submit the contact form, their inquiries will appear here."
            />
        @else
            {{-- Mobile List View (< 768px) --}}
            <div class="d-md-none">
                @foreach ($messages as $msg)
                    <div class="pf-mobile-card-item {{ !$msg->is_read ? 'bg-primary bg-opacity-10 border-start border-primary border-3' : '' }}">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                @if(!$msg->is_read)
                                    <i class="bi bi-circle-fill text-primary" style="font-size: 0.55rem;" title="Unread"></i>
                                @endif
                                <span class="fw-semibold text-truncate {{ !$msg->is_read ? 'text-primary' : 'text-body' }}">{{ $msg->name }}</span>
                            </div>
                            <span class="small text-muted flex-shrink-0" style="font-size: 0.75rem;">
                                {{ $msg->created_at->diffForHumans(null, true) }}
                            </span>
                        </div>

                        <div class="small text-muted text-truncate font-monospace mb-1" style="font-size: 0.8rem;">
                            {{ $msg->email }}
                        </div>

                        <div class="fw-medium text-truncate mb-1" style="font-size: 0.9rem;">
                            {{ $msg->subject ?: '(No Subject)' }}
                        </div>

                        <p class="small text-muted text-truncate mb-3" style="font-size: 0.85rem;">
                            {{ $msg->message }}
                        </p>

                        <div class="d-flex align-items-center justify-content-between pt-1">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-primary py-1 px-3">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                            <div class="d-flex align-items-center gap-2">
                                <form action="{{ route('admin.messages.toggle-read', $msg) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary py-1" title="{{ $msg->is_read ? 'Mark unread' : 'Mark read' }}">
                                        <i class="bi {{ $msg->is_read ? 'bi-envelope' : 'bi-envelope-check' }}"></i>
                                        <span class="small ms-1">{{ $msg->is_read ? 'Unread' : 'Read' }}</span>
                                    </button>
                                </form>

                                <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Desktop Table View (>= 768px) --}}
            <div class="d-none d-md-block">
                <x-table>
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 36px;"></th>
                            <th scope="col">Sender</th>
                            <th scope="col">Subject &amp; Snippet</th>
                            <th scope="col" style="width: 140px;">Received</th>
                            <th scope="col" class="text-end" style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $msg)
                            <tr class="{{ !$msg->is_read ? 'table-active fw-semibold' : '' }}">
                                <td class="text-center">
                                    @if(!$msg->is_read)
                                        <i class="bi bi-circle-fill text-primary" style="font-size: 0.65rem;" title="Unread"></i>
                                    @else
                                        <i class="bi bi-envelope-open text-muted" title="Read"></i>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $msg->name }}</div>
                                    <div class="small text-muted font-monospace">{{ $msg->email }}</div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 380px;">
                                        {{ $msg->subject ?: '(No Subject)' }}
                                    </div>
                                    <div class="small text-muted text-truncate" style="max-width: 460px; font-weight: normal;">
                                        {{ $msg->message }}
                                    </div>
                                </td>
                                <td class="small text-muted">
                                    {{ $msg->created_at->diffForHumans() }}
                                </td>
                                <td class="text-end">
                                    <x-button variant="outline-primary" size="sm" :href="route('admin.messages.show', $msg)">
                                        View
                                    </x-button>

                                    <form action="{{ route('admin.messages.toggle-read', $msg) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $msg->is_read ? 'Mark unread' : 'Mark read' }}">
                                            <i class="bi {{ $msg->is_read ? 'bi-envelope' : 'bi-envelope-check' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>

            <div class="p-3 border-top">
                <x-pagination :paginator="$messages" />
            </div>
        @endif
    </x-card>
@endsection
