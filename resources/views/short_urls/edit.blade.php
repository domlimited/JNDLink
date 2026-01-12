@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">แก้ไขลิงก์สั้น</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('short_urls.update', $shortUrl) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="original_url" class="form-label">ลิงก์ต้นทาง (URL)</label>
                            <input type="url" class="form-control" id="original_url" name="original_url" value="{{ old('original_url', $shortUrl->original_url) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">ชื่อ/คำอธิบาย</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $shortUrl->title) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                        <a href="{{ route('short_urls.index') }}" class="btn btn-secondary">ยกเลิก</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
