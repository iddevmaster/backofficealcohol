<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">แก้ไข Permission #{{ $permission->id }}</h1>
<form method="post" action="{{ route('permissions.update',$permission) }}" class="bg-white rounded-xl shadow space-y-4" style="padding: 10px;">
  @csrf @method('PUT')
  @include('permissions._form', ['permission'=>$permission,'guards'=>['web','api']])
  <div class="flex gap-2">
    <button class="rounded bg-slate-800 text-white px-4 py-2">บันทึก</button>
    <a href="{{ route('permissions.index') }}" class="rounded bg-gray-200 px-4 py-2">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
