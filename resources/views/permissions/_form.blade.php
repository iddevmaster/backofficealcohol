@csrf
@php $editing = isset($permission); @endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm mb-1">Name *</label>
    <input name="name" class="w-full rounded border-gray-300" required value="{{ old('name',$permission->name ?? '') }}">
  </div>
  <div>
    <label class="block text-sm mb-1">Guard *</label>
    <select name="guard_name" class="w-full rounded border-gray-300" required>
      @foreach(($guards ?? ['web','api']) as $g)
        <option value="{{ $g }}" @selected(old('guard_name',$permission->guard_name ?? 'web')===$g)>{{ $g }}</option>
      @endforeach
    </select>
  </div>
</div>



