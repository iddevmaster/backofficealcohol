<x-app-layout>
<h1 class="text-xl font-semibold mb-4">แก้ไขสาขา</h1>
<form action="{{ route('prefixes.update', $prefix) }}" method="post" class="bg-white p-6 rounded-lg border max-w-lg mx-auto">
  @csrf @method('PUT')
  @include('prefixes._form', ['prefix' => $prefix])
  <div class="mt-6 flex gap-2">
    <button class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">อัปเดต</button>
    <a href="{{ route('prefixes.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
  </div>
</form>
</x-app-layout>
