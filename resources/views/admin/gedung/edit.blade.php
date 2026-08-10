@extends('layouts.admin')

@section('title', 'Edit Gedung')

@section('content')
<h1 class="h5 fw-bold mb-3" style="font-family:'Plus Jakarta Sans',sans-serif;">Edit Gedung</h1>

<div class="card rounded-4 border-0 shadow-sm p-4">
    <form action="{{ route('admin.gedung.update', $gedung) }}" method="POST" enctype="multipart/form-data">
        @include('admin.gedung._form', ['mode' => 'edit', 'gedung' => $gedung])
    </form>
</div>
@endsection
