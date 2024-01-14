document.getElementById('nav-link-dashboard').addEventListener('click',(event)=>{
    event.preventDefault()
    window.location.href = "/"
    localStorage.setItem('tag_aktif','dashboard')
    localStorage.setItem('tag1','keuangan')
    localStorage.setItem('tag2','karyawan')
    localStorage.setItem('tag3','persediaan')
    localStorage.setItem('tag4','inventaris')
    
});
document.getElementById('nav-link-keuangan').addEventListener('click',(event)=>{
    event.preventDefault()
    window.location.href = "/keuangan"
    localStorage.setItem('tag_aktif','keuangan')
    localStorage.setItem('tag1','dashboard')
    localStorage.setItem('tag2','karyawan')
    localStorage.setItem('tag3','persediaan')
    localStorage.setItem('tag4','inventaris')
});
document.getElementById('nav-link-karyawan').addEventListener('click',(event)=>{
    event.preventDefault()
    window.location.href = "/karyawan"
    localStorage.setItem('tag_aktif','karyawan')
    localStorage.setItem('tag1','dashboard')
    localStorage.setItem('tag2','keuangan')
    localStorage.setItem('tag3','persediaan')
    localStorage.setItem('tag4','inventaris')
});
document.getElementById('nav-link-persediaan').addEventListener('click',(event)=>{
    event.preventDefault()
    window.location.href = "/persediaan"
    localStorage.setItem('tag_aktif','persediaan')
    localStorage.setItem('tag1','dashboard')
    localStorage.setItem('tag2','keuangan')
    localStorage.setItem('tag3','karyawan')
    localStorage.setItem('tag4','inventaris')    
});
document.getElementById('nav-link-inventaris').addEventListener('click',(event)=>{
    event.preventDefault()
    window.location.href = "/inventaris"
    localStorage.setItem('tag_aktif','inventaris')
    localStorage.setItem('tag1','dashboard')
    localStorage.setItem('tag2','keuangan')
    localStorage.setItem('tag3','karyawan')
    localStorage.setItem('tag4','persediaan')
});


document.getElementById('btnLogout').addEventListener('click',()=>{
    localStorage.removeItem('tag_aktif');
    localStorage.removeItem('tag1');
    localStorage.removeItem('tag2');
    localStorage.removeItem('tag3');
    localStorage.removeItem('tag4');

})

window.addEventListener('load',()=>{
    document.getElementById(`nav-link-${localStorage.getItem('tag_aktif')}`).className= "nav-link d-flex align-items-center gap-2 active"
    document.getElementById(`nav-link-${localStorage.getItem('tag1')}`).className= "nav-link d-flex align-items-center gap-2 "
    document.getElementById(`nav-link-${localStorage.getItem('tag2')}`).className= "nav-link d-flex align-items-center gap-2 "
    document.getElementById(`nav-link-${localStorage.getItem('tag3')}`).className= "nav-link d-flex align-items-center gap-2 "
    document.getElementById(`nav-link-${localStorage.getItem('tag4')}`).className= "nav-link d-flex align-items-center gap-2 "

})
function card_link(href){
    window.location.href = `/${href}`
}
function btn_get(location){
    window.location.href = `/${location}`
}

function tampilModal(content, param){

    var header;
    var footers;
    var modalBodyKeuangan = `<div class="table-responsive small">
    <table class="table table-sm">
        <thead class="text-center">
            <th scope="col" colspan="3">${param[6]}</th>
        </thead>
      <tbody>
        <tr>
          <th scope="row" >Id</th>
          <td>:</td>
          <td>${param[0]}</td>
        </tr>
        <tr>
          <th scope="row" >Nama</th>
          <td>:</td>
          <td>${param[1]}</td>
        </tr>
        <tr>
          <th scope="row" >Tanggal</th>
          <td>:</td>
          <td>${param[2]}</td>
        </tr>
        <tr>
          <th scope="row" >Jumlah</th>
          <td>:</td>
          <td>Rp. ${param[3]}</td>
        </tr>
        <tr>
          <th scope="row" >Keterangan</th>
          <td>:</td>
          <td>${param[4]}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <p>${param[7]}</p>`
    if (content === "pendapatan"){
        content = modalBodyKeuangan;
        footers = `<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i></button><a class="btn btn-success btn-sm" href="/keuangan/pendapatan/edit/${param[0]}" ><i class="bi bi-pencil"></i></a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#mySecondModal" onclick="tampilSecondModal('hapusPemasukan',['${param[0]}',
        '${param[1]}','${param[2]}','${param[3]}','${param[4]}','${param[5]}','Data Pemasukan','apakah anda yakin ingin menghapus data ini?','pendapatan'])" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>`
    }
    if(content === "pengeluaran"){
      content = modalBodyKeuangan;
      footers = `<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i></button><a class="btn btn-success btn-sm" href="/keuangan/pengeluaran/edit/${param[0]}" ><i class="bi bi-pencil"></i></a>
      <a href="#" data-bs-toggle="modal" data-bs-target="#mySecondModal" onclick="tampilSecondModal('hapusPengeluaran',['${param[0]}',
      '${param[1]}','${param[2]}','${param[3]}','${param[4]}','${param[5]}','Data Pengeluaran','apakah anda yakin ingin menghapus data ini?','pengeluaran'])" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>`
    }
    if(content === "kr"){
      content = `<h4 class="mb-0">${param[0]} - ${param[1]}</h4>
      <p>Apa yang ingin Anda lakukan dengan data ini?</p>`
      footers = `<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i></button><a class="btn btn-success btn-sm" href="/karyawan/e/id/${param[0]}" ><i class="bi bi-pencil"></i></a>
      <a href="#" data-bs-toggle="modal" data-bs-target="#mySecondModal" onclick="tampilSecondModal('hapusKaryawan',['${param[0]}','${param[1]}'])" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>`
      
    }if(content === "detailAlamat"){
      content = `<h4 class="mb-0">Detail Alamat</h4>
      <p>${param[0]}</p>`
      footers = `<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i></button>`
    }
    if(content == "hapusDataBahan"){
      content = `<h4 class="mb-0">Hapus Data Bahan</h4>
      <p>${param[0]}</p>`
      footers = `<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-arrow-90deg-left"></i></button>
      <a href="/persediaan/bahan/del/${param[1]}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>`
    }
    document.querySelector(".modal-body").innerHTML = content;
    document.getElementById('modal-footer').innerHTML = footers
    $('myModal').modal('show');
}
function tampilSecondModal(content, param){
  var link;
  var footer = `<button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" data-bs-dismiss="modal">Batal</button>
  <a href="/keuangan/${param[8]}/hapus/${param[0]}" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 ">Hapus</a>`;
  const body = `<div class="table-responsive small">
  <table class="table table-sm">
      <thead class="text-center">
      
          <th scope="col" colspan="3">${param[6]}</th>
      </thead>
    <tbody>
      <tr>
        <th scope="row" >Id</th>
        <td>:</td>
        <td>${param[0]}</td>
      </tr>
      <tr>
        <th scope="row" >Nama</th>
        <td>:</td>
        <td>${param[1]}</td>
      </tr>
      <tr>
        <th scope="row" >Tanggal</th>
        <td>:</td>
        <td>${param[2]}</td>
      </tr>
      <tr>
        <th scope="row" >Jumlah</th>
        <td>:</td>
        <td>Rp. ${param[3]}</td>
      </tr>
      <tr>
        <th scope="row" >Keterangan</th>
        <td>:</td>
        <td>${param[4]}</td>
      </tr>
    </tbody>
  </table>
</div>
<p>${param[7]}</p>`
  if(content == "hapusPemasukan"){
    document.getElementById('mySecondModalFooter').className = "modal-footer flex-nowrap p-0"
    content = body;
    
  }
  if(content == "hapusPengeluaran"){
    document.getElementById('mySecondModalFooter').className = "modal-footer flex-nowrap p-0"
    content = body;
  }
  if(content == 'hapusKaryawan'){
    document.getElementById('mySecondModalFooter').className = "modal-footer flex-nowrap p-0"
    content = `<h4 class="mb-0">${param[0]} - ${param[1]}</h4>
    <p>Apakah Anda yakin ingin mengahpus data ini?</p>`
    footer = `<button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" data-bs-dismiss="modal">Batal</button>
    <a href="/karyawan/del/id/${param[0]}" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 ">Hapus</a>`
  }
  if(content == 'hapusRekapAbs'){
    document.getElementById('mySecondModalFooter').className = "modal-footer flex-nowrap p-0"
    content = `<h4 class="mb-0">ID Absensi : ${param[0]}</h4>
    <p>Detail : ${param[1]}</p>
    <p>Apakah Anda yakin ingin mengahpus data ini?</p>`
    footer = `<button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" data-bs-dismiss="modal">Batal</button>
    <a href="/karyawan/rekap/hapus/${param[0]}" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 ">Hapus</a>`
  }
  
  document.getElementById("mySecondModalBody").innerHTML = content;
  document.getElementById('mySecondModalFooter').innerHTML = footer;
  $('mySecondModal').modal('show');
}
function btn_sort(param){
  window.location.href = `/${param}`
}

document.getElementById('selectKaryawan').addEventListener('input',(e)=>{
  var formData = new FormData(document.getElementById('formSelectKaryawan'));
  const selected = formData.get('id_karyawan');
  window.location.href = `/karyawan/e/id/${selected}`;
});
//onclick="tampilModal('editRekapAbs',['{{$item->id_karyawan}}','{{$item->nama}}','{{$item->posisi}}','{{$item->tanggal}}','{{$item->jam_masuk}}','{{$item->jam_keluar}}','{{$token}}','{{$item->id_absensi}}'])" 


document.getElementById('').addEventListener('input',()=>{
  
})