// const { isNull } = require("lodash");

$('#barcode').keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        var barcode = $("#barcode").val();
        // alert(barcode);

        $.ajax({
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/kasir/tambah_barang_barcode',
            data: {
                id_produk: barcode
            },
            success: function (data) {
                barcode = $("#barcode").val("");
                show_list();
            },
            error: function (request, status, error) {
                alert(error);
            }
        });
    }

    event.stopPropagation();

});


//function show all product
function show_list() {
    $('#tabel_list').DataTable({
        paging: false,
        destroy: true,
        "ordering": false,
        "info": false,
        searching: false,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/kasir/get_list",
            type: 'GET'
        },
        columns: [{
                "data": null,
                "sortable": false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'nama_produk'
            },
            {
                data: 'harga_jual'
            },

            {
                data: null,
                render: function (data, type, row) {
                    return `<input type="number" min="0" class="form-control" id="` + data.id_transaksi_temp + `" value="` + data.jumlah + `"
                    class="qty" onChange="ubah_qty(this.id, this.value)">`;
                }
            },
            {
                data: 'total_harga'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `<button id="` + data.id_transaksi_temp + `" class="btn text-danger bg-danger-transparent btn-icon" onClick="list_delete(this.id)"><span class="bi bi-trash fs-16"></span></button>`;
                }
            },
        ],
        columnDefs: [{
            "targets": [2, 4],
            render: $.fn.dataTable.render.number(',', '.', ),
            "className": "text-right",
        }],
        language: {
            "emptyTable": "Belum ada belanjaan pada keranjang",
        }
    });

    $("#total_harga").load(window.location.href + " #total_harga");
    $("#total_harga2").load(window.location.href + " #total_harga2");
    $("#total_belanja").load(window.location.href + " #total_belanja");
    $("#total_harga3").load(window.location.href + " #total_harga3");
}

function ubah_qty(id, jml) {

    $.ajax({
        type: 'post',
        url: '/kasir/ubah_qty',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: true,
        data: {
            id: id,
            jml: jml,
        },
        success: function (response) {
            show_list();
        },
        error: function (request, status, error) {
            alert('Gagal diubah!')
        }
    });
}


function list_delete(clicked_id) {
    $.ajax({
        url: "/kasir/del_list",
        type: 'get',
        data: {
            "id": clicked_id
        },
        success: function (response) {
            show_list();
        },
        error: function (request, status, error) {
            alert('Gagal dihapus!')
        }
    });
}


function print_ulang_ini(clicked_id) {
    $.ajax({
        url: "/kasir/print_faktur_2",
        type: 'get',
        data: {
            "id": clicked_id
        },
    });
}

function show_produk() {
    $.ajax({
        type: 'post',
        url: '/kasir/get_produk',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: true,
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            var html = '';
            var i;
            arr_num = data.length;
            for (i = 0; i < data.length; i++) {
                html += `<div class="col-3">
					<button class="card text-white bg-primary" style="place-items: center;" id="btn` + i + `" value="` + data[i].id_produk + `" onclick = "add_produk(this)" >
						<div class="card-body" style="margin:-7px; margin-top:-10px;">
							<p class="card-text" style="font-size: 13px; font-weight: bold;">` + data[i].nama_produk + `</p>
							<span class="bg-light p-2" style="color: black;border-radius: 5px;font-size: 11px;">Rp. ` + number(data[i].harga_jual) + `</span>
						</div>
					</button>
				</div>`;
            }
            $('#show_produk').html(html);

        }
    });
}


function show_search(id) {
    var key = $(id).val();
    // console.log(key);

    $.ajax({
        type: 'post',
        url: '/kasir/cari_produk',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "key": key
        },
        async: true,
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            var html = '';
            var i;
            arr_num = data.length;
            for (i = 0; i < data.length; i++) {
                html += `<div class="col-3">
					<button class="card text-white bg-primary" id="btn` + i + `" value="` + data[i].id_produk + `" onclick = "add_produk(this)" >
						<div class="card-body" style="margin:-7px; margin-top:-10px;">
							<p class="card-text text-center"
								style="font-size: 13px; font-weight: bold;">` + data[i].nama_produk + `</p>
							<span class="bg-light p-2"
								style="color: black;border-radius: 5px;font-size: 11px;">Rp.
								` + number(data[i].harga_jual) + `</span>
						</div>
					</button>
				</div>`;
            }
            $('#show_produk').html(html);
            document.getElementById("select-kategori").selected = true;
        }

    });
}

function show_kat(id) {
    var id_kat = $(id).val();
    // console.log(id_kat);
    $.ajax({
        type: 'post',
        url: '/kasir/cari_kategori',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "key": id_kat
        },
        async: true,
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            arr_num = data.length;
            for (i = 0; i < data.length; i++) {
                html += `<div class="col-3">
					<button class="card text-white bg-primary" id="btn` + i + `" value="` + data[i].id_produk + `" onclick = "add_produk(this)" >
						<div class="card-body" style="margin:-7px; margin-top:-10px;">
							<p class="card-text text-center"
								style="font-size: 13px; font-weight: bold;">` + data[i].nama_produk + `</p>
							<span class="bg-light p-2"
								style="color: black;border-radius: 5px;font-size: 11px;">Rp.
								` + number(data[i].harga_jual) + `</span>
						</div>
					</button>
				</div>`;
            }
            $('#show_produk').html(html);
        }

    });
}

function add_produk(id) {
    var id_produk = $(id).val();
    // alert("Produk Berhasil Ditambahkan ke Keranjang !!!")
    // console.log(id_produk);
    $.ajax({
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/kasir/tambah_barang',
        data: {
            id_produk: id_produk
        },
        success: function (data) {
            show_list();
        }
    });
}

function delete_produk(id) {
    var id_temp = $(id).val();

    var x = confirm("Apakah Produk Ini Ingin Dihapus Dari Daftar Belanjaan ?");
    if (x) {
        $.ajax({
            type: 'post',
            url: 'pos/delete_list',
            data: {
                id: id_temp
            },
            success: function (data) {
                show_list();
            }
        });
    } else {
        return false;
    }
}


function showKembali(str) {
    var total = $('#total_harga2').text().replace(",", "").replace(",", "");
    var potong = $('#potongan_ins').val().replace(",", "").replace(",", "");
    var bayar = str.replace(",", "").replace(",", "");

    if ($('#potongan_ins').val().length === 0) {
        potong = 0;
    }

    var kembali = bayar - total + parseInt(potong);

    // console.log(kembali, bayar, total, potong);
    $('#kembalian').text(number(kembali));
    $('#kembalian2').html("Rp." + number(kembali));

    $('#kembalian2').val(number(kembali));

    if (kembali >= 0) {
        $('#btn_bayar').removeAttr("disabled");
    } else {
        $('#btn_bayar').attr("disabled", "disabled");
        $("#kembalian").text("Belum cukup!");
    }

}


// function btnPrice(val) {
//     var bayar = $('#tunai').val();
//     var tunai = bayar.replace(",", "").replace(",", "");

//     if (tunai == "") {
//         tunai = 0;
//     }
//     var tunai2 = parseInt(tunai);
//     var val2 = parseInt(val);
//     tunai2 += val2;


//     console.log(tunai2, val2);
//     $('#tunai').val(number(tunai2));

//     showKembali(number(tunai2));

// }

function btnClear() {
    $('#tunai').val("0");
    showKembali("0");
}


function number(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}
