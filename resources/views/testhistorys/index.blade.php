<x-app-layout>
  <div class="mx-auto px-4 sm:px-6 py-8 fade" x-data="alcoholApp()">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
      <div>
        <h1 class="text-black text-2xl font-extrabold tracking-tight">ผลการทดสอบแอลกอฮอล์</h1>
        <p style="color:#4a5568" class="text-sm mt-1">วันจันทร์ที่ 9 มีนาคม 2569</p>
      </div>
      <button class="px-5 py-1.5 rounded-lg border text-xs font-bold" style="border-color:#6c63ff;background:rgba(10, 10, 10, 0.15);color:#9b8fff">
        ＋ บันทึกผลใหม่
      </button>
    </div>


    <!-- ===== MAIN PANEL ===== -->
    <div class="card rounded-2xl overflow-hidden shadow-2xl" style="border:1px solid rgba(255,255,255,.07)">
      <!-- Toolbar -->

      <div class="flex gap-2 items-center">
        <input type="date" x-model="dateFrom"
          class="px-3 py-2 rounded-lg text-xs"
          style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);color:#c8d0e4">

        <span style="color:#4a5568;font-size:12px">ถึง</span>

        <input type="date" x-model="dateTo"
          class="px-3 py-2 rounded-lg text-xs"
          style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);color:#c8d0e4">

        <button @click="clearDateFilter"
          class="px-3 py-1.5 rounded-lg border text-xs font-bold"
          style="border-color:rgba(255,255,255,.1);color:#4a5568">
          ล้าง
        </button>
      </div>
      <div class="px-6 py-4 flex flex-col sm:flex-row gap-3" style="border-bottom:1px solid rgba(255,255,255,.06)">
        <!-- Search -->
        <div class="relative flex-1">
          <span class="absolute left-3 top-1/2 -translate-y-1/2" style="color:#4a5568">🔍</span>
          <input type="text" placeholder="ค้นหาพนักงาน, รหัส..." x-model="searchQ"
            class="w-full rounded-xl pl-9 pr-4 py-2 text-sm outline-none transition"
            style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);color:#c8d0e4">
        </div>

        <div class="flex gap-2">
          <button
            @click="statusFilter = 'all'"
            class="px-3 py-1.5 rounded-lg border text-xs font-bold"
            :style="statusFilter === 'all'
      ? 'border-color:#6c63ff;background:rgba(108,99,255,.15);color:#9b8fff'
      : 'border-color:rgba(255,255,255,.1);color:#4a5568'">
            ทั้งหมด
          </button>

          <button
            @click="statusFilter = 'pass'"
            class="px-3 py-1.5 rounded-lg border text-xs font-bold"
            :style="statusFilter === 'pass'
      ? 'border-color:#00e5a0;background:rgba(0,229,160,.12);color:#00e5a0'
      : 'border-color:rgba(255,255,255,.1);color:#4a5568'">
            ผ่าน
          </button>

          <button
            @click="statusFilter = 'fail'"
            class="px-3 py-1.5 rounded-lg border text-xs font-bold"
            :style="statusFilter === 'fail'
      ? 'border-color:#ff4d6d;background:rgba(255,77,109,.12);color:#ff4d6d'
      : 'border-color:rgba(255,255,255,.1);color:#4a5568'">
            ไม่ผ่าน
          </button>
        </div>




      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full" style="border-collapse:collapse">
          <thead>
            <tr style="background:rgba(255,255,255,.03)">
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em">#</th>
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em">พนักงาน</th>
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em">เครื่องเป่า SN</th>
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em;min-width:190px">ระดับแอลกอฮอล์</th>
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em">สถานะ</th>
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em">รูปภาพ</th>
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em">องค์กร</th>
              <th class="px-5 py-3.5 text-left text-xs font-bold uppercase" style="color:#4a5568;letter-spacing:.08em">วันที่ทดสอบ</th>
              <th class="px-5 py-3.5"></th>
            </tr>
          </thead>


          <tbody id="tbody">
            <template x-for="(test, index) in filteredUsers" :key="test.id">
              <tr class="tr"
                :style="selectedUser === test.id ? 'background: rgba(255,255,255,.05);' : ''"
                @click="selectUser(test)"
                style="cursor:pointer; border-bottom:1px solid rgba(255,255,255,.04)">

                <td class="px-5 py-4 font-mono text-xs" style="color:#4a5568" x-text="String(index + 1).padStart(2, '0')"></td>

                <td class="px-5 py-4">
                  <div class="flex items-center gap-3">
                    <div :style="`width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, #6c63ff99, #6c63ff); display:flex; align-items:center; justify-content:center; color:#fff; font-size:13px; font-weight:700; border:2px solid rgba(255,255,255,.1); flex-shrink:0`"
                      x-text="test.f_name ? test.f_name[0] : '?' ">
                    </div>
                    <div>
                      <p style="color:#e2e8f0; font-weight:600; font-size:14px"
                        x-text="test ? test.f_name + ' ' + test.l_name : 'ไม่ทราบชื่อ'"></p>
                      <p style="color:#4a5568; font-size:12px; margin-top:2px"
                        x-text="test ? test.user_code : '-'"> </p>
                    </div>
                  </div>
                </td>

                <td class="px-5 py-4">
                  <span style="font-family:'JetBrains Mono',monospace; font-size:12px; color:#7c88aa; background:rgba(255,255,255,.05); padding:3px 8px; border-radius:6px"
                    x-text="test.device_sn"></span>
                </td>

                <td class="px-5 py-4" style="min-width:190px">
                  <div class="flex items-center gap-2">
                    <div style="flex:1; height:6px; background:rgba(255,255,255,.08); border-radius:99px; overflow:hidden">
                      <div :style="`width: ${getPercent(test.alcohol_level)}%; height:100%; background: ${getStatus(test.alcohol_level).color}; border-radius:99px; transition:width .6s` "></div>
                    </div>
                    <span style="font-family:'JetBrains Mono',monospace; font-size:12px; min-width:38px; text-align:right"
                      :style="`color: ${getStatus(test.alcohol_level).color}`"
                      x-text="Number(test.alcohol_level).toFixed(2)"></span>
                  </div>
                </td>

                <td class="px-5 py-4">
                  <span :class="getStatus(test.alcohol_level).cls"
                    style="display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:99px; font-size:12px; font-weight:700">
                    <span :style="`width:6px; height:6px; border-radius:50%; background: ${getStatus(test.alcohol_level).color}; display:inline-block`"></span>
                    <span x-text="getStatus(test.alcohol_level).label"></span>
                  </span>
                </td>

                <td class="px-5 py-4">
                  <div style="width:40px; height:40px; border-radius:10px; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07); display:flex; align-items:center; justify-content:center; font-size:18px; color:#4a5568">
                    <template x-if="test.testing_image">
                      <img :src="test.testing_image" style="width:100%; height:100%; border-radius:10px; object-fit:cover">
                    </template>
                    <template x-if="!test.testing_image">
                      <span>📷</span>
                    </template>
                  </div>
                </td>
                <td class="px-5 py-4">
                  <span style="font-family:'JetBrains Mono',monospace; font-size:12px; color:#7c88aa; background:rgba(255,255,255,.05); padding:3px 8px; border-radius:6px"
                    x-text="test.org_name"></span>
                </td>
                <td class="px-5 py-4" style="color:#4a5568; font-size:12px; white-space:nowrap" x-text="test.created_at"></td>

                <td class="px-5 py-4">
                  <div class="flex gap-2">

                    <button class="btn-action">แก้ไข</button>
                    <button class="btn-action">ลบ</button>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>

        </table>
      </div>

      <!-- Footer -->
      <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-3" style="border-top:1px solid rgba(255,255,255,.05)">
        <p style="color:#4a5568;font-size:13px">แสดง 1–6 จาก 6 รายการ</p>
        <div class="flex gap-1">
          <button style="width:32px;height:32px;border-radius:8px;border:1px solid rgba(255,255,255,.08);background:rgba(108,99,255,.15);color:#9b8fff;font-weight:700;font-size:13px;cursor:pointer">1</button>
          <button style="width:32px;height:32px;border-radius:8px;border:1px solid rgba(255,255,255,.08);background:transparent;color:#4a5568;font-size:13px;cursor:pointer">2</button>
          <button style="width:32px;height:32px;border-radius:8px;border:1px solid rgba(255,255,255,.08);background:transparent;color:#4a5568;font-size:13px;cursor:pointer">3</button>
        </div>
      </div>

    </div><!-- end panel -->

    <!-- ===== DETAIL PANEL (show below for preview) ===== -->
    <!-- <div class="mt-10">
    <h2 class="text-black font-extrabold text-xl mb-6 tracking-tight">📋 รายละเอียดผลเทส — ตัวอย่าง</h2>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    
      <div class="flex flex-col gap-5">
      
        <div class="card rounded-2xl p-6 shadow-xl" style="border:1px solid rgba(255,255,255,.07)">
          <p style="color:#4a5568;font-size:11px;letter-spacing:.08em" class="uppercase font-bold mb-4">ข้อมูลพนักงาน</p>
          <div class="flex items-center gap-4 mb-5">
            <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#f7258599,#f72585);display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;font-weight:700;border:2px solid rgba(255,255,255,.1)">วม</div>
            <div>
              <p style="color:#fff;font-weight:700;font-size:17px">นายวิชัย มั่นคง</p>
              <p style="color:#4a5568;font-size:13px;margin-top:3px">EMP003</p>
            </div>
          </div>
          <div class="flex justify-between py-3" style="border-bottom:1px solid rgba(255,255,255,.05)">
            <span style="color:#4a5568;font-size:13px">📞 เบอร์โทร</span>
            <span style="color:#c8d0e4;font-size:13px;font-family:'JetBrains Mono',monospace">092-111-2233</span>
          </div>
        </div>
     
        <div class="card rounded-2xl p-6 shadow-xl text-center" style="border:1px solid rgba(255,77,109,.3)">
          <p style="color:#4a5568;font-size:11px;letter-spacing:.08em" class="uppercase font-bold mb-4">ผลการทดสอบ</p>
          <p style="color:#ff4d6d;font-size:52px;font-weight:900;font-family:'JetBrains Mono',monospace;line-height:1;margin-bottom:4px">0.52</p>
          <p style="color:#4a5568;font-size:13px;margin-bottom:14px">mg/L (มิลลิกรัมต่อลิตร)</p>
          <div style="width:100%;height:8px;background:rgba(255,255,255,.08);border-radius:99px;overflow:hidden;margin-bottom:14px">
            <div style="width:52%;height:100%;background:#ff4d6d;border-radius:99px"></div>
          </div>
          <span class="badge-fail" style="display:inline-flex;align-items:center;gap:8px;padding:6px 18px;border-radius:99px;font-size:14px;font-weight:700">
            <span style="width:8px;height:8px;border-radius:50%;background:#ff4d6d;display:inline-block"></span>
            ไม่ผ่าน
          </span>
        </div>
      </div>

   
      <div class="lg:col-span-2 flex flex-col gap-5">
        <div class="card rounded-2xl p-6 shadow-xl" style="border:1px solid rgba(255,255,255,.07)">
          <p style="color:#4a5568;font-size:11px;letter-spacing:.08em" class="uppercase font-bold mb-5">รายละเอียดการทดสอบ</p>
          <div style="display:grid;grid-template-columns:1fr 1fr">
            <script>
              const details = [
                ['รหัสการทดสอบ','#0003'],['เครื่องเป่า SN','BRZ-2024-002'],
                ['วันที่ทดสอบ','9 มี.ค. 2568  07:30 น.'],['บันทึกเมื่อ','9 มี.ค. 2568  07:30 น.'],
                ['แก้ไขล่าสุด','9 มี.ค. 2568  07:30 น.'],
              ];
              document.addEventListener('DOMContentLoaded',()=>{
                const g = document.getElementById('detail-grid');
                details.forEach(([k,v])=>{
                  g.innerHTML+=`
                    <div class="flex justify-between py-3.5 px-1" style="border-bottom:1px solid rgba(255,255,255,.05)">
                      <span style="color:#4a5568;font-size:13px">${k}</span>
                      <span style="color:#e2e8f0;font-size:13px;font-family:'JetBrains Mono',monospace">${v}</span>
                    </div>`;
                });
              });
            </script>
            <div id="detail-grid" style="grid-column:span 2"></div>
          </div>
        </div>
       
        <div class="card rounded-2xl p-6 shadow-xl" style="border:1px solid rgba(255,255,255,.07)">
          <p style="color:#4a5568;font-size:11px;letter-spacing:.08em" class="uppercase font-bold mb-4">รูปภาพขณะทดสอบ</p>
          <div style="width:100%;height:160px;border-radius:12px;background:rgba(255,255,255,.03);border:2px dashed rgba(255,255,255,.1);display:flex;flex-direction:column;align-items:center;justify-content:center;color:#4a5568">
            <span style="font-size:40px;margin-bottom:8px">📷</span>
            <p style="font-size:13px">ไม่มีรูปภาพ</p>
          </div>
        </div>
      
        <div class="flex gap-3 justify-end">
          <button style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#c8d0e4;padding:10px 20px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Sarabun',sans-serif">✏️ แก้ไขข้อมูล</button>
          <button style="background:rgba(255,77,109,.1);border:1px solid rgba(255,77,109,.3);color:#ff4d6d;padding:10px 20px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Sarabun',sans-serif">🗑️ ลบข้อมูล</button>
        </div>
      </div>
    </div>
  </div> -->


    <div class="mt-10 max-w-2xl">
      <h2 class="text-black font-extrabold text-xl mb-6 tracking-tight">➕ ฟอร์มบันทึกผลเทสใหม่</h2>
      <div class="card rounded-2xl p-8 shadow-2xl" style="border:1px solid rgba(255,255,255,.07)">
        <div class="mb-5">
          <label style="color:#4a5568;font-size:11px;letter-spacing:.08em;font-weight:700" class="block uppercase mb-2">พนักงาน *</label>
          <select style="width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);border-radius:12px;padding:12px 16px;color:#c8d0e4;font-size:14px;outline:none;font-family:'Sarabun',sans-serif">
            <option>EMP003 — นายวิชัย มั่นคง</option>
          </select>
        </div>
        <div class="mb-5">
          <label style="color:#4a5568;font-size:11px;letter-spacing:.08em;font-weight:700" class="block uppercase mb-2">รหัสเครื่องเป่า (SN) *</label>
          <input type="text" value="BRZ-2024-002" style="width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);border-radius:12px;padding:12px 16px;color:#c8d0e4;font-size:14px;outline:none;font-family:'Sarabun',sans-serif">
        </div>
        <div class="mb-5">
          <label style="color:#4a5568;font-size:11px;letter-spacing:.08em;font-weight:700" class="block uppercase mb-2">ระดับแอลกอฮอล์ (mg/L) *</label>
          <input type="number" value="0.52" style="width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);border-radius:12px;padding:12px 16px;color:#c8d0e4;font-size:14px;outline:none;font-family:'JetBrains Mono',monospace">
          <div class="mt-3 p-3 rounded-xl" style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05)">
            <div class="flex items-center gap-3">
              <div style="flex:1;height:6px;background:rgba(255,255,255,.08);border-radius:99px;overflow:hidden">
                <div style="width:52%;height:100%;background:#ff4d6d;border-radius:99px"></div>
              </div>
              <span class="badge-fail" style="font-size:11px;font-weight:700;padding:2px 10px;border-radius:99px">ไม่ผ่าน</span>
            </div>
          </div>
        </div>
        <div class="mb-5">
          <label style="color:#4a5568;font-size:11px;letter-spacing:.08em;font-weight:700" class="block uppercase mb-2">วันที่และเวลาทดสอบ *</label>
          <input type="datetime-local" value="2025-03-09T07:30" style="width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);border-radius:12px;padding:12px 16px;color:#c8d0e4;font-size:14px;outline:none;font-family:'Sarabun',sans-serif">
        </div>
        <div class="mb-8">
          <label style="color:#4a5568;font-size:11px;letter-spacing:.08em;font-weight:700" class="block uppercase mb-2">รูปภาพขณะทดสอบ</label>
          <div style="border:2px dashed rgba(255,255,255,.1);border-radius:12px;padding:24px;text-align:center;cursor:pointer">
            <p style="font-size:36px;margin-bottom:8px">📷</p>
            <p style="color:#4a5568;font-size:13px">คลิกเพื่ออัปโหลดรูปภาพ</p>
            <p style="color:#374151;font-size:11px;margin-top:4px">PNG, JPG, WEBP (สูงสุด 5MB)</p>
          </div>
        </div>
        <div class="flex gap-3">
          <button class="g-brand text-black font-bold px-6 py-2.5 rounded-xl text-sm" style="border:none;cursor:pointer;font-family:'Sarabun',sans-serif">✅ บันทึกผลเทส</button>
          <button style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#7c88aa;padding:10px 24px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Sarabun',sans-serif">ยกเลิก</button>
        </div>
      </div>
    </div>

  </div><!-- end container -->

</x-app-layout>


<script>
  const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

  function alcoholApp() {






    const now = () => {
      const d = new Date();
      return d.toLocaleTimeString('th-TH', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
    };

    const today = () => new Date().toLocaleDateString('th-TH', {
      day: '2-digit',
      month: 'short',
      year: 'numeric'
    });

    return {
      searchQ: '',
      dateFrom: '',
      dateTo: '',
      selectedUser: null,
      scanning: false,
      scanningIdx: null,
      scanProgress: 0,
      scanMsg: 'กำลังรอสแกน...',
      scanTimer: null,
      confirmClearAll: false,
      confirmDeleteIdx: null,
      enrollAllQueue: [],
      statusFilter: 'all',
      testhist: [],

      async init() {
        await this.fetchUsers();
      },

      get filteredUsers() {
        const q = this.searchQ.toLowerCase().trim();

        return this.testhist.filter(u => {
          const fName = (u.f_name || '').toLowerCase();
          const lName = (u.l_name || '').toLowerCase();
          const userCode = (u.user_code || '').toLowerCase();
          const orgName = (u.org_name || '').toLowerCase();
          const deviceSn = (u.device_sn || '').toLowerCase();
          const alcoholLevel = Number(u.alcohol_level) || 0;

          const matchSearch =
            fName.includes(q) ||
            lName.includes(q) ||
            userCode.includes(q) ||
            orgName.includes(q) ||
            deviceSn.includes(q);

          let matchStatus = true;

          if (this.statusFilter === 'pass') {
            matchStatus = alcoholLevel === 0;
          } else if (this.statusFilter === 'fail') {
            matchStatus = alcoholLevel >= 0.5;
          }

          return matchSearch && matchStatus;
        });
      },

      async fetchUsers() {

        try {

          const response = await fetch(`/api/testacl`);
          const result = await response.json();


          this.testhist = result.data





        } catch (error) {
          console.error("Fetch error:", error);
        } finally {
          this.isLoading = false;
        }
      },

      selectUser(u) {
        this.selectedUser = u;
      },

      getStatus(lvl) {
        if (lvl === 0) return {
          label: 'ผ่าน',
          cls: 'badge-pass',
          color: '#00e5a0'
        };
        if (lvl < 0.5) return {
          label: 'เฝ้าระวัง',
          cls: 'badge-warn',
          color: '#ffc94d'
        };
        return {
          label: 'ไม่ผ่าน',
          cls: 'badge-fail',
          color: '#ff4d6d'
        };
      },

      // คำนวณ % สำหรับ Progress Bar
      getPercent(lvl) {
        return Math.min((lvl / 1) * 100, 100);
      },
      clearDateFilter() {
        this.dateFrom = '';
        this.dateTo = '';
      },

    }

    // selectUser(u) {
    //   this.selectedUser = u;
    // },




  }
</script>