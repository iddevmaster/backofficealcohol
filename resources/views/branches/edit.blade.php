<x-app-layout>
<h1 class="text-xl font-semibold mb-4">แก้ไข</h1>
<form action="{{ route('branches.update', $branch) }}" method="post" class="bg-white p-6 rounded-lg border max-w-3xl mx-auto">
  @csrf @method('PUT')
  @include('branches._form', ['branch'=>$branch, 'values'=>$values])
  <div class="mt-6">
    <button class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">อัปเดต</button>
    <a href="{{ route('branches.index') }}" class="ml-2 rounded-md border px-4 py-2 hover:bg-gray-50">ย้อนกลับ</a>
  </div>
</form>
</x-app-layout>
