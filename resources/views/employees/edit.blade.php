<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">แก้ไขพนักงาน #{{ $employee->id }}</h1>
<form method="post" action="{{ route('employees.update',$employee) }}" enctype="multipart/form-data"
      class="bg-white rounded-xl shadow p-4 space-y-4">
  @csrf @method('PUT')
  @include('employees._form', ['employee'=>$employee])
  <div class="flex gap-2">
    <button class="rounded bg-blue-600 text-white px-4 py-2">บันทึก</button>
    <a href="{{ route('employees.show',$employee) }}" class="rounded bg-gray-200 px-4 py-2">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
