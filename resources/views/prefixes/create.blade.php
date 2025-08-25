<x-app-layout>
<h1 class="text-xl font-semibold mb-4">เพิ่มแผนก</h1>
<form action="{{ route('prefixes.store') }}" method="post" class="bg-white p-6 rounded-lg border max-w-lg mx-auto">
  @include('prefixes._form', ['prefix' => new \App\Models\Prefix()])
  <div class="mt-6 flex gap-2">
    <button class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">บันทึก</button>
    <a href="{{ route('prefixes.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
