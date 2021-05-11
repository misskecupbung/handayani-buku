//[ HALAMAN ADMIN ]--------------------------------------------------------------------------------------//

//** ADMIN BERANDA */////////////////////////////////////////////////////////////////////////

//** Implementasi pace terhadap ajax request */

$(document).ajaxStart(function () {
    Pace.restart()
})

//** Memberikan class active ke navbar sesuai url */

var url = window.location;

$('ul.sidebar-menu a').filter(function() {

     return this.href == url;

}).parent().addClass('active');

$('ul.treeview-menu a').filter(function() {

     return this.href == url;

}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');


//** Sidebar value counter */

$(document).ready(function(){
    $.get('http://'+url.host+'/admin/sidebar_counter').done(function(data){
        var ids = ['buku', 'kategori', 'penerbit', 'pengguna', 'admin', 'pesanan', 'pembayaran', 'pengiriman'];
        for(var index = 0; index < ids.length; index++) {
            $('#jml_'+ids[index]).html(data[index])
        }
    })
})



//** ADMIN PRODUK *///////////////////////////////////////////////////////////////////////////

//** Detail Buku */
$('a.detail_buku').click(function(){
    let id = this.id
    $.get('http://'+url.host+'/admin/get_buku/'+$('#id_'+id).html())
    .done(function(data){
        $('h3.modal-title').html('Detail Buku - '+data['id_buku'])
        $('img#foto_buku').attr('src', 'http://'+url.host+'/storage/buku/'+data['foto_buku'])
        $('img#foto_buku').attr('alt', data['judul_buku'])
        $('h4#judul_buku').html(data['judul_buku'])
        $('h4#penulis_buku').html(data['penulis_buku'])
        $('h4#nama_kategori').html(data['nama_kategori'])
        $('h4#nama_penerbit').html(data['nama_penerbit'])
        $('h4#bahasa_buku').html(data['bahasa_buku'])
        $('h4#format_buku').html(data['format_buku'])
        $('h4#dimensi_buku').html(data['dimensi_buku'])
        $('h4#ISBN').html(data['ISBN'])
        $('h4#jumlah_halaman').html(data['jumlah_halaman'])
        $('h4#tanggal_terbit').html(data['tanggal_terbit'])
        $('h4#berat_buku').html(data['berat_buku'])
        $('h4#harga_satuan').html(data['harga_satuan'])
        $('h4#stok_buku').html(data['stok_buku'])
        $('h4#deskripsi_buku').html(data['deskripsi_buku'])
    })
})

//** Edit Buku */

$('a.edit_buku').click(function(){
    let id = this.id
    $.get('http://'+url.host+'/admin/get_buku/'+$('#id_'+id).html())
    .done(function(data){
        $('h4.modal-title').html('Edit Buku - #'+data['id_buku'])
        $('form#form_edit_buku').attr('action','http://'+url.host+'/admin/edit_buku/'+data['id_buku'])
        $('input#inp_edit_judul_buku').val(data['judul_buku'])
        $('input#inp_edit_penulis_buku').val(data['penulis_buku'])
        $('select#inp_edit_id_kategori option[value*="'+data['id_kategori']+'"]').attr('selected', 'selected')
        $('select#inp_edit_id_penerbit option[value*="'+data['id_penerbit']+'"]').attr('selected', 'selected')
        $('input#inp_edit_bahasa_buku').val(data['bahasa_buku'])
        $('input#inp_edit_format_buku').val(data['format_buku'])
        $('input#inp_edit_dimensi_buku').val(data['dimensi_buku'])
        $('input#inp_edit_ISBN').val(data['ISBN'])
        $('input#inp_edit_jumlah_halaman').val(data['jumlah_halaman'])
        $('input#inp_edit_tanggal_terbit').val(data['tanggal_terbit'])
        $('input#inp_edit_berat_buku').val(data['berat_buku'])
        $('input#inp_edit_harga_satuan').val(data['harga_satuan'])
        $('input#inp_edit_stok_buku').val(data['stok_buku'])
        let foto_url = 'http://'+url.host+'/storage/buku/'
        $('img#foto_buku').attr('src', foto_url+data['foto_buku'])
        $('img#foto_buku').attr('alt', data['judul_buku'])
        CKEDITOR.instances['inp_edit_deskripsi_buku'].setData(data['deskripsi_buku'])
    })
})

//** Hapus Buku */

$('a.hapus_buku').click(function(){
    let id = this.id
    $.get('http://'+url.host+'/admin/get_buku/'+$('#id_'+id).html())
    .done(function(data){
        $('h5.modal-title').html('Anda yakin ingin menghapus buku "'+data['judul_buku']+'" ?')
    })
    $('form#form_hapus_buku').attr('action','http://'+url.host+'/admin/hapus_buku/'+$('#id_'+this.id).html())
})




//** ADMIN penebit *///////////////////////////////////////////////////////////////////////////

//** Check nama penerbit */

$('button#check_penerbit').click(function(){
    var value = $('input#inp_nama_penerbit').val()
    $('span.help-block').remove()
    if(value != '') {
        $.get('http://'+url.host+'/admin/check_penerbit', {nama_penerbit: value}, function(data) {
            console.log($.parseJSON(data))
            if ($.parseJSON(data) == false) {
                $('button#simpan').removeClass('disabled').attr('type', 'submit')
                $('input#inp_nama_penerbit').parent().removeClass().addClass('form-group has-success')
                $('input#inp_nama_penerbit').after('<span class="help-block">Penerbit dapat digunakan !</span>')
            } else {
                $('#simpan').addClass('disabled').attr('type', 'button')
                $('input#inp_nama_penerbit').parent().removeClass().addClass('form-group has-warning')
                $('input#inp_nama_penerbit').after('<span class="help-block">Penerbit tidak dapat digunakan karena telah tersedia !</span>')
            }
        })
    } else {
        $('button#simpan').addClass('disabled').attr('type', 'button')
        $('input#inp_nama_penerbit').parent().removeClass().addClass('form-group has-error')
        $('input#inp_nama_penerbit').after('<span class="help-block">Value belum di isi !</span>')
    }
})

//** Edit penerbit */

$('a.edit_penerbit').click(function(){
    $('h4.modal-title').html('Edit Penerbit - #'+$('#id_'+this.id).html())
    $('form#form_edit_penerbit').attr('action','http://'+url.host+'/admin/edit_penerbit/'+$('td#id_'+this.id).html())
    $('input.id_penerbit').val($('td#id_'+this.id).html())
    $('input.nama_penerbit').val($('td#nama_'+this.id).html())
})

//** Hapus penerbit */
$('a.hapus_penerbit').click(function(){
    $('form#form_hapus_penerbit').attr('action','http://'+url.host+'/admin/hapus_penerbit/'+$('td#id_'+this.id).html())
})




//** ADMIN KATEGORI *///////////////////////////////////////////////////////////////////////////

//** Check nama kategori */

$('button#check_kategori').click(function(){
    var value = $('input#inp_nama_kategori').val()
    $('span.help-block').remove()
    if(value != '') {
        $.get('http://'+url.host+'/admin/check_kategori', {nama_kategori: value}, function(data) {
            console.log($.parseJSON(data))
            if ($.parseJSON(data) == false) {
                $('button#simpan').removeClass('disabled').attr('type', 'submit')
                $('input#inp_nama_kategori').parent().removeClass().addClass('form-group has-success')
                $('input#inp_nama_kategori').after('<span class="help-block">Kategori dapat digunakan !</span>')
            } else {
                $('#simpan').addClass('disabled').attr('type', 'button')
                $('input#inp_nama_kategori').parent().removeClass().addClass('form-group has-warning')
                $('input#inp_nama_kategori').after('<span class="help-block">Kategori tidak dapat digunakan karena telah tersedia !</span>')
            }
        })
    } else {
        $('button#simpan').addClass('disabled').attr('type', 'button')
        $('input#inp_nama_kategori').parent().removeClass().addClass('form-group has-error')
        $('input#inp_nama_kategori').after('<span class="help-block">Value belum di isi</span>')
    }
})



//** Edit kategori */

$('a.edit_kategori').click(function(){
    $('h4.modal-title').html('Edit Kategori - #'+$('#id_'+this.id).html())
    $('form#form_edit_kategori').attr('action','http://'+url.host+'/admin/edit_kategori/'+$('#id_'+this.id).html())
    $('input.id_kategori').val($('#id_'+this.id).html())
    $('input.nama_kategori').val($('#nama_'+this.id).html())
})

//** Hapus kategori */

$('a.hapus_kategori').click(function(){
    $('form#form_hapus_kategori').attr('action','http://'+url.host+'/admin/hapus_kategori/'+$('#id_'+this.id).html())
})




//** SUPERADMIN : ADMIN *///////////////////////////////////////////////////////////////////////////

//** Edit Status Admin */

$('a.ubah_status_admin').click(function(){
    $('form#form_edit_status_admin').attr('action','http://'+url.host+'/admin/superadmin/ubah_status_admin/'+$('#id_'+this.id).html())
    let id_admin = $('td#id_'+this.id).html()
    $.get('http://'+url.host+'/admin/superadmin/get_admin/'+id_admin).done(function(data){
        $('select#inp_edit_status_admin option[value*="'+data['superadmin']+'"]').attr('selected', 'selected')
    })
})

//** Hapus Admin */

$('a.hapus_admin').click(function(){
    $('form#form_hapus_admin').attr('action','http://'+url.host+'/admin/superadmin/hapus_admin/'+$('#id_'+this.id).html())
})

//** Profile Admin */

$('a.detail_admin').click(function(){
    let id_admin = $('td#id_'+this.id).html()
    $.get('http://'+url.host+'/admin/superadmin/get_admin/'+id_admin).done(function(data){
        $('h4.modal-title').html('Detail Akun '+data['nama_lengkap'])
        $('img#foto').attr('src', 'http://'+url.host+'/storage/avatars/admin/'+data['foto'])
        $('img#foto').attr('alt', data['nama_lengkap'])
        $('p#nama_lengkap').html(data['nama_lengkap'])
        $('p#email').html(data['email'])
        $('p#tanggal').html(data['tanggal_bergabung'])
        if(data['diblokir']){
            $('span#blokir').addClass('bg-green').html(
                '<i class="fa fa-check fa-fw"></i> Ya'
            )
        } else {
            $('span#blokir').addClass('bg-red').html(
                '<i class="fa fa-close fa-fw"></i> Tidak'
            )
        }
        if(data['superadmin']){
            $('span#superadmin').addClass('bg-green').html(
                '<i class="fa fa-user fa-fw"></i> Admin'
            )
        } else {
            $('span#superadmin').addClass('bg-red').html(
                '<i class="fa fa-user fa-fw"></i> Kasir'
            )
        }

    })
})



//** SUPERADMIN : PENGGUNA *///////////////////////////////////////////////////////////////////////////

//** Hapus Pengguna */

$('a.hapus_pengguna').click(function(){
    $('form#form_hapus_pengguna').attr('action','http://'+url.host+'/admin/superadmin/hapus_pengguna/'+$('#id_'+this.id).html())
})

//** Profile Pengguna */

$('a.detail_pengguna').click(function(){
    let id_admin = $('td#id_'+this.id).html()
    $.get('http://'+url.host+'/admin/superadmin/get_pengguna/'+id_admin).done(function(data){
        $('h4.modal-title').html('Detail Akun '+data['nama_lengkap'])
        $('img#foto').attr('src', 'http://'+url.host+'/storage/avatars/pengguna/'+data['foto_pengguna'])
        $('img#foto').attr('alt', data['nama_lengkap'])
        $('p#id_pengguna').html(data['id_pengguna'])
        $('p#nama_lengkap').html(data['nama_lengkap'])
        $('p#jenis_kelamin').html(data['jenis_kelamin'])
        $('p#email').html(data['email'])
        $('p#tanggal').html(data['tanggal_bergabung'])
        $('p#no_telepon').html(data['no_telepon'])
        $('p#alamat_rumah').html(data['alamat_rumah'])
        if(data['diblokir']){
            $('span#blokir').addClass('bg-green').html(
                '<i class="fa fa-check fa-fw"></i> Ya'
            )
        } else {
            $('span#blokir').addClass('bg-red').html(
                '<i class="fa fa-close fa-fw"></i> Tidak'
            )
        }
    })
})





//** ADMIN PEMBAYARAN *///////////////////////////////////////////////////////////////////////////

//** Proses Pembayaran */

$('button.proses_pembayaran').click(function(){
    $('form#form_proses_pembayaran').attr('action','http://'+url.host+'/admin/transaksi/pembayaran/status/'+$('td#id_'+this.id).html())
})

//** Lihat Bukti Pembayaran */

$('button.lihat_foto').click(function(){
    let id = this.id
    $.get('http://'+url.host+'/admin/transaksi/get_pembayaran/'+$('#id_'+id).html())
    .done(function(foto){
        $('img#foto_bukti').attr('src', 'http://'+url.host+'/storage/pembayaran/'+foto['foto_bukti'])
    })
})

// $('button.lihat_foto').click(function(){
//     $('img#foto_bukti').attr('src', 'http://'+url.host+'/storage/pembayaran/'+$('td#id_'+this.id).html()+'.jpg')
// })

//** ADMIN PESANAN *///////////////////////////////////////////////////////////////////////////

//** Proses Pesanan */

$('a.proses_pesanan').click(function(){
    $('form#form_proses_pesanan').attr('action','http://'+url.host+'/admin/transaksi/proses_pesanan/'+$('td#id_'+this.id).html())
})

//** Rubah Infomasi Penerima */
$('a.edit_pesanan').click(function() {
    $('form#form_edit_pesanan').attr('action','http://'+url.host+'/admin/transaksi/edit_pesanan/'+$('td#id_'+this.id).html())
    $.get('http://'+url.host+'/admin/transaksi/get_penerima/'+$('td#id_'+this.id).html())
    .done(function(data){
        $('input#inp_nama_penerima').val(data.nama_penerima)
        $('textarea#inp_alamat_tujuan').val(data.alamat_tujuan)
        $('input#inp_no_telepon').val(data.no_telepon)
    })
})

//** Kirim Pesanan */

$('a.kirim_pesanan').click(function(){
    $('form#form_kirim_pesanan').attr('action','http://'+url.host+'/admin/transaksi/kirim_pesanan/'+$('td#id_'+this.id).html())
})

//** Batalkan Pesanan */

$('a.batalkan_pesanan').click(function(){
    $('form#form_batalkan_pesanan').attr('action','http://'+url.host+'/admin/transaksi/batalkan_pesanan/'+$('td#id_'+this.id).html())

})

//** Hapus Pesanan */

$('a.hapus_pesanan').click(function(){
    $('form#form_hapus_pesanan').attr('action','http://'+url.host+'/admin/transaksi/hapus_pesanan/'+$('td#id_'+this.id).html())

})

//** Lihat Bukti Pembayaran */

// $('button.lihat_foto').click(function(){
//     $('img#foto_bukti').attr('src', 'http://'+url.host+'/storage/pembayaran/'+$('td#id_'+this.id).html()+'.jpg')
// })

$('button.lihat_foto').click(function(){
    let id = this.id
    $.get('http://'+url.host+'/admin/transaksi/get_pembayaran/'+$('#id_'+id).html())
    .done(function(foto){
        $('img#foto_bukti').attr('src', 'http://'+url.host+'/storage/pembayaran/'+foto['foto_bukti'])
    })
})


//** ADMIN PENGIRIMAN *///////////////////////////////////////////////////////////////////////////

//** Pesanan Selesai */

$('button.pesanan_selesai').click(function(){
    $('form#form_pesanan_selesai').attr('action','http://'+url.host+'/admin/transaksi/selesai/'+$('td#id_'+this.id).html())
})
