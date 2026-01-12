@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card mb-4">
        <div class="card-header">สร้างลิงก์สั้น</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('dashboard.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="original_url" class="form-label">ลิงก์ต้นทาง (Original URL)</label>
                    <input type="url" class="form-control" id="original_url" name="original_url" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">ชื่อ/คำอธิบาย (ถ้ามี)</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <button type="submit" class="btn btn-primary">สร้างลิงก์สั้น</button>
            </form>
        </div>
    </div>
</div>
@endsection
