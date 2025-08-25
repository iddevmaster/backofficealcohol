@props([
  'provinces' => collect(),
  'values' => ['province_id'=>null,'amphur_id'=>null,'tambon_id'=>null],
  'names'  => ['province'=>'province_id','amphur'=>'amphur_id','tambon'=>'tambon_id'],
])

<div
  x-data="locationForm({
    provinces: @js($provinces), // [{id,name}, ...]
    preset: {
      province_id: @js(old($names['province'], $values['province_id'] ?? '')),
      amphur_id:   @js(old($names['amphur'],   $values['amphur_id']   ?? '')),
      tambon_id:   @js(old($names['tambon'],   $values['tambon_id']   ?? '')),
    }
  })"
  x-init="initPrefill()"
>
   <div>
    <label class="block text-sm font-medium mb-1">จังหวัด </label>
    <select x-model="province_id" @change="onProvinceChange"
            name="{{ $names['province'] }}"
            class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
      <option value="">-- เลือกจังหวัด --</option>
      @foreach($provinces as $p)
    <option value="{{ $p->id }}"
      @selected(old('province_id', $values['province_id'] ?? null) == $p->id)>
      {{ $p->name }}
    </option>
  @endforeach
    </select>
    @error($names['province']) <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">อำเภอ</label>
  <select x-model.number="amphur_id" @change="onAmphurChange" name="{{ $names['amphur'] }}" :disabled="!province_id"  class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <option value="">-- เลือกอำเภอ --</option>
    <template x-for="a in amphurs" :key="a.id">
      <option :value="Number(a.id)" x-text="a.name"></option>
    </template>
  </select>
    @error($names['amphur']) <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">ตำบล</label>
  <select x-model.number="tambon_id" name="{{ $names['tambon'] }}" :disabled="!amphur_id"  class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <option value="">-- เลือกตำบล --</option>
    <template x-for="t in tambons" :key="t.id">
      <option :value="Number(t.id)" x-text="t.name"></option>
    </template>
  </select>
    @error($names['tambon']) <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
</div>

@push('scripts')
<script>
function locationForm({provinces, preset}) {
  return {
    provinces, amphurs: [], tambons: [],
    province_id: null, amphur_id: null, tambon_id: null,


    async initPrefill() {
      
      this.province_id = preset.province_id ? Number(preset.province_id) : null;
      const presetAmphur = preset.amphur_id ? Number(preset.amphur_id) : null;
      const presetTambon = preset.tambon_id ? Number(preset.tambon_id) : null;
        
      // 3) ถ้ามี province → โหลดอำเภอ
      if (this.province_id) {
        await this.fetchAmphurs(this.province_id);
      this.amphur_id = presetAmphur;
       await this.$nextTick();
     
      }

      // 4) ถ้ามี amphur → โหลดตำบล
      if (this.amphur_id) {
        await this.fetchTambons(this.amphur_id);
  this.tambon_id = presetTambon;
          await this.$nextTick();
  
      }
    
    },

    async onProvinceChange() {
      this.amphur_id = null;
      this.tambon_id = null;
      this.tambons = [];
      if (this.province_id) {
        await this.fetchAmphurs(this.province_id);
      } else {
        this.amphurs = [];
      }
    },

    async onAmphurChange() {
      this.tambon_id = null;
      if (this.amphur_id) {
        await this.fetchTambons(this.amphur_id);
      } else {
        this.tambons = [];
      }
    },

    async fetchAmphurs(pid) {
      const res = await fetch(`/locations/amphurs/${pid}`, {headers:{'X-Requested-With':'XMLHttpRequest'}});
      this.amphurs = await res.json();
    },

    async fafasff(xx) {
     console.log(xx)
      this.amphur_id = xx
    },


    async fetchTambons(aid) {
      const res = await fetch(`/locations/tambons/${aid}`, {headers:{'X-Requested-With':'XMLHttpRequest'}});
      this.tambons = await res.json();
    },
  }
}
</script>
@endpush