
@php
  $editing = isset($user);
  // ใช้ตัวแปร $roles, $orgs ที่ถูกส่งมาจาก controller ในหน้า create/edit
@endphp

@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  <div>
    <label class="block text-sm font-medium mb-1">device_sn</label>
    <input type="text" name="device_sn"
           value="{{ old('device_sn', $user->device_sn ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('device_sn') border-red-500 @enderror" required>
    @error('device_sn') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>


      <div>
    <label class="block text-sm font-medium mb-1">alcohol_level</label>
    <input type="text" name="alcohol_level"
           value="{{ old('alcohol_level', $user->alcohol_level ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('alcohol_level') border-red-500 @enderror" required>
    @error('alcohol_level') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>


  <div>
    <label class="block text-sm font-medium mb-1">testing_image</label>
    <input type="text" name="testing_image"
           value="{{ old('testing_image', $user->testing_image ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('testing_image') border-red-500 @enderror" required>
    @error('testing_image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- <div>
    <label class="block text-sm font-medium mb-1">testing_date</label>
    <input type="text" name="last_name"
           value="{{ old('testing_date', $user->testing_date ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('testing_date') border-red-500 @enderror" required>
    @error('testing_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div> -->

      

</div>

<div x-data="userOrgBrnDpm()" @backup-close.window="show = true">
  <!-- 1) ORG -->
  <label class="block text-sm font-medium mb-1">องค์กร (org) *</label>
  <select name="org_id" x-model="org" @change="onEmpChange()" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('org_id') border-red-500 @enderror" required>
    <option value="">-- เลือกองค์กร --</option>
    @foreach(($orgs ?? []) as $o)
      <option value="{{ $o->id }}">{{ $o->name }} ({{ $o->id }})</option>
    @endforeach
  </select>
  @error('org_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror

 
    <!-- 2) BRANCH (disable จนกว่าเลือก org) -->
    <div>
      <label class="block text-sm font-medium mb-1">พนักงาน</label>
      <select name="tester_id" x-model="emp"
              class="w-full rounded border-gray-300" :disabled="!org">
        <option value="">-- เลือกพนักงาน --</option>
        <template x-for="b in empList" :key="b.id">
          <option :value="b.id" x-text="`${b.first_name} ${b.last_name} (${b.id})`"></option>
        </template>
      </select>
      @error('tester_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <!-- 3) DEPARTMENT (disable จนกว่าเลือก branch) -->
    



  

  <!-- Alpine helper -->
  <script>
  function userOrgBrnDpm() {
    return {
      
      org: @json(old('org_id', $user->org_id ?? '')),
      emp: @json(old('emp_id', $user->emp_id ?? '')),
      empList:[],
      async init() {
        
    
      const org = this.org ? Number(this.org) : null;
      const emp = this.emp ? Number(this.emp) : null;
  
   
        if (this.org) {
        
          await this.loadEmployyee(true);
           this.emp = emp;
          await this.$nextTick();
          
        }
      },
  

       async onEmpChange() {
        this.emp = '';
     
        await this.loadEmployyee(false);
      },

    

            async loadEmployyee(preserve=false) {
        this.employee = [];
      
        if (!this.org) return;
        const res = await fetch(`{{ route('api.org.employee', '_ORG_') }}`.replace('_ORG_', this.org));
        console.log(res)
        this.empList = await res.json();
        // this.brn_x = this.brn
      
       
        if (!preserve) this.brn = '';
      
        if (this.emp && !this.empList.find(x=>x.id===this.emp)) this.emp = '';
        
      
    
      },


     
    }
  }
  </script>
</div>