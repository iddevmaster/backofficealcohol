<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">ข้อมูลพนักงาน #{{ $employee->id }}</h1>
<div class="bg-white rounded-xl shadow p-4 space-y-3">
  <div class="flex items-center gap-4">
    @if($employee->image_url)
      <img src="{{ $employee->image_url }}" class="h-16 w-16 rounded object-cover" alt="">
    @endif
    <div>
      <div class="text-lg font-semibold">{{ $employee->full_name }}</div>
      <div class="text-slate-600">{{ $employee->emp_id }}</div>
    </div>
  </div>
  <div><b>โทร:</b> {{ $employee->phone ?? '-' }}</div>
  <div><b>องค์กร:</b> {{ $employee->organization->name ?? '-' }}</div>
  <div><b>สาขา:</b> {{ $employee->branch->name ?? '-' }}</div>
  <div><b>แผนก:</b> {{ $employee->department->name ?? '-' }}</div>
  <div><b>ลายนิ้วมือ:</b> {{ $employee->fingerprint_registered ? 'ลงทะเบียนแล้ว' : 'ยังไม่ลงทะเบียน' }}</div>
  <div><b>สถานะ:</b> {{ $employee->status ? 'Active' : 'Inactive' }}</div>

  <div class="pt-3">
    <a href="{{ route('employees.edit',$employee) }}" class="rounded bg-amber-500 text-white px-4 py-2">แก้ไข</a>
    <a href="{{ route('employees.index') }}" class="rounded bg-gray-200 px-4 py-2">กลับ</a>
  </div>
</div>
</x-app-layout>
