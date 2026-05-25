@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Contact Messages</h1>
        <p class="text-muted mb-0">Pesan dari form kontak publik.</p>
    </div>
    <form method="GET" class="d-flex gap-2 align-self-lg-center">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            @foreach(['unread', 'read', 'replied'] as $status)
                <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i>Filter</button>
    </form>
</div>

<div class="card card-clean overflow-hidden">
    <div class="card-header bg-white">
        <strong>Inbox</strong>
        <div class="small text-muted">Baca, tandai, dan tindak lanjuti pesan dari pengunjung.</div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td>
                            <strong>{{ $message->name }}</strong>
                            <div class="small text-muted">{{ $message->email }}</div>
                        </td>
                        <td>{{ $message->subject }}</td>
                        <td><span class="badge text-bg-{{ $message->status === 'unread' ? 'danger' : ($message->status === 'replied' ? 'success' : 'secondary') }}">{{ $message->status }}</span></td>
                        <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
                                <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" onsubmit="return confirm('Hapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger rounded-start-0" type="submit" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">Belum ada pesan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
        <div class="card-body border-top">{{ $messages->links() }}</div>
    @endif
</div>
@endsection
