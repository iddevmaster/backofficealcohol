<x-app-layout>
<h1 class="text-xl font-semibold mb-4">แก้ไขสาขา</h1>
<form action="{{ route('users.update', $user) }}" method="post" class="bg-white p-6 rounded-lg border max-w-3xl mx-auto">
  @csrf @method('PUT')
  @include('users._form', ['user' => $user])
  <div class="mt-6 flex gap-2">
    <button class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">อัปเดต</button>
    <a href="{{ route('users.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
  </div>
</form>
</x-app-layout>
