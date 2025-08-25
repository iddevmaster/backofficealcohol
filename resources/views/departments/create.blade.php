<x-app-layout>
<h1 class="text-xl font-semibold mb-4">เพิ่มแผนก</h1>
<form action="{{ route('departments.store') }}" method="post" class="max-w-xl bg-white p-6 rounded-lg border">
  @include('departments._form')
</form>
</x-app-layout>
