<x-app-layout>
<h1 class="text-xl font-semibold mb-4">แก้ไขสาขา</h1>
<form action="{{ route('organizations.update', $organization) }}" method="post" class="bg-white p-6 rounded-lg border max-w-3xl mx-auto">
  @csrf @method('PUT')
  @include('organizations._form', ['organization' => $organization])
  <div class="mt-6 flex gap-2">
    <button class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">อัปเดต</button>
    <a href="{{ route('organizations.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
  </div>
</form>
</x-app-layout>
