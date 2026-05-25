@extends('layouts.admin')

@section('title', 'Message Detail')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">{{ $message->subject }}</h1>
        <p class="text-muted mb-0">{{ $message->name }} - {{ $message->email }}</p>
    </div>
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary align-self-md-center"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-clean">
            <div class="card-header bg-white">
                <strong>Message</strong>
                <div class="small text-muted">{{ $message->created_at->format('d M Y H:i') }}</div>
            </div>
            <div class="card-body fs-5">{!! nl2br(e($message->message)) !!}</div>
        </div>
    </div>
    <div class="col-lg-4">
        <form method="POST" action="{{ route('admin.contact-messages.status', $message) }}" class="card card-clean">
            @csrf
            @method('PATCH')
            <div class="card-header bg-white"><strong>Status</strong></div>
            <div class="card-body">
                <label for="status" class="form-label">Message Status</label>
                <select id="status" name="status" class="form-select">
                    @foreach(['unread', 'read', 'replied'] as $status)
                        <option value="{{ $status }}" @selected($message->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-footer bg-white">
                <button class="btn btn-primary" type="submit"><i class="bi bi-check2 me-1"></i>Update Status</button>
            </div>
        </form>
    </div>
</div>
@endsection
