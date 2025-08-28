<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">สร้าง Role</h1>
<form method="post" action="{{ route('roles.store') }}" class="bg-white rounded-xl shadow p-4 space-y-4">
  @csrf
  @include('roles._form', ['permissions'=>$permissions,'guards'=>$guards])
  <div class="flex gap-2">
    <button class="rounded bg-blue-600 text-white px-4 py-2">บันทึก</button>
    <a href="{{ route('roles.index') }}" class="rounded bg-gray-200 px-4 py-2">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
