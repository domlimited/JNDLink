@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">ลิงก์สั้นทั้งหมด</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ลิงก์สั้น</th>
                        <th>ลิงก์ต้นทาง</th>
                        <th>ชื่อ/คำอธิบาย</th>
                        <th>จำนวนเข้าชม</th>
                        <th>สร้างเมื่อ</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($shortUrls as $url)
                    <tr>
                        <td><a href="{{ url('/s/'.$url->code) }}" target="_blank">{{ url('/s/'.$url->code) }}</a></td>
                        <td>{{ $url->original_url }}</td>
                        <td>{{ $url->title }}</td>
                        <td>{{ $url->visits }}</td>
                        <td>{{ $url->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('short_urls.edit', $url) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                            <form action="{{ route('short_urls.destroy', $url) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบลิงก์นี้?')">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">ยังไม่มีลิงก์สั้นในระบบ</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection